<?php
namespace Home\Model;
use Think\Model;
use Think\Cache\Driver\Memcache;
class OrderModel extends Model 
{
    //调用时候create方法允许接受的字段
    protected $insertFields = 'order_id,order_owner,last_name,first_name,telephone,area,address,post_code,content_body,order_create_time,order_products_total_price,order_deliver_price,order_vases_price,order_coupon_code,order_coupon_cut,order_vip_level_cut,order_final_price,order_status';
    protected $updateFields = '';
    protected $_validate = array(
        array('order_id','require','订单编号不能为空',1),
        array('order_id','checkUserOrdersUnpaid','未支付订单超过最大限制',1,'callback',3),
        array('order_owner','require','下单人账号不能为空',1),
        array('last_name','1,30','名字格式错误',1,'length'),
        array('first_name','1,30','姓格式错误',1,'length'),
        array('telephone','/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\\d{8}$/','手机号码格式不正确',1),
        array('area','1,200','省市不能为空',1,'length'),
        array('address','1,255','街道门牌等详细地址不能为空',1,'length'),
        array('post_code','/^[0-9]\\d{5,8}$/','邮编格式不对',1),
        array('content_body','0,500','贺卡字数限制在500个字符内',1,'length'),
    );
    //验证未支付订单不能超过20
    function checkUserOrdersUnpaid($order_id,$max_items = 20){
        //同样为了避免多次查询数据库，将用户的购物车内数量存入memcache
        $user_telephone = session('user_telephone');        
        $sql = "SELECT id FROM lovgarden_order WHERE order_owner = '$user_telephone' and order_status='1'";        
        $model_for_user = new Model();
        $results = $model_for_user->query($sql);
        $count = count($results);
        if($count<$max_items){
           return TRUE;
        }
        return FALSE;
    }
    //接收来自码支付的通知（临时用，未来会改为正式支付宝和微信)
    function order_handle_notify($post_array = array()) {
        if(empty($post_array)){
            echo "error";
            exit();
        }
        ksort($post_array); //排序post参数
        reset($post_array); //内部指针指向数组中的第一个元素
        $codepay_key= C('PAY_SECRET'); //这是您的密钥
        $sign = '';//初始化
        foreach ($post_array AS $key => $val) { //遍历POST参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        if (!$post_array['pay_no'] || md5($sign . $codepay_key) != $post_array['sign']) { //不合法的数据
             exit('fail');  //返回失败 继续补单
        }
        else { //合法的数据
            //业务处理           
            $pay_id = $post_array['pay_id']; //需要充值的ID 或订单号 或用户名
            $money = (float)$post_array['money']; //实际付款金额
            $price = (float)$post_array['price']; //订单的原价
            $param = $post_array['param']; //自定义参数
            $pay_no = $post_array['pay_no']; //流水号
            
            //站点业务逻辑:需要更新订单状态到已支付
            //$pay_id = '18040314555687237';
            $sql_pay = "UPDATE lovgarden_order SET pay_time = NOW(), order_status = '2' WHERE order_id = '$pay_id'";
            $result = $this->execute($sql_pay);
            if($result) {
              exit('success');
            }//返回成功 不要删除哦
            else {
              //数据库更新失败，记录log，订单id,价格，云端流水号
                
              
            }
        }
    }
}












