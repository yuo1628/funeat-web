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
		
		/*
		$(".randomCheckBtn").click(function() {
			r.timeStop($(this).attr("index"));
			$(this).unbind("click");
		})
		*/
	};
	
	
	
	$(".randomStartBtn").click(function() {
		
		$(this).unbind("click");
		
		$(".randomMenuBox").find(".randomMenu").each(function() {
			
			//if($(this).index()==0)
			//{
				var r = new randRun(2,10000,4,".randomItemScrollBox[index=" + $(this).index() + "]");
				r.start();
				
				$(".randomCheckBtn[index=" + $(this).index() + "]").click(function() {
					r.stop();
					//$(this).unbind("click");
				})
			//}
			
		})
	})
	
		
}



function randRun(delay, count, topMove, target ) {
	var obj = this;
	obj.target = target;
	obj.currentTarget;
	obj.delay = delay;
	obj.count = count;
	obj.topMove = topMove;
	
	obj.i = 0;
	obj.index = 2;//第一個是假的 從1開始
	
	obj.start = function() {
		
		startTime();
		
		function startTime() {
			var t1 = setTimeout(startRun,obj.delay);
		}
		
		function startRun() {
			obj.i++;
			
			var top = parseInt($(obj.target).css("top"));
			
			$(obj.target).css({
				'top' : top - obj.topMove
			})
			
			if(top - 140 <= -(parseInt($(obj.target).height())))
			{
				$(obj.target).css({
					'top' : -20
				});
			}
			
			if(obj.i < obj.count) {
				startTime();
				
			}
			else
			{
				//alert(obj.i);
				obj.i = 0;
			}
		}
	}
	
	obj.stop = function() {
		//alert(obj.i);
		obj.i = obj.count;
		//alert(obj.i);
		
		stopTime();
		
		function stopTime() {
			var t = setTimeout(stopRun, obj.delay * 10);
		}
		
		function stopRun() {
			var top = parseInt($(obj.target).css("top"));
		
			if(top - 160 >= -(parseInt($(obj.target).height())) )
			{
				$(obj.target).css({
					'top' : top - obj.topMove
				})
				
				stopTime();
			}
			else
			{
				$(obj.target).css({
					'top' : -obj.topMove
				})
				
				stopTimeHit();
			}
			
			
		}
		
		function stopTimeHit() {
			var h = setTimeout(stopHit, obj.delay * 20);
		}
		
		function stopHit() {
			var top = parseInt($(obj.target).css("top"));
			if(top >= (-(obj.index * 80)) + 30)
			{
				$(obj.target).css({
					'top' : top - obj.topMove
				})
				
				stopTimeHit();
			}
		}
	}
	
	
	/*
	obj.timeRun = function() {
		var time = window.setTimeout(run, obj.delay);
	}
	
	
	function run() {
		
		obj.i++;
		
		//----
		
		var top = parseInt($(obj.target).css("top"));
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
			obj.i = 0;
			//index = 0;
		}
		
	};
	
	//obj.ai = 0;
	obj.timeStop = function () {
		alert(obj.i);
		
		obj.i = obj.count;
		
		var t = setTimeout(stop, obj.delay * 10);
	}
	
	function stop() {
		var top = parseInt($(obj.target).css("top"));
		
		//alert(top);
		
		if(top - 160 >= -(parseInt($(obj.target).height())) )
		{
			$(obj.target).css({
				'top' : top - obj.topMove
			})
			
			obj.timeStop();
		}
		else
		{
			$(obj.target).css({
				'top' : -obj.topMove
			})
			
			obj.timeHit();
		}
	}
	
	obj.timeHit = function () {
		var h = setTimeout(hit, obj.delay * 20);
		
	}
	
	function hit() {
		var top = parseInt($(obj.target).css("top"));
		if(top >= (-(obj.index * 80)) + 30)
		{
			$(obj.target).css({
				'top' : top - obj.topMove
			})
			
			obj.timeHit();
		}
	}
	*/
}


