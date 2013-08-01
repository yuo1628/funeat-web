/**
 * @author Owner
 */

$(function() {
	
	var t_list = [
		{
			tag : '早',
			name : [{
				
					name : 'name1'
				},
				{
					name : 'name2'
				},
				{
					name : 'name3'
				},
				{
					name : 'name4'
				
				}]
				
			
		},
		{
			tag : '中',
			name : [{
				
					name : 'name1'
				},
				{
					name : 'name2'
				},
				{
					name : 'name3'
				},
				{
					name : 'name4'
				
				}]
		}/*,
		{
			tag : '晚',
			name : [{
				
					name : 'name1'
				},
				{
					name : 'name2'
				},
				{
					name : 'name3'
				},
				{
					name : 'name4'
				
				}]
		}*/
	];
	
	
	
	var ran = new random();
	ran.list = t_list;
	$(".randomBtn").click(function(){
		ran.run();
	})
	
	
})


var randRun = function (delay, count, topMove, target ) {
	var obj = this;
	obj.target = target;
	obj.currentTarget;
	obj.delay = delay;
	obj.count = count;
	obj.topMove = topMove;
	//obj.test =test;
	
	obj.timeRun = function() {
		var time = window.setTimeout('new run()', obj.delay);
	}
	
	
	var i = 0;
	var top = 0;
	var index = 2; //第一個是假的 從1開始
	run = function () {
		
		//alert(obj.test);
		
		i++;
		
		//----
		
		top = parseInt($(obj.target).css("top"));
		$(obj.target).css({
			'top' : top - obj.topMove
		})
		
		if(top - 140 <= -(parseInt($(obj.target).height())))
		{
			$(obj.target).css({
				'top' : -20
			});
		}
		
		//----
		
		if(i < obj.count) {
			obj.timeRun();
			
			//index = Math.floor(top / parseInt($(".randomItem").height()));
		}
		else
		{
			i = 0;
			//index = 0;
		}
		
	};
	
	obj.ai = 0;
	obj.timeStop = function (ai) {
		obj.ai = ai;
		
		//alert(obj.ai);
		
		obj.currentTarget = $(".randomItemScrollBox[index=" + ai + "]");
				
		//i = obj.count;
		
		var t = setTimeout('stop()', obj.delay * 10);
	}
	
	stop = function () {
		
		
		top = parseInt($(obj.currentTarget).css("top"));
		
		//alert(parseInt($(obj.currentTarget).height()));
		
		if(top - 160 >= -(parseInt($(obj.currentTarget).height())) )
		{
			$(obj.currentTarget).css({
				'top' : top - obj.topMove
			})
			
			obj.timeStop(obj.ai);
		}
		else
		{
			$(obj.currentTarget).css({
				'top' : -obj.topMove
			})
			
			obj.timeHit();
			
			//alert("123");
		}
		
		
	}
	
	obj.timeHit = function () {
		var h = setTimeout('hit()', obj.delay * 20);
		
		//alert("123");
	}
	
	hit = function () {
		//alert("123");
		top = parseInt($(obj.currentTarget).css("top"));
		if(top >= (-(index * 80)) + 30)
		{
			$(obj.currentTarget).css({
				'top' : top - obj.topMove
			})
			
			obj.timeHit();
		}
		/*
		else
		{
			
		}*/
	}
}

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
function random() {
	var boo = true;
	this.container = '';
	
	/**
	 * list.title
	 */
	this.list = null;
	
	var html = '';
	
	this.run = function() 
	{
		var title = '';
		
		for(i in this.list) {
			var title = '';
			var len = this.list[i].name.length;
			title += '<div class="randomItem">' +
				this.list[i].name[len - 1].name
			+ '</div>';
			for(j in this.list[i].name)
			{
				
				title += '<div class="randomItem">' +
							this.list[i].name[j].name
						+ '</div>';
				
			}
			title += '<div class="randomItem">' +
				this.list[i].name[0].name
			+ '</div>';
			
			
			html += '<div class="randomMenu">' +
				'<div class="randomTitle">' +
					this.list[i].tag +
				'</div>' +
				'<div class="randomItemList">' +
					'<div class="randTopShadow"></div>' +
					
					'<div class="randomItemScrollBox" index="' + i + '">' +
						title +
					'</div>' +
					
					'<div class="randBottomShadow"></div>' +
				'</div>' +
				
				'<div class="randomResult">' +
					'結果' +
				'</div>' +
				
				'<div class="randomCheckBox">' +
					'<div class="randomCheckBtn" index="' + i + '">' +
						'確定' +
					'</div>' +
				'</div>' +
			'</div>';
			
			//alert(title);
			
			
			
			/*
			$(".randomCheckBtn").click(function() {
				t_run.target = ".randomItemScrollBox[id=" + i + "]";
				t_run.timeStop(t_run.target);
				$(this).unbind("click");
			})*/
			
			
		}
		
		$(".randomMenuBox").append(html);
		
		
		$(".randomCheckBtn").click(function() {
			r.timeStop($(this).attr("index"));
			$(this).unbind("click");
		})
		
	};
	
	
	var r = new randRun(2,10000,4,".randomItemScrollBox");
	$(".randomStartBtn").click(function() {
		r.timeRun();
			
		$(this).unbind("click");
	})
	
	
		
}



