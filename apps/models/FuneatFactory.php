<?php

namespace models;

use models\ModelFactory;

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
	 * @var		array
	 */
	private static $_members = array();

	/**
	 * Store login member instance
	 *
	 * @var		array
	 */
	private static $_member;

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
	 * Get model instance
	 *
	 * @param		mixed		$identity
	 * @param		boolean		$useId
	 *
	 * @return		Member
	 */
	public static function getMember($identity = null, $useId = false)
	{
		$member = ModelFactory::getInstance('models\\Member');

		if (is_null($identity))
		{
			self::$_member = $member->getLoginMember(self::getSession());
			self::$_members[self::$_member->getId()] = self::$_member;
			self::$_members[self::$_member->getUuid()] = self::$_member;

			return self::$_member;
		}
		else
		{
			self::$_members[$identity] = $member->getItemByIdentity($identity, $useId);

			return self::$_members[$identity];
		}
	}

}
