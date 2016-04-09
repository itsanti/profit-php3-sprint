<?php


namespace App\Models;

use T4\Orm\Model;

class User
	extends Model
{
	const DEFAULT_USER_NAME = 'Guest';

	public static function getUserFullName($user)
	{
		$fullName = self::DEFAULT_USER_NAME;

		if (!empty($user))
		{
			switch (true) {
				case (empty($user->name) || empty($user->surname)):
					$fullName = $user->email;
					break;
				case (empty($user->patronymic)):
					$fullName = sprintf('%s %s', $user->name, $user->surname);
					break;
				default:
					$fullName = sprintf('%s %s %s', $user->name, $user->patronymic, $user->surname);
					break;
			}
		}

		return $fullName;
	}
}