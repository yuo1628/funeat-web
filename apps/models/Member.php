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
	public function verify($identity, $password)
	{
		if (preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $identity))
		{
			$find = array(
				'email' => $identity,
				'password' => md5($password)
			);

			$member = $this->_repository->findBy($find);
		}
		else
		{
			$find = array(
				'username' => $identity,
				'password' => md5($password)
			);

			$member = $this->_repository->findBy($find);
		}

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
	 * Check member is login
	 *
	 * @param Session
	 *
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

	/**
	 * Get login member object
	 *
	 * @param Session
	 *
	 * @return models\entity\member\Members
	 */
	public function getLoginMember($session)
	{
		$result = null;

		if ($this->isLogin($session))
		{
			$sess = $session->userdata(self::SESSION_NAMESPACE);
			$result = $this->getItem($sess[self::SESSION_ID]);
		}

		return $result;
	}

}
