<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../protected/boot.php';
require __DIR__ . '/../protected/autoload.php';


class EmailTest
	extends PHPUnit_Framework_TestCase
{
	private $sender;
	private $reflector;

	protected function setUp() {
		\T4\Mvc\Application
			::getInstance()
			->setConfig(
				new \T4\Core\Config(ROOT_PATH_PROTECTED . '/config.php')
			);

		$this->sender = new App\Models\SenderValid();
		$this->reflector = new ReflectionMethod($this->sender, 'validateEmail');
		$this->reflector->setAccessible(true);
	}

	/**
	 * @dataProvider emailProvider
	 */
	public function testEmailValidate($isValid, $email) {
		$this->assertEquals($isValid, $this->reflector->invoke($this->sender, $email));
	}

	public function emailProvider() {
		return [
			[false, 'badEmail'],
			['good@email.com',  'good@email.com']
		];
	}
}