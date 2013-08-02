/**
 * @author FunEat
 */

$(function() {
	
	/*
	$(".postBtn").click(function() {
		post();
	})
	*/
	
})

function post() {
	$.post(
		"index.php/restaurant/feature/add",
		{
			
		},
		function(data) {
			//alert(data);
			/*
			if(data == true)
			{
				window.location.href = window.location;
			}*/
			if($(obj).hasClass("postHasLike"))
			{
				$(obj).removeClass("postHasLike");
				$(obj).text("讚");
				$(obj).next(".postLikeCount").text(
					parseInt($(obj).next(".postLikeCount").text()) - 1
				);
			}
			else
			{
				$(obj).addClass("postHasLike");
				$(obj).text("取消讚");
				$(obj).next(".postLikeCount").text(
					parseInt($(obj).next(".postLikeCount").text()) + 1
				);
			}
			
		}
	)
	
}
