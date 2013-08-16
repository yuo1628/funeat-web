
$(function() {
	
	$("input.regText").each(function(){
		if ($(this).val() != "") {
			$(this).prev("div").hide();
		}
	});
	
	$("input.regText").focus(function() {			
		$(this).prev("div").hide();
	});
	
	$("input.regText").blur(function() {
		if ($(this).val() == "") {
			$(this).prev("div").show();
		}
	});
	
	$("#registerForm").validate({
		rules : {
			email : {
				required : true,
				email : true
			},
			name : {
				required : true
			},
			password : {
				required : true,
				rangelength : [4, 12]
			},
			confirmPassword : {
				required : true,
				equalTo : "#password"
			},
			privacy : {
				required : true				
			}
		},
		messages : {
			email : {
				required : '請輸入電子信箱',
				email : '請輸入正確格式的電子信箱'
			},
			name : {
				required : '請輸入使用者暱稱'
			},
			password : {
				required : '請輸入密碼',
				rangelength : "請輸入4~12字元的英文或數字"
			},
			confirmPassword : {
				required : '請再一次輸入密碼',
				equalTo : "兩次輸入的密碼不同"
			},
			privacy : {
				required : '給我勾就對了'			
			}
		}
	});
	
});

