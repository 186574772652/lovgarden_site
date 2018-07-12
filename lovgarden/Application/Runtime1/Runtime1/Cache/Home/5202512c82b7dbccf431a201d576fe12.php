<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
     <title>用户订单详情|花点馨思(丽de花苑)</title>
     <link rel="stylesheet" href="/Public/Home/css/bootstrap.min.css"/>         
     <link rel="stylesheet" href="/Public/Home/css/flow.css"/>
     <link rel="stylesheet" href="/Public/Home/css/style.css"/>
     <script src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
     <script src="/Public/Home/js/bootstrap.min.js"></script>
     <script src="/Public/Home/js/jquery.cookie.js"></script>
     <link rel="stylesheet" href="/Public/Home/css/user_order_detail.css"/>
</head>
<body class="page">
<nav class="fixed-top">
    <div class="navbar-desktop">
        <ul> 
            <li id="shop-market" class="shop"><a href="#home" style="color: orange;">精品店</a>
                
            </li>
            <li id="shop-feature" class="shop"><a href="#bbs">花苑特色</a></li>
            <li id="shop-brief" class="shop"><a href="#html5">花苑介绍</a></li>
            <li id="logo" class="shop"><a href="/"><img src="/Public/Home/images/lovgarden_logo.png"></a></li>
            <li id="help" class="shop"><a href="/article/helpcenter">帮助</a></li>
            <li id="login" class="shop">
                <a href="javascript:void(0);">
                    <span class="glyphicon glyphicon-user"></span>                
                </a>
                <div class="user-options">
                    <span class="arrow-icon"></span>
                    <ul>
                        <li class="option1"><span><a href="/user/login">登录</a></span></li>
                        <li class="option2"><span><a href="/user/register">注册</a></span></li>
                    </ul>
               </div>
            </li>
            <li id="cart" class="shop my-cart"><a title="我的购物车" href="javascript:void(0);"><span class="glyphicon glyphicon-shopping-cart shopping-cart-icon"><span class='add_to_cart_number'>0</span></span></a>
                <div class="checkout__order" style="display: none;">
                    <div class="checkout__order-inner">
                        <table class="checkout__summary">
                            <thead>
                            <tr><th>购物车中商品</th><th>单价</th><th>数量</th><th></th></tr>
                            </thead>
                            <tfoot>
                            <tr><th colspan="4">总价 <span class="checkout__total">0</span></th></tr>
                            </tfoot>
                            <tbody>
                            
                            </tbody>
                        </table><!-- /checkout__summary -->
                        <p style="display: none;" class="link-to-cart-page"><button class="checkout__option checkout__option--loud">结算</button></p>
                   </div>
               </div>
            </li>
        </ul>
   </div>
   
   <div class="navbar-mobile"> 
     <div class="container">
       <div class="col-xs-3 shop-mobile menu-list-mobile">         
           <a><span class="glyphicon glyphicon-menu-hamburger mobile-menu-show"></span></a> 
       </div>
       <div class="col-xs-6 shop-mobile logo-mobile">
           <a href="/" title='花点馨思首页'><img src="/Public/Home/images/lovgarden_logo.png"></a>
       </div>
       <div class="col-xs-3 shop-mobile cart-mobile">
           <a href="#contact" title="我的购物车"><span class="glyphicon glyphicon-shopping-cart shopping-cart-icon"><span class='add_to_cart_number'>0</span></span></a>
           <div class="checkout__order" style="display: none;">
                    <div class="checkout__order-inner">
                        <table class="checkout__summary">
                            <thead>
                                <tr><th>购物车中商品</th><th>单价</th><th>数量</th><th></th></tr>
                            </thead>
                            <tfoot>
                            <tr><th colspan="4">总价 <span class="checkout__total">0</span></th></tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table><!-- /checkout__summary -->
                        <p style="display: none;" class="link-to-cart-page"><button class="checkout__option checkout__option--loud">结算</button></p>
                   </div>
          </div>
       </div> 
     </div>    
   </div>
  </nav>

<div id="my-cart-detail-info">
    
