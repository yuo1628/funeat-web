<?php

namespace models\restaurant;

/**
 * Process hours data for Restaurants
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Hours
{
	/**
	 * Constants
	 */
	const HOURS_DAYS = 'days';

	/**
	 * Constants
	 */
	const HOURS_START = 'start';

	/**
	 * Constants
	 */
	const HOURS_END = 'end';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION = 'exception';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION_TYPE = 'type';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION_VALUE = 'value';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION_MONTH = 'month';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION_MONTH_WEEK = 'month_week';

	/**
	 * Constants
	 */
	const HOURS_EXCEPTION_MONTH_DAY = 'month_day';

	/**
	 * Data will translate to JSON string
	 */
	private $data;

	/**
	 * Constructor
	 *
	 * @param		string JSON data
	 */
	public function __construct($json = null)
	{
		$data = json_decode($json);

		if ($data)
		{
			$this->data = $data;
		}
		else
		{
			$this->data = array(
				self::HOURS_DAYS => array(
					0 => array(),
					1 => array(),
					2 => array(),
					3 => array(),
					4 => array(),
					5 => array(),
					6 => array()
				),
				self::HOURS_EXCEPTION => array()
			);
		}
	}

	/**
	 * Get raw data
	 *
	 * @return		array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Get data which in some day
	 *
	 * @return		array | null
	 */
	public function getDay($day)
	{
		$day = (int)$day;

		if ($day >= 0 && $day <= 6)
		{
			return $this->data[$day];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Put time into data
	 *
	 * @param		start Start time ( use mktime($hour, $minute, 0, 1, 1, 1970) )
	 * @param		end End time ( use mktime($hour, $minute, 0, 1, 1, 1970) )
	 * @param		day Set day will put in
	 * @param		position The position in that day
	 */
	public function putDays($start, $end, $day = null, $position = null)
	{

	}

	/**
	 * Put exception into data
	 *
	 * @param		type
	 * @param		value
	 * @param		month
	 */
	public function putException($type, $value, $month = null, $position = null)
	{
		$put = array(
			self::HOURS_EXCEPTION_TYPE => $type,
			self::HOURS_EXCEPTION_VALUE => $value,
			self::HOURS_EXCEPTION_MONTH => $month
		);

		if ($position === null)
		{
			$this->data[self::HOURS_EXCEPTION][] = $put;
		}
		else
		{
			$position = (int)$position;
			$this->data[self::HOURS_EXCEPTION][$position] = $put;
		}
	}

	/**
	 * Return JSON String of data
	 *
	 * @return 		string
	 */
	public function __toString()
	{
		return json_encode($this->data);
	}

}
