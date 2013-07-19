<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Member model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Member extends Model
{
	/**
	 * Session constants
	 */
	const SESSION_NAMESPACE = 'member';
	const SESSION_IS_LOGIN = 'isLogin';
	const SESSION_ID = 'id';

	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\member\\Members")
	{
		parent::__construct($entity);
	}

	/**
	 * Verify user
	 *
	 * @return models\entity\member\Members | null when not found.
	 */
	public function verify($username, $password)
	{
		$find = array(
			'username' => $username,
			'password' => md5($password)
		);

		$member = $this->_repository->findBy($find);

		if (empty($member))
		{
			return null;
		}
		else
		{
			return $member[0];
		}
	}

	/**
	 * Do login
	 *
	 * @param Session
	 * @param models\entity\member\Members
	 */
	public function login($session, $member)
	{
		$data = array(
			self::SESSION_IS_LOGIN => true,
			self::SESSION_ID => $member->id
		);

		$session->set_userdata(self::SESSION_NAMESPACE, $data);
	}

	/**
	 * Do logout
	 *
	 * @return void
	 */
	public function logout()
	{
		$session->unset_userdata(self::SESSION_NAMESPACE);
	}

	/**
	 * Check user is login
	 *
	 * @param Session
	 * @return boolean
	 */
	public function isLogin($session)
	{
		if ($session->userdata(self::SESSION_NAMESPACE))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
