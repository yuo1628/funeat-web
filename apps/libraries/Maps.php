<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Maps Class
 *
 * @author			Miles <jangconan@gmail.com>
 * @copyright		Copyright (c) 20011 - 2013, DreamOn, Inc.
 */
class Maps
{
	/**
	 * Constructor.
	 *
	 * @since		1.0
	 */
	public function __construct()
	{
	}

	/**
	 * Get distance between two position.
	 *
	 * @param		float	Lat of position 1
	 * @param		float	Lng of position 1
	 * @param		float	Lat of position 2
	 * @param		float	Lng of position 2
	 *
	 * @return		float	The distance.
	 *
	 * @since		1.0
	 */
	public static function getDistance($lat1, $lng1, $lat2, $lng2)
	{
		$radLat1 = deg2rad($lat1);
		$radLat2 = deg2rad($lat2);

		$a = $radLat1 - $radLat2;
		$b = deg2rad($lng1) - deg2rad($lng2);

		$s = 2 * asin(sqrt(pow(sin($a * 0.5), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b * 0.5), 2)));
		$s = $s * 6378137;

		return $s;
	}

}
