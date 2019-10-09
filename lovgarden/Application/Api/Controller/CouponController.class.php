<?php
namespace Api\Controller;
use Think\Controller\RestController;
use Think\Cache\Driver\Memcache;
class CouponController extends RestController {
   //获取当前可用的优惠券
   public function getAvailableCoupons($coupon_id = 0) {
      $nowday = date("Y-m-d H:i:s");
      $sql = "select * from lovgarden_coupon where type = '1' and deadline >"."'".$nowday."'";
      $model = new \Think\Model();
      $data = $model->query($sql);
      echo json_encode(array(
          'availableCoupons'=> $data
      ),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
   }
   //用户获得优惠券1用户处于登录状态2用户符合该优惠券的所需条件 小程序端
   public function userTakeCoupon($login_ip,$telephone=0,$coupon_id=0,$userpoints=0,$pay_cost=0) {
       //1验证用户是否登录
       $login_status = 404; //404 没有登录, 200登录状态
       $open_id = '0'; //0 表示没有
       $user_coupon_insert = 0; //0 原始状态 1 给用户新增了优惠券 2 该优惠券用户已经有了
       $user_condition = 0; //0 原始状态 1 条件满足  2条件不满足
       $user_telephone = $telephone;
       $coupon_expire = 1;//0没有过期,1过期
  
       //检查是否登录
       if(!empty($login_ip)){
           $mem_cache = new Memcache();
           $login_exist = $mem_cache->get($login_ip);
           if(!empty($login_exist)){
               $open_id = $login_exist;
               $login_status = 200;
           }
           else {
               exit();
           }
       }
       else {
           exit();
       }
       
       //检查当前优惠券是否过期
       $nowday = date("Y-m-d H:i:s");
       $sql = "select id from lovgarden_coupon where deadline >"."'".$nowday."' and coupon_id = $coupon_id";
       $model = new \Think\Model();
       $data = $model->query($sql);
       if(!empty($data)) {
           $coupon_expire = 0;
       }
       //当用户处于登录状态,电话号码存在,并且该优惠券也没过期的情况下
       if($login_status == 200 && $user_telephone != 0 && $coupon_expire == 0) {
           $sql = "SELECT * FROM lovgarden_coupon_condition WHERE coupon_id = $coupon_id";
           //$model = new \Think\Model();
           $data = $model->query($sql);
           if(!empty($data)) {
             $condition_user_points = $data[0]["user_points"];
             $condition_pay_cost = $data[0]["pay_cost"];
             if($pay_cost >= $condition_pay_cost && $userpoints >= $condition_user_points) {
                $user_condition = 1;
             }
             else {
                 $user_condition = 2;
             }
           }
           //在条件表没有找到条件,也就是可以领取
           else {
               $user_condition = 1;
           }
           //在满足领取优惠券的条件下查看用户是否已经有了优惠券
           if($user_condition == '1') {
               $sql2 = "SELECT id FROM lovgarden_user_coupon WHERE open_id = '".$open_id."' and coupon_id = '".$coupon_id."'" ;
               $coupon_user_exist = $model->query($sql2);
               if(empty($coupon_user_exist)) {
                   //说明该用户可以领取这个优惠券,需要插入数据
                   //这里处理代码
                   $sql_insert = "INSERT INTO lovgarden_user_coupon (coupon_id,user_telephone,open_id) VALUES ('$coupon_id','$telephone','$open_id')";
                   $model_execute = new \Think\Model();
                   $data_insert = $model_execute->execute($sql_insert);
                   if(data_insert) {
                     $user_coupon_insert = 1;
                   }
               }
               else {
                   //说明该用户已经有了该优惠券,不需要插入数据
                   $user_coupon_insert = 2;
               }
           }
       }
       echo json_encode(array(
          'login_status' => $login_status,
          'user_coupon_insert' => $user_coupon_insert,
          'user_condition' => $user_condition,
          'user_telephone' => $user_telephone,
          'coupon_expire' => $coupon_expire
       ),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
       
   }
   //获取我的当前优惠券,可用,过期,和已使用分开(1有效,2已过期,3已使用)
   public function myCoupons($login_ip) {
       $login_status = 404;
       $open_id = 0;
       $avialable_coupons = array();
       $expired_coupons = array();
       $used_coupons = array();
       if(!empty($login_ip)){
           $mem_cache = new Memcache();
           $login_exist = $mem_cache->get($login_ip);
           if(!empty($login_exist)){
               $open_id = $login_exist;
               $login_status = 200;
           }
       }
       if($login_status == 200) {
           //$sql = "SELECT * FROM lovgarden_user_coupon WHERE open_id = '$open_id'";
           $sql = "SELECT a.coupon_id , a.user_telephone , a.coupon_status , b.coupon_value , b.deadline , b.coupon_image , b.coupon_choose_image , b.coupon_expire_image , b.coupon_use_image , b.min_pay FROM lovgarden_user_coupon AS a LEFT JOIN lovgarden_coupon AS b ON a.coupon_id = b.coupon_id  WHERE open_id = '$open_id'";
           $model = new \Think\Model();
           $data = $model->query($sql);
           if(!empty($data)) {
               foreach ($data as $key => $value) {
                 if($value["coupon_status"] == '1') {
                     $avialable_coupons[] = $value;
                 }
                 elseif ($value["coupon_status"] == '2') {
                     $expired_coupons[] = $value;
                 }
                 else {
                     $used_coupons[] = $value;
                 }
               }
           }
       }
       echo json_encode(array(
          'login_status' => $login_status,
          'avialable_coupons' => $avialable_coupons,
          'expired_coupons' => $expired_coupons,
          'used_coupons' => $used_coupons
       ),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
   }
   //配合服务器的定时任务将用户表中的优惠券做过期处理
   public function checkAndExpireUserCoupons() {
       $ip = getIP();
       if($ip == '127.0.0.1' || $ip == '47.98.216.142' || $ip == '172.16.207.38') {
           //对数据表进行操作
          $nowday = date("Y-m-d H:i:s");
          $sql = "select * from lovgarden_coupon where deadline <"."'".$nowday."'";
          $model = new \Think\Model();
          $data = $model->query($sql);
          $expired_coupons = array();
          if(!empty($data)) {
             foreach($data as $key => $value) {
               $expired_coupons[] = $value['coupon_id'];
             }
             $expired_coupons_string = implode(',', $expired_coupons);
             $sql = "UPDATE lovgarden_user_coupon SET coupon_status = '2' WHERE coupon_id IN ($expired_coupons_string) and coupon_status = '1'";
             $result = $model->execute($sql);
             if($result !== FALSE) {
                 //记录log
                 file_put_contents('/cron.log',date('Y-m-d H:i:s',time())." Update Coupons Status In User-Coupons Table . Number:".$result.PHP_EOL,FILE_APPEND);
             }
          }   
       }
   }
   //配合服务器的定时任务将用户表中已过期一个月的优惠券删除
   public function checkAndDeleteLongExpiredUserCoupons() {
       $ip = getIP();
       if($ip == '127.0.0.1' || $ip == '47.98.216.142' || $ip == '172.16.207.38') {
           //对数据表进行操作
          //$nowday = date("Y-m-d H:i:s");
          $sql = "SELECT * FROM lovgarden_coupon e WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) >= DATE(deadline)";
          $model = new \Think\Model();
          $data = $model->query($sql);
          $expired_coupons = array();
          if(!empty($data)) {
             foreach($data as $key => $value) {
               $expired_coupons[] = $value['coupon_id'];
             }
             $expired_coupons_string = implode(',', $expired_coupons);
             $sql = "DELETE FROM lovgarden_user_coupon WHERE coupon_id IN ($expired_coupons_string)";
             $result = $model->execute($sql);
             if($result !== FALSE) {
                 //记录log
                 file_put_contents('/cron.log',date('Y-m-d H:i:s',time())." DELETE 7 DAYS Expired Coupons In User-Coupons Table . Number:".$result.PHP_EOL,FILE_APPEND);
             }
          }   
       }   
   }
   public function userTakeCompanyCoupon($login_ip= '0',$telephone=0,$company_name='',$company_code='') {
       //1验证用户是否登录
       $login_status = 404; //404 没有登录, 200登录状态
       $open_id = '0'; //0 表示没有
       $user_coupon_insert = array(); //0 原始状态 1 给用户新增了优惠券 2 该优惠券用户已经有了 3该优惠券已经达到最大领取上限
       $user_condition = 0; //0 原始状态 1 条件满足  2条件不满足
       $user_telephone = $telephone;
       $coupon_exist = 0; //0 不存在 1 存在
       $company_name = I('get.company_name');
       $company_code = I('get.company_code');
       $coupon_image = array();
       
       if($company_name == '' || $company_code == '') {
          $company_name = 'none';
          $company_code = 'none';
       }
       //echo $company_code;
       //exit();
       //检查是否登录
       if($login_ip!='0' && $user_telephone != 0){
           $mem_cache = new Memcache();
           $login_exist = $mem_cache->get($login_ip);
           if(!empty($login_exist)){
               $open_id = $login_exist;
               $login_status = 200;
               //检查当前优惠券是否过期
               $nowday = date("Y-m-d H:i:s");
               //$sql = "select id , coupon_id , coupon_number from lovgarden_coupon where type='2' and company_name = '$company_name' and company_code = '$company_code' and deadline >"."'".$nowday."'";
               $model = new \Think\Model();
               //$model->query('select * from user where id=%d and status=%d',$id,$status);
               //$Model->query("SELECT * FROM think_user WHERE id=%d and username='%s' and xx='%f'",array($id,$username,$xx));
               $data = $model->query("select id , coupon_id , coupon_image, coupon_number from lovgarden_coupon where type='2' and company_name = '%s' and company_code = '%s' and deadline >'%s'",array($company_name,$company_code,$nowday));
               if(!empty($data)) {
                  $coupon_exist = 1;
                  foreach ($data as $key => $value) {
                      $coupon_id = $value['coupon_id'];
                      $coupon_number = $value['coupon_number'];
                      if($coupon_number > 0) {
                        $sql2 = "SELECT id FROM lovgarden_user_coupon WHERE open_id = '".$open_id."' and coupon_id = '".$coupon_id."'" ;
                        $coupon_user_exist = $model->query($sql2);
                        if(empty($coupon_user_exist)) {
                         //说明该用户可以领取这个优惠券,需要插入数据
                           //$sql_insert = "INSERT INTO lovgarden_user_coupon (coupon_id,user_telephone,open_id) VALUES ('$coupon_id','$telephone','$open_id')";
                           $data_insert = $model->execute("INSERT INTO lovgarden_user_coupon (coupon_id,user_telephone,open_id) VALUES ('%s','%s','%s')",array($coupon_id,$telephone,$open_id));
                           if(data_insert) {
                               $user_coupon_insert[] = array('coupon_id' => $coupon_id,'user_coupon_insert'=>'1');
                               $coupon_image[] = $value['coupon_image'];
                               $model->execute("update lovgarden_coupon set coupon_number = coupon_number - 1 where coupon_id = '$coupon_id'");
                           }
                        }
                        else {
                             //说明该用户已经有了该优惠券,不需要插入数据
                              $user_coupon_insert[] = array('coupon_id' => $coupon_id,'user_coupon_insert'=>'2');
                        }
                      }
                      else {
                          $user_coupon_insert[] = array('coupon_id' => $coupon_id,'user_coupon_insert'=>'3');
                      }
                  }
               }
           }
       }
    
       echo json_encode(array(
          'login_status' => $login_status,
          'user_coupon_insert' => $user_coupon_insert,
          'coupon_exist' => $coupon_exist,
          'user_telephone' => $user_telephone,
          'coupon_image' => $coupon_image
       ),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
       
   }
}
