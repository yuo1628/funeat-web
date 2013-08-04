/**
 * @author      Miles <jangconan@gmail.com>
 */
Funeat.Fun = Funeat.Fun || new Object();

Funeat.Fun.TARGET = Funeat.Fun.TARGET || '#funBox';
Funeat.Fun.ROOT = Funeat.Fun.ROOT || 'media/fun/';

Funeat.Fun.Roulette = (function()
{
	var _static =
	{
		RADIUS : 300,
		RADIUS_LINE : 2,
		PANEL_HALF : 350,

		ROULETTE : '.funRoulette',

		getInstance : function(data)
		{
			if (instance == null)
			{
				instance = new Singleton(data);
			}
			return instance;
		},

		init : function(data)
		{
			if (instance == null)
			{
				instance = Funeat.Fun.Roulette.getInstance(data);
			}
		},
		onDragStart : function(e)
		{
			drag = true;
			topDelta = e.pageY - top;
			leftDelta = e.pageX - left;
		},
		onDrag : function(e)
		{
			if (drag)
			{
				jQuery(Funeat.Fun.TARGET).css(
				{
					top : e.pageY - topDelta,
					left : e.pageX - leftDelta,
				});
			}
		},
		onDragEnd : function(e)
		{
			drag = false;
			top = parseFloat(jQuery(Funeat.Fun.TARGET).css('top'));
			left = parseFloat(jQuery(Funeat.Fun.TARGET).css('left'));
		},
		onHoverIn : function(e){

		},
		onHoverOut : function(e) {
            drag = false;
            top = parseFloat(jQuery(Funeat.Fun.TARGET).css('top'));
            left = parseFloat(jQuery(Funeat.Fun.TARGET).css('left'));
		},
		onDataUpdataListener : function(data)
		{
			list = data;
		},
		templateDirective :
		{
			'div.funListItem' :
			{
				'i<-list' :
				{
					'div.funListContent' : "i.name"
				}
			}
		}
	};

	var list = new Array();
	var instance = null;
	var top = jQuery(window).height() / 2 - _static.PANEL_HALF;
	var left = jQuery(window).width() / 2 - _static.PANEL_HALF;
	var drag = false;
	var topDelta = 0;
	var leftDelta = 0;

	function Singleton(data)
	{
		var obj = this;

		var _target = Funeat.Fun.TARGET;
		var _roulette = _static.ROULETTE;

        var _cssUrl = 'index.php/css/?root=media/fun/roulette/css/&file=default&radius=' + _static.RADIUS + '&panelHalf=' + _static.PANEL_HALF;
		jQuery('<link>').attr(
		{
			rel : 'stylesheet',
			type : 'text/css',
			href : _cssUrl,
		}).appendTo('head');

		jQuery(_target).html(data);

		jQuery(_target).mousedown(_static.onDragStart);
		jQuery(_target).mousemove(_static.onDrag);
        jQuery(_target).mouseup(_static.onDragEnd);
        jQuery(_target).hover(_static.onHoverIn, _static.onHoverOut);

        jQuery(_target).addClass('funBoxByRoulette');

		jQuery(_target).css(
		{
			'top' : top,
			'left' : left,
		});

		jQuery('.funList').render(
		{
			'list' : list
		}, _static.templateDirective);

		jQuery('div.funListItem').each(function(i)
		{
			var deg = i * (360 / list.length);
			jQuery(this).css(
			{
				'transform' : 'rotate(' + deg + 'deg)'
			});
		});

		jQuery('div.funStartBtn').click(function()
		{
			obj.start();
		});

		this.start = function()
		{
			jQuery(Funeat.Fun.Roulette.ROULETTE).animate(
			{
				'now-rotate' : 720
			},
			{
				step : function(now, fx)
				{
					jQuery(this).css('transform', 'rotate(' + now + 'deg)');
				}
			}, 100000, function()
			{
				jQuery(this).css('transform', 'rotate(' + 0 + 'deg)');
			});
		};
	}

	return _static;
})();

(function()
{
	Funeat.Fun.Roulette.onDataUpdataListener([
	{
		name : 'test1'
	},
	{
		name : 'test2'
	},
	{
		name : 'test3'
	},
	{
		name : 'test4'
	},
	{
		name : 'test5'
	},
	{
		name : 'test6'
	},
	{
		name : 'test7'
	},
	{
		name : 'test8'
	},
	{
		name : 'test9'
	},
	{
		name : 'test10'
	},
	{
		name : 'test11'
	},
	{
		name : 'test12'
	},
	{
		name : 'test13'
	},
	{
		name : 'test14'
	},
	{
		name : 'test15'
	},
	{
		name : 'test16'
	},
	{
		name : 'test17'
	},
	{
		name : 'test18'
	},
	{
		name : 'test19'
	},
	{
		name : 'test20'
	},
	{
		name : 'test21'
	},
	{
		name : 'test22'
	},
	{
		name : 'test23'
	},
	{
		name : 'test24'
	},
	{
		name : 'test25'
	},
	{
		name : 'test26'
	},
	{
		name : 'test27'
	},
	{
		name : 'test28'
	},
	{
		name : 'test29'
	},
	{
		name : 'test30'
	}]);
	jQuery.get('media/fun/roulette/template.html', Funeat.Fun.Roulette.init);
})();
