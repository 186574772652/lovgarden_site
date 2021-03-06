(function($){
  var words = ["嗖!" , "收到!", "谢谢!" , "顺利!", "真棒!" , "没问题!" , "马上!"];
  var feedback = $(".feedback-box");
  
  //Feedback Toggle
	$("#feedback").on("click" , function(){
		feedback.addClass("show");
	});
  
  //Close Trigger
	$(".message_bar_close").on("click" , function(){
    feedback.removeClass("show");
    setTimeout(function(){ 
      feedback.removeClass("show-confirm").find("textarea").val('');
      console.log("reset")
    }, 1000);
	});

//Submit
  $("#submit").on("click" , function(){
    var pattern = /^[1][3,4,5,7,8][0-9]{9}$/;
     if( !$("textarea[name='feedback']").val() || !pattern.test($("input[name='user_tel']").val()) ) {
       $("p.error-message").text('请确保联系方式格式正确，留言内容不能为空')
    }else{
      $('.message-bar #submit').css('background-image',"url(/Public/Home/images/gif-final.gif)").text('').css('height','52px').css('background-color','#ffa5009e').attr("disabled",true);
      var telephone = $("input[name='user_tel']").val(),
          content = $("textarea[name='feedback']").val();
      var msg = {
          telephone: telephone,
          content: content,
          subject: '用户留言',
      };
      
      $.ajax({
        type: 'POST',
        url: '/message/1.json',
        data: msg,
        success: function(data){
           $('.message-bar #submit').css('background-image',"").text('想留言点这里').css('height','52px').css('background-color','orange').attr("disabled",false);
           if(data.code == 200) {
              $("p.error-message").text('');
              feedback.addClass("show-confirm");
              var randomWord = words[Math.floor(Math.random() * words.length)];
              $(".feedback-box h1 strong").text(randomWord);      
              setTimeout(function(){
                 feedback.removeClass("show").find("textarea").val('').delay(1000);
              },1500); 
           }
           else {
              $("p.error-message").text('系统繁忙,请稍后再试');
           }
        }
      });
    }
  })
})(jQuery);