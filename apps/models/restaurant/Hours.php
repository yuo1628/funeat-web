<?php

namespace models\restaurant;

use models\entity\restaurant\Features;

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
	 * Time Divide Constants
	 */
	const BREAKFAST = 1;
	const BRUNCH = 2;
	const LUNCH = 3;
	const TEA = 4;
	const DINNER = 5;
	const MIDNIGHT_SNACK = 6;

	/**
	 * 時段標籤與Feature的對應
	 *
	 * @access private
	 */
	private static $timeDivideTofeatureMapping = array(
		self::BREAKFAST => NULL,
		self::BRUNCH => NULL,
		self::LUNCH => NULL,
		self::TEA => NULL,
		self::DINNER => NULL,
		self::MIDNIGHT_SNACK => NULL
	);

	const DAY_IN_SECONDS = 86400;

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
		$data = json_decode($json, true);

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
	 * Return JSON String of data
	 *
	 * @return 		string
	 */
	public function __toString()
	{
		return json_encode($this->data);
	}

	/**
	 * is the time in the interval?
	 *
	 * @access private
	 * @param int $time
	 * @param array $interval
	 * @return boolean
	 */
	private static function _inInterval($time, $interval)
	{
		$start = $interval['start'];
		$end = $interval['end'];
		if ($start <= $time and $time <= $end)
		{
			return True;
		}
		else
		{
			return False;
		}
	}

	/**
	 * Validation time divide
	 *
	 * @param		int			$timeDivide
	 *
	 * @return		boolean
	 */
	public static function checkTimeDivide($timeDivide)
	{
		// Validation
		switch ($timeDivide)
		{
			case self::BREAKFAST :
			case self::BRUNCH :
			case self::LUNCH :
			case self::TEA :
			case self::DINNER :
			case self::MIDNIGHT_SNACK :
				return true;
			default:
				return false;
		}
	}

	/**
	 * Make timestamp of a day
	 *
	 * @access public
	 * @param int $hour
	 * @param int $minute
	 * @return int
	 */
	public static function mkdaytime($hour, $minute)
	{
		try {
			$time = new \DateTime("1970-1-1 $hour:$minute:0", new \DateTimeZone('GMT'));
			return $time->getTimestamp();
		} catch (Exception $e) {
			return -1;
		}
	}

	/**
	 * Set time divide constant to feature mapping
	 *
	 * @access public
	 * @param int $timeDivide
	 * @param Feature $feature
	 */
	public static function setTimeDivideToFeatureMapping($timeDivide, Features $feature)
	{
		if (self::checkTimeDivide($timeDivide)) {
			self::$timeDivideTofeatureMapping[$timeDivide] = $feature;
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
			$data = $this->data[self::HOURS_DAYS][$day];
			$data = array_map(function($dayData)
			{
				$dayData['feature'] = self::$timeDivideTofeatureMapping[$dayData['feature']];
				return $dayData;
			}, $data);
			return $data;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Put time into data
	 *
	 * @param		int		$start		Start time ( use Hours::mkdaytime($hour, $minute) )
	 * @param		int		$end		End time ( use Hours::mkdaytime($hour, $minute) )
	 * @param		int		$day
	 * @param		int		$type		Use constants defined in this class
	 */
	public function putDay($start, $end, $day, $type)
	{
		$error = '';
		if (!($end > $start) or $day > 6 or $day < 0)
		{
			$error = 'Invalid arguments';
		}
		else
		{
			foreach ($this->data[self::HOURS_DAYS][$day] as $interval)
			{
				if (self::_inInterval($start, $interval))
				{
					$error = 'time overlaps';
					break;
				}
				else if (self::_inInterval($end, $interval))
				{
					$error = 'time overlaps';
					break;
				}
				else if (self::_inInterval($interval[0], array(
					'start' => $start,
					'end' => $end
				)))
				{
					$error = 'time overlaps';
					break;
				}
			}
		}
		if ($error)
		{
			throw new \InvalidArgumentException($error);
		}

		$this->data[self::HOURS_DAYS][$day][] = array(
			'start' => $start,
			'end' => $end,
			'feature' => $type
		);
		sort($this->data[self::HOURS_DAYS][$day]);
	}

	/**
	 * is time in the day?
	 *
	 * @access public
	 * @param int $time
	 * @param int $day
	 * @return boolean
	 */
	public function isTimeInDay($time, $day)
	{
		foreach ($this->data[self::HOURS_DAYS][$day] as $interval)
		{
			if (self::_inInterval($time, $interval))
			{
				return True;
			}
		}
		return False;
	}

	/**
	 * is time in any day?
	 *
	 * @access public
	 * @param int $time use Hours::mkdaytime
	 * @return array
	 */
	public function isTimeInDays($time)
	{
		$days = array();
		foreach ($this->data[self::HOURS_DAYS] as $day => $intervals)
		{
			if ($this->isTimeInDay($time, $day))
			{
				$days[] = $day;
			}
		}
		return $days;
	}

	/**
	 * 指定的時間是否在例外休假時間？
	 *
	 * @access public
	 * @param DateTime $datetime
	 * @return boolean
	 */
	public function isDateTimeInException($datetime)
	{
		// search for exceptions of day of month
		$month = (int)$datetime->format('n');
		// 1 ~ 12
		$day = (int)$datetime->format('j');
		// 1 ~ 31
		// search for exceptions of day of week.
		//$weekBaseDay = 1 - (int) (new \DateTime($datetime->format('Y-m-01')))->format('w');
		$week = floor(($day - $weekBaseDay) / 7) + 1;
		$weekDay = (int)$datetime->format('w');
		return in_array($this->makeException(self::HOURS_EXCEPTION_MONTH_DAY, $day, null), $this->data[self::HOURS_EXCEPTION]) or in_array($this->makeException(self::HOURS_EXCEPTION_MONTH_WEEK, array(
			'week' => $week,
			'day' => $weekDay
		), null), $this->data[self::HOURS_EXCEPTION]);
	}

	/**
	 * 設定每個月份中的例外休假
	 *
	 * @access public
	 * @param int $day
	 */
	public function putDayException($day, $position = null)
	{
		$this->putException(self::HOURS_EXCEPTION_MONTH_DAY, $day, null, $position);
	}

	/**
	 * 設定每個月份的固定星期中的例外休假
	 *
	 * @access public
	 * @param int $day
	 * @param int $week
	 */
	public function putWeekException($day, $week, $position = null)
	{
		$this->putException(self::HOURS_EXCEPTION_MONTH_WEEK, array(
			'week' => $week,
			'day' => $day
		), null, $position);
	}

	/**
	 * Put exception into data
	 *
	 * @param		type
	 * @param		value
	 * @param		month
	 */
	private function putException($type, $value, $month, $position)
	{
		$put = $this->makeException($type, $value, $month);

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
	 * format and return exception data
	 *
	 * @access private
	 * @param int $type
	 * @param int $value
	 * @param int $month
	 * @return array
	 */
	private function makeException($type, $value, $month)
	{
		return array(
			self::HOURS_EXCEPTION_TYPE => $type,
			self::HOURS_EXCEPTION_VALUE => $value,
			self::HOURS_EXCEPTION_MONTH => $month
		);
	}

}
