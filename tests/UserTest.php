<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../protected/boot.php';
require __DIR__ . '/../protected/autoload.php';

use App\Models\User;


class UserMock
{
	const USER_EMAIL = 'test@dev.com';
	const TPL = 'Lerdorf/Rasmus <'.UserMock::USER_EMAIL.'>';

	public function __construct($name, $patronymic, $surname)
	{
		$this->email = self::USER_EMAIL;
		$this->name = $name;
		$this->patronymic = $patronymic;
		$this->surname = $surname;
	}
}

class UserTest
	extends PHPUnit_Framework_TestCase
{
	public function testUserFullNameIsDefault() {
		$this->assertEquals(User::DEFAULT_USER_NAME, User::getUserFullName(null));
	}

	/**
	 * @dataProvider userProvider
	 */
	public function testUserFullName($expected, $actual) {
		$mock = $this->getMock('UserMock', [], $actual);
		$this->assertEquals($expected, User::getUserFullName($mock));
	}

	public function userProvider() {
		return [
			[UserMock::USER_EMAIL, [null, null, null]],
			[UserMock::USER_EMAIL, [null, null, 'Lerdorf']],
			[UserMock::USER_EMAIL, [null, 'PHP', null]],
			[UserMock::USER_EMAIL, [null, 'PHP', 'Lerdorf']],
			[UserMock::USER_EMAIL, ['Rasmus', null, null]],
	        [UserMock::TPL,        ['Rasmus', null, 'Lerdorf']],
			[UserMock::USER_EMAIL, ['Rasmus', 'PHP', null]],
			[UserMock::TPL,        ['Rasmus', 'PHP', 'Lerdorf']],
		];
	}
}
