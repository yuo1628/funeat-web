/**
 * @author FunEat
 */

$(function() {
	
	var uuid = $("#restaurant_uuid").val();
	
	//alert(uuid);
	
	$(".resLikeBtn").click(function() {
		$.post(
			"./index.php/restaurant/like/" + uuid
			,
			function(data) {
				if(data == true)
				{
					$(".resLikeCount").text(parseInt($(".resLikeCount").text()) + 1);
					$(".resLikeBtn").addClass("hasLike");
					$(".hasLike").removeClass("resLikeBtn");
					$(".hasLike").find("img").attr("src", "img/icon/has_like.png");
				}
			}
		)
	})
	
	
	
})

