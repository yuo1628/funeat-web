<?php

namespace models;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use models\model\ORMModel as Model;
use models\entity\restaurant\Restaurants as MainEntity;

/**
 * Restaurant model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Restaurant extends Model
{
	/**
	 * Default range of nearest function
	 */
	const NEAREST_DEFAULT_RANGE = 500;

	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Restaurants")
	{
		parent::__construct($entity);
	}

	/**
	 * Get restaurant by identity
	 *
	 * @param		$identity	Identity Can use ID, UUID or username.
	 * @param		$useId		Query ID column.
	 *
	 * @return		models\entity\restaurant\Restaurants
	 */
	public function getItemByIdentity($identity, $useId = false)
	{
		$identity = trim($identity);

		$CI = get_instance();
		$CI->load->library('uuid');

		$item = null;

		if ($CI->uuid->is_valid($identity))
		{
			$item = $this->getItem($identity, MainEntity::COLUMN_UUID);
		}
		elseif ((int)$identity > 0 && $useId)
		{
			// integer
			$item = $this->getItem((int)$identity);
		}
		elseif (preg_match('/^\w+$/', $identity))
		{
			// match [0-9a-zA-Z_]+
			$item = $this->getItem($identity, MainEntity::COLUMN_USERNAME);
		}

		return $item;
	}

	/**
	 * Get nearest restaurant
	 *
	 * The distance expressions (PHP):
	 *
	 * $radLat1 = deg2rad($lat1);
	 * $radLat2 = deg2rad($lat2);
	 * $a = $radLat1 - $radLat2;
	 * $b = deg2rad($lng1) - deg2rad($lng2);
	 * $s = (2 * asin(sqrt(pow(sin($a * 0.5), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b * 0.5), 2)))) * 6378137;
	 *
	 * Function mapping (PHP -> MySQL) :
	 *
	 * deg2rad -> RADIANS
	 * asin -> ASIN
	 * sqrt -> SQRT
	 * pow -> POW
	 * sin -> SIN
	 * cos -> COS
	 *
	 * @param		$lat		Latitude of position
	 * @param		$lng		Longitude of position
	 * @param		$offset		Offset
	 * @param		$limit		Limit
	 * @param		$range		Range
	 *
	 * @return		array
	 */
	public function getItemsByNearest($lat, $lng, $offset = 0, $limit = 1, $range = self::NEAREST_DEFAULT_RANGE)
	{
		$rsm = new ResultSetMappingBuilder($this->_em);
		$rsm->addRootEntityFromClassMetadata('models\\entity\\restaurant\\Restaurants', 'r');
		$rsm->addScalarResult('distance', 'distance');

		$sql = 'SELECT *, ((2 * asin(sqrt(pow(sin((RADIANS(?)-RADIANS(`latitude`)) * 0.5), 2) + cos(RADIANS(?)) * cos(RADIANS(`latitude`)) * pow(sin((RADIANS(?) - RADIANS(`longitude`)) * 0.5), 2)))) * 6378137) as `distance` FROM restaurants HAVING `distance` < ? ORDER BY `distance` ASC LIMIT ?, ?';

		/**
		 * @var Doctrine\ORM\NativeQuery
		 */
		$query = $this->_em->createNativeQuery($sql, $rsm);

		$query->setParameter(1, $lat);
		$query->setParameter(2, $lat);
		$query->setParameter(3, $lng);
		$query->setParameter(4, $range);
		$query->setParameter(5, $offset);
		$query->setParameter(6, $limit);

		$items = $query->getResult();

		foreach ($items as $i => $item)
		{
			$item[0]->setDistance($item['distance']);
			$items[$i] = $item[0];
		}

		return $items;
	}

	/**
	 * Get restaurant randomly
	 *
	 * @param		integer		$num		Limit, [1, infinity)
	 *
	 * @return		array
	 */
	public function getItemsByRandomly($num = 1, $condition = array())
	{
		$total = $this->getCount($condition);
		$num = ($total <= $num) ? $total : $num;

		$rand = array();

		if ($num == 1)
		{
			$rand[] = array_rand(range(1, $total));
		}
		else
		{
			$rand = array_rand(range(1, $total), $num);
		}
		foreach ($rand as &$v)
		{
			$v++;
		}
		shuffle($rand);

		$query = $this->_em->createQueryBuilder();

		$query->select('r');
		$query->from('models\\entity\\restaurant\\Restaurants', 'r');
		$query->where('r.id IN (' . implode(',', $rand) . ')');

		return $query->getQuery()->getResult();
	}

}
