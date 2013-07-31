/**
 * @author      Miles <jangconan@gmail.com>
 */
var CONST = CONST ||
{
	/**
	 * Rewrite prefix. It must be empty if rewrite is opening.
	 */
	REWRITE : "index.php/",

	/**
	 * Member action
	 */
	LOGIN_ACTION : "login",
	LOGOUT_ACTION : "logout",
	REGISTER_ACTION : "member/register",

	/**
	 * Restaurant action
	 */
	RESTAURANT_QUERY_ACTION : "restaurant/query/",
	RESTAURANT_ADD_ACTION : "restaurant/add",
	RESTAURANT_EDIT_ACTION : "restaurant/edit"
};

var Funeat = Funeat ||
{
	Storage :
	{
		localManual : localStorage.localManual == undefined ? 0 : localStorage.localManual,
		localLat : localStorage.localLatitude == undefined ? 25.08 : localStorage.localLatitude,
		localLng : localStorage.localLongitude == undefined ? 121.45 : localStorage.localLongitude
	},
	Map : function(target)
	{
		/**
		 * @var google.maps.Marker
		 */
		var _localMarker;

		/**
		 * @var google.maps.Marker[]
		 */
		var _remoteMarker = new Array();

		/**
		 * @var google.maps.Circle
		 */
		var _circle;

		var _showLocalMarker = true;

		var _map;

		localStorage.localManual = localStorage.localManual == undefined ? 0 : localStorage.localManual;
		localStorage.localLatitude = localStorage.localLatitude == undefined ? 25.08 : localStorage.localLatitude;
		localStorage.localLongitude = localStorage.localLongitude == undefined ? 121.45 : localStorage.localLongitude;
		localStorage.range = localStorage.range == undefined ? 500 : localStorage.range;

		this.localManual = localStorage.localManual;
		this.localLat = localStorage.localLatitude;
		this.localLng = localStorage.localLongitude;
		this.range = Number(localStorage.range);

		this.mainMap = new GMaps(
		{
			div : target,
			lat : this.localLat,
			lng : this.localLng,
			mapTypeId : google.maps.MapTypeId.ROADMAP,
			scaleControl : false,
			mapTypeControl : false,
			mapTypeControlOptions :
			{
				style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
			}
		});

		_map = this.mainMap;

		_circle = this.mainMap.drawCircle(
		{
			lat : this.localLat,
			lng : this.localLng,
			fillColor : '#000000',
			fillOpacity : 0.2,
			radius : this.range
		});

		_localMarker = this.mainMap.addMarker(
		{
			lat : this.localLat,
			lng : this.localLng,
			draggable : true,
			animation : google.maps.Animation.DROP,
			infoWindow :
			{
				content : jQuery("#localTemplate").text(),
			},
			drag : function()
			{
				latlng = this.getPosition();
				_circle.setCenter(latlng);
			},
			dragend : function()
			{
				var latlng = this.getPosition();

				GMaps.geocode(
				{
					lat : latlng.lat(),
					lng : latlng.lng(),
					callback : function(results, status)
					{
						if (results && results.length > 0)
						{
							for (var i in _remoteMarker)
							{
								_remoteMarker[i].setMap(null);
							}
							jQuery("#localAddress").val(results[0].formatted_address);
							jQuery("#localLatitude").val(latlng.lat());
							jQuery("#localLongitude").val(latlng.lng());
						}
					}
				});

				_localMarker.setDraggable(false);
				_updateLocal(latlng);

			}
		});

		this.onUpdateLocate = function(latlng)
		{
			_updateLocal(latlng);
		}

		this.getLocalMarker = function()
		{
			return _localMarker;
		}

		this.getLocalMarker = function()
		{
			return _localMarker;
		}
		/**
		 * Update markers
		 */
		function _updateRemote(json)
		{
			for (var i in json)
			{
				_remoteMarker[i] = _map.addMarker(
				{
					lat : json[i].latitude,
					lng : json[i].longitude,
					animation : google.maps.Animation.BOUNCE,
					infoWindow :
					{
						content : jQuery("#localTemplate").text(),
					}
				});
			}
			_localMarker.setDraggable(true);

		}

		function _getMap()
		{
			return this.mainMap;
		}

		function _updateLocal(latlng)
		{
			localStorage.localLatitude = latlng.lat();
			localStorage.localLongitude = latlng.lng();

			_circle.setCenter(latlng);

			//this.localLat = localStorage.localLatitude;
			//this.localLng = localStorage.localLongitude;

			_localMarker.setPosition(latlng);

			var queryUrl = CONST.REWRITE + CONST.RESTAURANT_QUERY_ACTION + localStorage.localLatitude + "/" + localStorage.localLongitude + "?distance=" + localStorage.range;

			jQuery.get(queryUrl,
			{
			}, function(data)
			{
				_updateRemote(data);
			});
		}

	},

	MapStatic :
	{
		/**
		 * When click route
		 *
		 * @param  Funeat.Map  map  Show map
		 * @param  google.maps.LatLng  start  Start position
		 * @param  google.maps.LatLng  target  Target position
		 */
		route : function(map, start, target)
		{
			map.drawRoute(
			{
				origin : [start.lat(), start.lng()],
				destination : [target.lat(), target.lng()],
				travelMode : 'driving',
				strokeColor : '#131540',
				strokeOpacity : 0.6,
				strokeWeight : 6
			});
			map.setCenter(start.lat(), start.lng());
			map.hideInfoWindows();
		},
		/**
		 * When click geolocate
		 *
		 * @param  Funeat.Map  map  Show map
		 * @param  google.maps.LatLng  start  Start position
		 * @param  google.maps.LatLng  target  Target position
		 */
		geolocate : function(map)
		{
			GMaps.geolocate(
			{
				success : function(position)
				{
					var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

					map.onUpdateLocate(latlng);

					map.mainMap.setCenter(latlng.lat(), latlng.lng());
				},
				error : function(error)
				{
					//alert('Geolocation failed: ' + error.message);
				},
				not_supported : function()
				{
					//alert("Your browser does not support geolocation");
				},
				always : function()
				{
					//alert("Done!");
				}
			});
		}
	},
	Post :
	{
	},
	Get :
	{
	}
};

var Listener = Listener ||
{
	TopBox :
	{
		/**
		 * Login button listener action
		 */
		loginBtn : function()
		{
			location.href = CONST.REWRITE + CONST.LOGIN_ACTION;
		},
		/**
		 * Logout button listener action
		 */
		logoutBtn : function()
		{
			location.href = CONST.REWRITE + CONST.LOGOUT_ACTION;
		},
		/**
		 * Register button listener action
		 */
		registerBtn : function()
		{
			location.href = CONST.REWRITE + CONST.REGISTER_ACTION;
		},
		/**
		 * On local manual clicked
		 */
		onLocalManualClick : function()
		{
			if (jQuery("#localManual").prop("checked"))
			{
				localStorage.localManual = 1;
				jQuery("#localAddress").removeAttr("disabled");

			}
			else
			{
				localStorage.localManual = 0;
				jQuery("#localAddress").prop("disabled", true);
			}
		},
		/**
		 * On local address changed
		 *
		 * @param Funeat.Map
		 */
		onLocalAddressChange : function(map)
		{
			GMaps.geocode(
			{
				address : jQuery("#localAddress").val().trim(),
				callback : function(results, status)
				{
					if (status == 'OK')
					{
						var latlng = results[0].geometry.location;
						map.mainMap.setCenter(latlng.lat(), latlng.lng());
						map.onUpdateLocate(latlng);
					}
				}
			});
		}
	}
};
