<?php


namespace App\Models;

use T4\Orm\Model;

class User
	extends Model
{
	const DEFAULT_USER_NAME = 'Guest';

	/**
	 * @param $user
	 * @template "$lastName/$firstName <$email>"
	 * @return string
	 */
	public static function getUserFullName($user)
	{
		$fullName = self::DEFAULT_USER_NAME;

		$reflector  = new \ReflectionMethod(__CLASS__, __FUNCTION__);
		$sprReflect = new \ReflectionFunction('sprintf');

		preg_match('~@template "(.+)"\n~', $reflector->getDocComment(), $tpl);
		$format = preg_replace('~\$\w+~', '%s', $tpl[1]);
		preg_match_all('~\$(\w+)~', $tpl[1], $vars);

		if (!empty($user))
		{
			// set template variables
			$email      = $user->email;
			$firstName  = $user->name;
			$patronymic = $user->patronymic;
			$lastName   = $user->surname;

			if(empty($firstName) || empty($lastName)) {
				$fullName = $email;
			} else {
				$invokeArgs = [$format];

				foreach($vars[1] as $arg) {
					$invokeArgs[] = $$arg;
				}

				$fullName = $sprReflect->invokeArgs($invokeArgs);
			}
		}

		return $fullName;
	}
}