</div>

  <section id="shop-menu-dropdown">
    <div class="container-fluid">
      <div class="col-md-2 col-sm-2">
        <ul class="flower-style">
          <li><a class="bold" href="www.baidu.com">全部</a></li>
          <li><a class="bold">刚采就送</a></li>
          <li><a class="bold">艺术款</a></li>
          <li><a class="bold">流行风</a></li>
          <li><a class="bold">情人节/七夕</a></li>
        </ul>

         <ul class="flower-time">
          <li class="bold">配送时间</li>
          <li><a>当天 +20</a></li>
          <li><a>次日 免费</a></li>
          <li><a>不急 免费</a></li>
        </ul>

        <ul class="flower-origin">
          <li class="bold">花卉原产地</li>
          <li><a>云南昆明</a></li>
          <li><a>日本</a></li>
          <li><a>新西兰</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-sm-2">
        <ul class="flower-category">
          <li class="bold">鲜花品种</li>
          <li><a>康乃馨</a></li>
          <li><a>玫瑰</a></li>
          <li><a>百合花</a></li>
          <li><a>郁金香</a></li>
          <li><a>向日葵</a></li>
          <li><a>牡丹</a></li>
          <li><a>绣球花</a></li>
          <li><a>小苍兰</a></li>
          <li><a>雏菊</a></li>
          <li><a>兰花</a></li>
          <li><a>毛茛</a></li>
          <li><a>微景观</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-sm-2">
        <ul class="flower-occasion">
          <li class="bold">使用场合</li>
          <li><a>周年纪念日</a></li>
          <li><a>生日快乐</a></li>
          <li><a>恭喜祝贺</a></li>
          <li><a>告别</a></li>
          <li><a>我很抱歉</a></li>
          <li><a>喜得贵子</a></li>
          <li><a>传递关心</a></li>
          <li><a>感谢</a></li>
        </ul>

        <ul class="flower-service">
          <li class="bold">鲜花服务</li>
          <li><a>婚礼</a></li>
          <li><a>大事</a></li>
          <li><a>活动</a></li>
          <li><a>装饰</a></li>
        </ul>
      </div>
      
        <div class="col-md-3 col-sm-6">
          <div class="menu-block1 menu-block">
              <a class="menu-block-img" href="/flowers/all">
                  <img src="/Public/Home/images/home/home_menu_block1.png">
              </a>
              <div class="menu-block-des">
                <h3 class="menu-block-des-title"><a href="/flowers/all" target="">SHOP ALL</a></h3> 
                <p class="menu-block-des-content">Shop a wide array of sustainably grown farm direct bouquets and hand-crafted, custom designs by local Artisan Florists.<br></p>
              </div>
           </div>
        </div>
        <div class="col-md-3 mobile-gone">
          <div class="menu-block2 menu-block">
              <a class="menu-block-img" href="/flowers/all">
                  <img src="/Public/Home/images/home/home_menu_block1.png">
              </a>
              <div class="menu-block-des">
                <h3 class="menu-block-des-title"><a href="/flowers/all" target="">SHOP ALL2</a></h3> 
                <p class="menu-block-des-content">Shop a wide array of sustainably grown farm direct bouquets and hand-crafted, custom designs by local Artisan Florists.<br></p>
              </div>
           </div>
        </div>
      
    </div>
  </section>
  <div id="mobile-menu-section">
	  <section id="shop-menu-popup">
	    <ul>
	      <li class="account top"><a>账号</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="account foder"><a href="/user/login" class="account-option1">登录</a></li>
	      <li class="account bottom foder"><a href="/user/register" class="account-option2">注册</a></li>
	      <li class="mobile-shop top"><a style="color: orange;">精品店</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="mobile-shop foder"><a>全部</a></li>
	      <li class="mobile-shop foder"><a>刚采就送</a></li>
	      <li class="mobile-shop foder"><a>鲜花流行风</a></li> 
	      <li class="mobile-shop foder"><a>情人节/七夕</a></li>
	      <li class="mobile-shop bottom foder"><a>重要节日</a></li>
	      <li class="deliver-time top"><a>配送时间</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="deliver-time foder"><a>当天</a></li>
	      <li class="deliver-time foder"><a>次日</a></li>
	      <li class="deliver-time bottom foder"><a>不急</a></li>
	      <li class="other-service top"><a>其他服务</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="other-service foder"><a>活动</a></li>
	      <li class="other-service foder"><a>婚礼</a></li>
	      <li class="other-service foder"><a>重要的事</a></li>
	      <li class="other-service bottom foder"><a>装饰</a></li>
	      <li class="about-us top"><a>花苑特色</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="about-us foder"><a>花苑介绍</a></li>
	      <li class="about-us foder"><a>关于我们</a></li>
	      <li class="about-us bottom foder"><a>微信公众号</a></li>
	      <li class="about-help top"><a>帮助</a><span class="glyphicon glyphicon-plus"></span></li>
	      <li class="about-help foder"><a>帮助中心</a></li>
	      <li class="about-help foder"><a>关于配送</a></li>
	      <li class="about-help foder"><a>用户须知</a></li>
	      <li class="about-help foder"><a>网站地图</a></li>
	    </ul>
	  </section>
	  <span class="mobile-menu-close glyphicon glyphicon-remove"></span>
   </div>
  <div class="header-gap"></div>
  

  <div class="container checkout-order-content">
    <h3 class="check-before-next-title">订单详情</h3>
    <p class="check-before-next-brief">订单只在提交后的一天内有效哦，请尽快完成支付(已支付的请忽略此信息)</p>
    <!--订单详情-->
    <div class="row-order-info">
        <div class="col-md-4 col-sm-4">
            <span>订单编号:<?php print $order_info['order_id']; ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <span>收货人姓名:<?php print $order_info['first_name'].$order_info['last_name']; ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <span>收货人电话:<?php print $order_info['telephone']; ?></span>
        </div>
    </div>
    <div class="row-order-info">
        <div class="col-md-4 col-sm-4">
            <span>创建时间:<?php print $order_info['order_create_time']; ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <span>订单状态:<?php print get_order_status_label($order_info['order_status']); ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <span>邮编:<?php print $order_info['post_code']; ?></span>
        </div>
    </div>
    <div class="row-order-info">
        <div class="col-md-12">
            <span>收获地址:<?php print $order_info['area'].$order_info['address']; ?></span>
        </div>
    </div>
    <div class="row-order-info">
        <div class="col-md-12">
            <span>备注(贺卡):<?php print $order_info['content_body']; ?></span>
        </div>
    </div>
    
    <h3 class="products-list-flow2">商品列表</h3>
    <?php foreach($order_products_fix as $k => $v): ?>
    <div class="row each-product">
      <div class="product-small-img col-md-3 col-sm-3 col-xs-4">
          <img style="width: 110px;height: 110px;" src="<?php print C('IMAGE_CONFIG')['viewPath'].$v['image_url'][0]; ?>">
      </div>
      <div class="product-title-info product-title-info-title col-md-2 col-sm-2 col-xs-4">
        <p><span class="ceil"><?php print $v['varient_name']; ?></span></p>
      </div>
      <div class="product-title-info decoration-level-status col-md-1 col-sm-1 col-xs-4">
        <p><span class="ceil checkout-decoration-value"><?php print product_varient_decoration_level($v['decoration_level']); ?></span></p>
      </div>
      <div class="product-title-info input-select-vase-status col-md-2 col-sm-2 col-xs-4">        
         <p><span class="ceil checkout-vase-status"><?php print get_vase_label($v['vase_option']); ?></span></p>
      </div>
      <div class="flow-check-date-value col-md-2 col-sm-2 col-xs-4">
          <p><span class="ceil checkout-date-value"><?php print date("Y-m-d",strtotime($v['deliver_time'])); ?></span></p>
      </div>
      <div class="flow-check-each-price col-md-1 col-sm-1 col-xs-4">
          <p><span class="ceil">价格<br/><?php print number_format($v['varient_price']); ?>元</span></p>
      </div>
    </div>
    <?php endforeach; ?>
    <div class="row total-price-list">
      <div class="col-md-8 col-sm-8 col-xs-12">
        <p class="coupin-code-info">优惠码号：<?php if(!empty($order_info['order_coupon_code'])){ print $order_info['order_coupon_code'];}else{print '无';} ?></p>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12 price-list-mobile">
        <table class="total-price table table--totals">
          <tbody>
          <tr>
            <th>
              <span>花瓶价格总和:</span>
            </th>
            <td>
              <span class="vase_total_cost"><?php print $order_info['order_vases_price']; ?></span><span>元</span>
            </td>
          </tr>
          <tr>
            <th>
              <span>商品价格总和:</span>
            </th>
            <td>
                <span class="products_total_cost"><?php print $order_info['order_products_total_price']; ?></span><span>元</span>
            </td>
          </tr>
          <tr>
            <th>
              <span>优惠券</span>
            </th>
            <td>
                <span class="cut_total_cost">-<?php print $order_info['order_coupon_cut']; ?></span><span>元</span>
            </td>
          </tr>
          <tr>
            <th class="checkout-step-summary__login-free-delivery-cell">
              <span>运费:</span>
            </th>
            <td>
                <span class="deliver_cost"><?php print $order_info['order_deliver_price']; ?></span><span>元</span>
            </td>
          </tr>
          <tr class="table__total">
            <th>
              <span>最终价格:</span>
            </th>
            <td><span class="total-price-value"><?php print $order_info['order_final_price']; ?></span><span>元</span></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div> 
    
    <div class="row checkout-button">
      <?php if($order_info['order_status'] == '1'): ?>
      <a href="/user/user_order_pay/order_id/<?php print $order_info['order_id']; ?>" class="checkout-to-flow3">去支付</a>
      <?php elseif($order_info['order_status'] == '2'): ?>
      <a href="javascript:void(0);" class="checkout-to-flow3" style="cursor:default;text-decoration: none;background-color: #5ac689;color: #fff;">已支付</a>
      <?php endif ?>
    </div>
  </div>
     <div class="container footer wow slideInUp" data-wow-offset="30">
   		<div class="col-md-3 col-sm-3">
   			<div><h3>The Bouqs Co.</h3>
   				<ul>
   					<li><a>About</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Our Difference</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Press</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Bouqs Video</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Blog</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
          </ul>
        </div>
   		</div>
   		<div class="col-md-3 col-sm-3">
   			<div><h3>ADDITIONAL SERVICES</h3>
   				<ul>
   					<li><a>Events</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Weddings</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Corporate Gifts</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Gift Cards</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
          </ul>
        </div>
   		</div>
   		<div class="col-md-3 col-sm-3">
   			<div><h3>WORK WITH US</h3>
   				<ul>
   					<li><a>Jobs</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Florists</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>Affiliates</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
          </ul>
        </div>
   		</div>
   		<div class="col-md-3 col-sm-3">
   			<div><h3>帮助</h3>
   				<ul>
   					<li><a href="/article/faq/id/32">花卉护理</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a href="/article/helpcenter">帮助中心</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a href="/article/faq/id/28">关于配送</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>法律条款</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
            <li><a>站点地图</a><span class="show-mobile glyphicon glyphicon-menu-right"></span></li>
          </ul>
        </div>
   		</div>
   </div>
   <!--社交媒体-->
   
   <div class="page-footer__social wow slideInUp" data-wow-offset="30">
        <ul class="share-buttons">
          <li class="share-buttons__item"><a class="share-buttons__button icon icon--wechat" title="微信公众号" target="_blank" href=javascript:void(0);>Follow The Bouqs on Twitter</a></li>
          <li class="share-buttons__item show-pc"><a class="share-buttons__button icon icon--qq" title="QQ客服" target="_blank" href="//wpa.qq.com/msgrd?v=3&uin=1048290286&site=qq&menu=yes">Follow The Bouqs on Facebook</a></li>
          <li class="share-buttons__item show-tablet-mobile"><a class="share-buttons__button icon icon--qq" title="QQ客服" target="_blank" href="mqqwpa://im/chat?chat_type=wpa&uin=1048290286&version=1&src_type=web&web_src=oicqzone.com">Follow The Bouqs on Facebook</a></li>
          <li class="share-buttons__item"><a class="share-buttons__button icon icon--tuangou" title="新浪微博" target="_blank" href="https://www.pinterest.com/thebouqsco/">Follow The Bouqs on Pinterest</a></li>        
        </ul>
       <div class="wechat-popup" style="display: none;"><img src="/Public/Home/images/wechat.png" style="width: 200px;" /></div>
   </div>
   <div class="foot-copyright wow slideInUp" data-wow-offset="10">
     <p>本站点版权归丽de花苑所有 -2018年3月</p>
   </div>  
    <script src="/Public/Home/js/custom.js"></script>   
</body>
</html>