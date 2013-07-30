/**
 * @author FunEat
 */

$(function() {
	
	
	//alert(uuid);
	
	$(".replyBtn").click(function() {
		
		var uuid = $(this).parents(".resDiscussItem").find(".user_uuid").val();
		var name = $(this).parents(".resDiscussItem").find(".user_name").val();
		
		
		//alert(uuid);
		//alert(name);
		//$(".replyTagItem").remove();
		
		//$(".replyTagMenu").append("<div class='replyTagItem'>" + name + "</div>");
		//$(".reply_to_uuid").val(uuid);
		
		$(this).parents(".resDiscussItem").next(".replyBox").append(
			'<div class="resDiscussItem replyDiscussItem">' +
				'<input class="reply_to_uuid" type="hidden" value="' + uuid +'" />' +
				'<div class="resDiscussImg replyDiscussImg">' +
					'<img src="' + '' + '" />' +
				'</div>' +
				'<div class="msgArrow replyArrow"></div>' +
				'<div class="discussPostBox">' +
					
					'<div class="discussReply">' +
						'<div class="replyTagToLabel">' +
							'留給：' +
						'</div>' +
						'<div class="replyTagMenu">' +
							'<div class="replyTagItem">' +
								name +
							'</div>' +
						'</div>' +
						
						'<div class="clearReplyTag" onclick="clearReplyTag(this)">' +
							'x' +
						'</div>' +
						'<div class="clearfix"></div>' +
					'</div>' +
					'<div class="discussContent">' +
						'<div class="contentLabel">' +
							'留言' +
						'</div>' +
						'<div class="contentText">' +
							'<textarea></textarea>' +
						'</div>' +
						
						'<div class="clearfix"></div>' +
						'<input class="mainReplyBtn" onclick="replyPost(this);false" type="submit" value="回覆">' +
					'</div>' +
					
					'<div class="clearfix"></div>' +
				'</div>' +
				'<div class="clearfix"></div>' +
			'</div>' +
		'</div>'
			
		)
	})
	
	$(".clearReplyTag").click(function() {
		$(this).parents(".resDiscussItem").remove();
	})
	
})

function clearReplyTag(obj) {
	$(obj).parents(".resDiscussItem").remove();
}

function replyPost(obj) {
	var uuid = $(obj).parents(".resDiscussItem").find(".reply_to_uuid").val();
	var comment = $(obj).parents(".resDiscussItem").find("textarea").val();
	//alert(comment);
	$.post(
		"index.php/restaurant/reply/" + uuid,
		{
			identity : uuid,
			comment : comment
		},
		function(data) {
			//alert(data);
			
			if(data == true)
			{
				window.location.href = window.location;
			}
		}
	)
}

function mainPostLike(obj) {
	
	var uuid = $(obj).parents(".resDiscussItem").find(".user_uuid").val();
	
	$.post(
		"index.php/restaurant/comment/" + uuid + "/like",
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

function mainReplyLike(obj) {
	
	var uuid = $(obj).parents(".resDiscussItem").find(".user_uuid").val();
	
	$.post(
		"index.php/restaurant/reply/" + uuid + "/like",
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
