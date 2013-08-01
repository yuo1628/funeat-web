/**
 * @author Owner
 */
var pos_boo = true;
var adv_boo = true;

$(function() {
	
	/*
	//position
	$(".positionBtn").click(function() {
		
		if(pos_boo)
		{
			$(this).addClass("positionHasClick");
			$(".localInfoBox").show();
		}
		else {
			$(this).removeClass("positionHasClick");
			$(".localInfoBox").hide();
		}
		
		pos_boo = !pos_boo;
	});
	
	//advance
	$(".slideBtn").click(function() {
		
		if(adv_boo)
		{
			$(this).addClass("positionHasClick");
			$(".localInfoBox").show();
		}
		else {
			$(this).removeClass("positionHasClick");
			$(".localInfoBox").hide();
		}
		
		adv_boo = !adv_boo;
	});*/
	
	var posToggle = new toggleEvent(".positionBtn", ".localInfoBox", "hasClick posHasClick");
	posToggle.run();
	var advToggle = new toggleEvent(".slideBtn", ".searchAdvBox", "hasClick advHasClick");
	advToggle.run();
	
	var leftClose = new leftToggle(".leftCLose", ".leftBox", 0, -320, "leftBoxHasClose");
	leftClose.run();
	
})

/**
 * 開關事件，target為隱藏的對象，button為事件觸發者
 * 
 * button => jquery $()
 * target => jqeury $()
 * style => class string
 * 
 * @param {Object} button => jquery $()
 * @param {Object} target => jqeury $()
 * @param {String} style => class string
 */
function toggleEvent(button, target, style) {
	var boo = true;
	this.style = style;
	this.button = button;
	this.target = target;
	this.run = function() {
		
		$(this.button).click(function() {
			//alert("123");
			$(target).show();
			if(boo)
			{
				$(this).addClass(style);
				$(target).show();
			}
			else {
				$(this).removeClass(style);
				$(target).hide();
			}
			
			boo = !boo;
		});
		
	}
	
}

/**
 * 左右SLIDE
 * 
 * @param {Object} button
 * @param {Object} target
 * @param {String} start_left
 * @param {String} end_left
 * @param {String} style
 */
function leftToggle(button, target, start_left, end_left, style) {
	var boo = true;
	this.start_left = start_left;
	this.end_left = end_left;
	this.button = button;
	this.target = target;
	this.style = style;
	this.run = function() {
		
		$(this.button).click(function() {
			if(boo)
			{
				
				$(target).animate({
					'left' : start_left
				},function() {
					$(button).addClass(style);
				})
				
				//$(target).show();
			}
			else {
				$(button).removeClass(style);
				$(target).animate({
					'left' : end_left
				})
			}
			
			boo = !boo;
		});
		
	}
}

