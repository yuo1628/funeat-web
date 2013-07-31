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
	<div id="mapBox" class="mapBox"></div>
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			map = new GMaps(
			{
				div : '#mapBox',
				lat : Funeat.Storage.localLat,
				lng : Funeat.Storage.localLng,
				mapTypeId : google.maps.MapTypeId.ROADMAP,
				scaleControl : false,
				mapTypeControl : false,
				mapTypeControlOptions :
				{
					style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
				}
			});

			if (localStorage.localLatitude == undefined || localStorage.localLongitude == undefined)
			{
				GMaps.geolocate(
				{
					success : function(position)
					{
						if (localStorage.localLatitude == undefined)
						{
							localStorage.localLatitude = position.coords.latitude;
						}
						if (localStorage.localLongitude == undefined)
						{
							localStorage.localLongitude = position.coords.longitude;
						}
						map.setCenter(position.coords.latitude, position.coords.longitude);
						map.addMarker(
						{
							lat : position.coords.latitude,
							lng : position.coords.longitude,
							draggable : true,
							animation : google.maps.Animation.DROP,
							infoWindow :
							{
								content : $("#localTemplate").text(),
							},
							dragend : function()
							{
								var pos = this.getPosition();
								localStorage.localLatitude = pos.lat();
								localStorage.localLongitude = pos.lng();
								GMaps.geocode(
								{
									lat : pos.lat(),
									lng : pos.lng(),
									callback : function(results, status)
									{
										if (results && results.length > 0)
										{
											alert(results[0].formatted_address);
										}
									}
								});
							}
						});
					},
					error : function(error)
					{
						alert('Geolocation failed: ' + error.message);
					},
					not_supported : function()
					{
						alert("Your browser does not support geolocation");
					},
					always : function()
					{
						alert("Done!");
					}
				});
			}
			else
			{
				map.setCenter(localStorage.localLatitude, localStorage.localLongitude);
				map.addMarker(
				{
					lat : localStorage.localLatitude,
					lng : localStorage.localLongitude,
					draggable : true,
					animation : google.maps.Animation.DROP,
					infoWindow :
					{
						content : $("#localTemplate").text(),
					},
					dragend : function()
					{
						var pos = this.getPosition();
						localStorage.localLatitude = pos.lat();
						localStorage.localLongitude = pos.lng();
						GMaps.geocode(
						{
							lat : pos.lat(),
							lng : pos.lng(),
							callback : function(results, status)
							{
								if (results && results.length > 0)
								{
									//alert(results[0].formatted_address);
								}
							}
						});
					}
				});
			}
		});
	</script>
	<script type="text/html" id="localTemplate">
		<img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/c19.19.244.244/s160x160/1010285_661668367180129_2143900233_n.jpg" />
	</script>
	<script type="text/html" id="markersTemplate"></script>
</div>
