<?php

namespace App\Commands;

use T4\Mvc\Application;
use T4\Console\Command;
use App\Models\SenderValid;

class Send
	extends Command
{
	public function actionUsersCount($to) {

		\T4\Mvc\Application
			::getInstance()
			->setConfig(
				new \T4\Core\Config(ROOT_PATH_PROTECTED . '/config.php')
			);


		$count = $this->app->db->default
			->query('SELECT COUNT(*) FROM users')->fetchScalar();

		$subject = 'Total users on ' . date('Y/m/d/ - H:i');
		$message = 'Hi! Now you have ' . $count . ' users.';

		$sender = new SenderValid();

		if(!$sender->isValid($to)) {
			$this->writeLn("[send/userscount]: email address is considered invalid");
			exit(1);
		}

		$result = $sender->sendMail($to, $subject, $message);
		if ($result) {
			$this->writeLn("[send/userscount]: email was sent successfully");
		} else {
			$this->writeLn("[send/userscount]: error: email wasn't sent");
		}
	}
}