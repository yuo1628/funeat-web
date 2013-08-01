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
		$data = json_decode($json, True);

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
     * make timestamp of a day
     *
     * @access public
     * @param int $hour
     * @param int $minute
     * @return int
     */
    public static function mkdaytime($hour, $minute)
    {
        $time = new \DateTime("1970-1-1 $hour:$minute:0", new \DateTimeZone('GMT'));
        return $time->getTimestamp();
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
			return $this->data[self::HOURS_DAYS][$day];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Put time into data
	 *
	 * @param		start Start time ( use Hours::mkdaytime($hour, $minute) )
	 * @param		end End time ( use Hours::mkdaytime($hour, $minute) )
     * @param int $day
	 */
	public function putDay($start, $end, $day)
	{
        $error = '';
        if (!($end > $start) or $day > 6 or $day < 0) {
            $error = 'Invalid arguments';
        } else {
            foreach ($this->data[self::HOURS_DAYS][$day] as $interval) {
                if (self::inInterval($start, $interval)) {
                    $error = 'time overlaps';
                    break;
                } else if (self::inInterval($end, $interval)) {
                    $error = 'time overlaps';
                    break;
                } else if (self::inInterval($interval[0], array($start, $end))) {
                    $error = 'time overlaps';
                    break;
                }
            }
        }
        if ($error) {
            throw new \InvalidArgumentException($error);
        }
        
        $this->data[self::HOURS_DAYS][$day][] = array($start, $end);
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
        foreach ($this->data[self::HOURS_DAYS][$day] as $interval) {
            if (self::inInterval($time, $interval)) {
                return True;
            }
        }
        return False;
    }
    
    /**
     * is time in any day?
     *
     * @access public
     * @param int $time
     * @return array
     */
    public function isTimeInDays($time)
    {
        $days = array();
        foreach ($this->data[self::HOURS_DAYS] as $day => $intervals) {
            if ($this->isTimeInDay($time, $day)) {
                $days[] = $day;
            }
        }
        return $days;
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

    /**
     * is the time in the interval?
     *
     * @access private
     * @param int $time
     * @param array $interval
     * @return boolean
     */
    private static function inInterval($time, $interval)
    {
        $start = $interval[0];
        $end = $interval[1];
        if ($start <= $time and $time <= $end) {
            return True;
        } else {
            return False;
        }
    }
}
