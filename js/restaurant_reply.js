/**
 * @author FunEat
 */

$(function() {
	
	
	//alert(uuid);
	
	$(".replyBtn").click(function() {
		
		var uuid = $(this).parents(".resDiscussItem").find(".user_uuid").val();
		var name = $(this).parents(".resDiscussItem").find(".user_name").val();
		
		//alert(name);
		//$(".replyTagItem").remove();
		
		//$(".replyTagMenu").append("<div class='replyTagItem'>" + name + "</div>");
		//$(".reply_to_uuid").val(uuid);
		
		$(this).parents(".resDiscussItem").next(".replyBox").append(
			'<div class="resDiscussItem replyDiscussItem">' +
				'<div class="resDiscussImg replyDiscussImg">' +
					'<img src="' + '' + '" />' +
				'</div>' +
				'<div class="msgArrow replyArrow"></div>' +
				'<div class="discussPostBox">' +
					'<input class="reply_to_uuid" type="hidden" value="' + uuid +'" />' +
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

