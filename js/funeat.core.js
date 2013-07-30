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
		}
	}
};
