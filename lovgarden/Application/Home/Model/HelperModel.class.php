<?php
namespace Home\Model;
use Think\Model;
use Think\Cache\Driver\Memcache;
use Org\Util\PHPMailer;
use Org\Util\SMTP;
class HelperModel
{
    function get_category_related_products($where){
        $product_varients = D('Admin/ProductVarient');
        $products = $product_varients->alias('product')
                                ->join('LEFT JOIN lovgarden_product_varient_images AS images ON product.id = images.product_varient_id')
                                ->join('LEFT JOIN lovgarden_product_varient_hurry_level AS hurrylevelid ON product.id = hurrylevelid.product_varient_id')
                                ->join('LEFT JOIN lovgarden_hurry_level AS hurrylevel ON hurrylevelid.hurry_level_id = hurrylevel.id')
                                ->join('LEFT JOIN lovgarden_product_varient_flower_home AS flowerhomeid ON product.id = flowerhomeid.product_varient_id')
                                ->join('LEFT JOIN lovgarden_flower_home AS flowerhome ON flowerhomeid.flower_home_id = flowerhome.id')
                                ->join('LEFT JOIN lovgarden_product_varient_flower_type AS flowertypeid ON product.id = flowertypeid.product_varient_id')
                                ->join('LEFT JOIN lovgarden_flower_type AS flowertype ON flowertypeid.flower_type_id = flowertype.id')
                                ->join('LEFT JOIN lovgarden_product_varient_flower_occasion AS floweroccasionid ON product.id = floweroccasionid.product_varient_id')
                                ->join('LEFT JOIN lovgarden_flower_occasion AS floweroccasion ON floweroccasionid.flower_occasion_id = floweroccasion.id')
                                ->join('LEFT JOIN lovgarden_product_varient_flower_color AS flowercolorid ON product.id = flowercolorid.product_varient_id')
                                ->join('LEFT JOIN lovgarden_flower_color AS flowercolor ON flowercolorid.flower_color_id = flowercolor.id')
                                ->field('product.id , product.sku_id , product.varient_name , product.varient_summary , product.varient_price , images.`image_url` , hurrylevelid.hurry_level_id , hurrylevel.hurry_level,flowerhomeid.flower_home_id,flowerhome.flower_home,flowertypeid.flower_type_id,flowertype.flower_name,floweroccasionid.flower_occasion_id,floweroccasion.flower_occasion,flowercolorid.flower_color_id,flowercolor.flower_color')
                                ->where($where)                         
                                ->order('product.id asc')
                                ->select();
        $multiple_fields = array('image_url','hurry_level_id','hurry_level','flower_type_id','flower_name','flower_occasion_id','flower_occasion','flower_color_id','flower_color','flower_home','flower_home_id');
        $products = translate_database_result_to_logic_array($products, $multiple_fields, 'sku_id');
//        echo "<pre>";
//        header("Content-type:text/html;charset=utf-8");
//        print_r($products);
//        echo "</pre>";
//        exit();
        return $products;
    }
    
    function leave_message($type = 'mail',$telephone,$content,$subject) {
        if($type == 'mail') {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // 启用SMTP
            $mail->SMTPDebug = C('MAIL_CONFIG')['smtpdebug'];
            $mail->Host = C('MAIL_CONFIG')['host']; //smtp服务器的名称（这里以QQ邮箱为例）
            $mail->SMTPSecure = C('MAIL_CONFIG')['smtpsecure'];
            $mail->Port = C('MAIL_CONFIG')['port'];
            $mail->SMTPAuth = C('MAIL_CONFIG')['smtpauth']; //启用smtp认证
            $mail->Username = C('MAIL_CONFIG')['username']; //你的邮箱名
            $mail->Password = C('MAIL_CONFIG')['password']; //邮箱密码
            $mail->From = C('MAIL_CONFIG')['from']; //发件人地址（也就是你的邮箱地址）
            $mail->FromName = $telephone; //发件人姓名
            $mail->AddAddress(C('MAIL_CONFIG')['address'],"New Client");
            $mail->WordWrap = C('MAIL_CONFIG')['wordwrap']; //设置每行字符长度
            $mail->IsHTML(C('MAIL_CONFIG')['ishtml']); // 是否HTML格式邮件
            $mail->CharSet = C('MAIL_CONFIG')['charset']; //设置邮件编码
            $mail->Subject = $subject; //邮件主题
            $mail->Body = $content; //邮件内容
            $mail->AltBody = $content; //邮件正文不支持HTML的备用显示
            if($mail->Send()){
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
    }
}












