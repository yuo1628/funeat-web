$(document).ready(function() {

	$("input.loginText").each(function() {
		if ($(this).val() != "") {
			$(this).prev("div").hide();
		}
	});
	
	$("input.loginText").focus(function() {
		$(this).prev("div").hide();
	});
	
	$("input.loginText").blur(function() {
		if ($(this).val() == "") {
			$(this).prev("div").show();
		}
	});
	$("#loginForm").validate({
		rules : {
			identity : {
				required : true,
				email : true
			},
			password : {
				required : true,
				rangelength : [4, 12]
			}
		},
		messages : {
			identity : {
				required : '請輸入電子信箱',
				email : '請輸入正確格式的電子信箱'
			},
			password : {
				required : '請輸入密碼',
				rangelength : "請輸入4~12字元的英文或數字"
			}
		}
	});
}); 