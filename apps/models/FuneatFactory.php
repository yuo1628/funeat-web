<?php

namespace models;

use models\ModelFactory;
use models\Member as MemberModel;

/**
 * Funeat quick loading factory
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
abstract class FuneatFactory
{
	/**
	 * Store session instance
	 *
	 * @var		Session
	 */
	private static $_session;

	/**
	 * Store member instance
	 *
	 * @var		\models\entity\member\Members[]
	 */
	private static $_members = array();

	/**
	 * Store login member instance
	 *
	 * @var		\models\entity\member\Members
	 */
	private static $_member = null;

	/**
	 * Store restaurant instance
	 *
	 * @var		array
	 */
	private static $_restaurants = array();

	/**
	 * Get CI instance
	 *
	 * @param		string		$identity
	 */
	public static function getCI()
	{
		return get_instance();
	}

	/**
	 * Get session instance
	 *
	 * @return		Session
	 */
	public static function getSession()
	{
		if (is_null(self::$_session))
		{
			$CI = self::getCI();
			$CI->load->library('session');

			self::$_session = $CI->session;
		}

		return self::$_session;
	}

	/**
	 * Check login stat
	 *
	 * @return		Session
	 */
	public static function isLogin()
	{
		return MemberModel::isLogin(self::getSession());
	}

	/**
	 * Get member.
	 *
	 * @param		mixed		$identity
	 * @param		boolean		$useId
	 *
	 * @return		\models\entity\member\Members
	 */
	public static function getMember($identity = null, $useId = false)
	{
		$member = ModelFactory::getInstance('models\\Member');

		if (is_null($identity))
		{
			if (self::isLogin())
			{
				self::$_member = $member->getLoginMember(self::getSession());

				self::$_members[self::$_member->getId()] = self::$_member;
				self::$_members[self::$_member->getUuid()] = self::$_member;
			}
			return self::$_member;
		}
		else
		{
			self::$_members[$identity] = $member->getItemByIdentity($identity, $useId);

			return self::$_members[$identity];
		}
	}

	/**
	 * Get restaurant
	 *
	 * @param		mixed		$identity
	 * @param		boolean		$useId
	 *
	 * @return		\models\entity\restaurant\Restaurants
	 */
	public static function getRestaurant($identity = null, $useId = false)
	{
		$restaurant = ModelFactory::getInstance('models\\Restaurant');

		if (is_null($identity))
		{
			return null;
		}
		else
		{
			self::$_restaurants[$identity] = $restaurant->getItemByIdentity($identity, $useId);

			return self::$_restaurants[$identity];
		}
	}

	/**
	 * Get restaurant
	 *
	 * @param		mixed		$identity
	 * @param		boolean		$useId
	 *
	 * @return		\models\entity\restaurant\Restaurants
	 */
	public static function getRestaurantInstance()
	{
		return ModelFactory::getInstance('models\\Restaurant')->getInstance();
	}

}
