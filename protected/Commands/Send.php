<?php

namespace App\Commands;

use T4\Mvc\Application;
use T4\Console\Command;
use T4\Mail\Sender;


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

		$sender = new Sender();
		$result = $sender->sendMail($to, $subject, $message);
		if ($result) {
			echo "[send/userscount]: email was sent successfully\n";
		} else {
			echo "[send/userscount]: error: email wasn't sent\n";
		}
	}
}