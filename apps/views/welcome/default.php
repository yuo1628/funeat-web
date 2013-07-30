<div class="leftBox">
	<div class="leftBanner">
		<div class="leftCLose">
			X
		</div>
	</div>
	<div class="leftMenu">
		<div class="leftItem">
			<div class="leftItemImg">
				<img src="http://pic.pimg.tw/weisue/4959ed37a5873.jpg" />
			</div>
			<div class="leftItemDesc">
				<div class="leftItemDescTitle">
					台灣麥當勞
				</div>
				<div class="leftItemDescOther">
					good
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="leftItem">
			<div class="leftItemImg">
				<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
			</div>
			<div class="leftItemDesc">
				<div class="leftItemDescTitle">
					肯德基
				</div>
				<div class="leftItemDescOther">
					good
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="leftItem">
			<div class="leftItemImg">
				<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
			</div>
			<div class="leftItemDesc">
				<div class="leftItemDescTitle">
					肯德基
				</div>
				<div class="leftItemDescOther">
					good
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="leftItem">
			<div class="leftItemImg">
				<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
			</div>
			<div class="leftItemDesc">
				<div class="leftItemDescTitle">
					肯德基
				</div>
				<div class="leftItemDescOther">
					good
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="leftItem">
			<div class="leftItemImg">
				<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
			</div>
			<div class="leftItemDesc">
				<div class="leftItemDescTitle">
					肯德基
				</div>
				<div class="leftItemDescOther">
					good
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="contentBox">
	<div class="localBox">
		<div class="localImg">
			<img src="http://news.xinhuanet.com/jiaju/2011-10/13/122138270_111n.jpg"  />
		</div>
		<div class="localTitle">
			長泓資訊有限公司
		</div>
		<div class="localDescBox">
			<div class="localDescMenu">
				<div class="localDescItem">
					台中市北屯區大連路三段10號7F-2
				</div>
				<div class="localDescItem">
					營業時間 : 0900 - 1800
				</div>
			</div>
		</div>
		<div class="localDescBar">
			<div class="localDescBarItem">
				詳細資訊
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="localPrice">
			NT. 30~120
		</div>
	</div>
	<div id="mapBox" class="mapBox"></div>
	<script>
		var lat = 25.08;
		var lon = 121.45;
		if (navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(function(position)
			{
				lat = position.coords.latitude;
				lon = position.coords.longitude;
				new GMaps(
				{
					div : '#mapBox',
					lat : lat,
					lng : lon
				});
			});
		}
		new GMaps(
		{
			div : '#mapBox',
			lat : lat,
			lng : lon
		});
	</script>
</div>
