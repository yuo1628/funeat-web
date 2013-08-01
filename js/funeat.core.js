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
	RESTAURANT_LIST_ACTION : "restaurant/list",
	RESTAURANT_ADD_ACTION : "restaurant/add",
	RESTAURANT_EDIT_ACTION : "restaurant/edit"
}

var Funeat = Funeat ||
{
	
    Storage : {
        localManual : localStorage.localManual == undefined ? 0 : localStorage.localManual,
        localLat : localStorage.localLatitude == undefined ? 25.08 : localStorage.localLatitude,
        localLng : localStorage.localLongitude == undefined ? 121.45 : localStorage.localLongitude
    },
	Post :
	{
	},
	Get :
	{
	}
}

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
         * @param Gmaps
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
						map.removeMarkers();
						map.setCenter(latlng.lat(), latlng.lng());
						map.addMarker(
						{
							lat : latlng.lat(),
							lng : latlng.lng(),
							draggable : true,
							dragend : function()
							{
								latlng = this.getPosition();
								localStorage.localLatitude = latlng.lat();
								localStorage.localLongitude = latlng.lng();
								GMaps.geocode(
								{
									lat : latlng.lat(),
									lng : latlng.lng(),
									callback : function(results, status)
									{
										if (results && results.length > 0)
										{
											jQuery("#localAddress").val(results[0].formatted_address);
											jQuery("#localLatitude").val(latlng.lat());
											jQuery("#localLongitude").val(latlng.lng());
										}
									}
								});
							}
						});
						jQuery("#localLatitude").val(latlng.lat());
						jQuery("#localLongitude").val(latlng.lng());
					}
				}
			});
		}
	},
	Map :
	{
		/**
		 * When click route
		 *
		 * @param  GMaps  map  Show map
		 * @param  google.maps.LatLng  start  Start position
		 * @param  google.maps.LatLng  target  Target position
		 */
		
		onRoute : function(map, start, target)
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
		onGeolocate : function(map, start, target)
		{
			jQuery("#")
		}
	}
};
