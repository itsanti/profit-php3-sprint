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

	public function actionUmailSend(){

		\T4\Mvc\Application
			::getInstance()
			->setConfig(
				new \T4\Core\Config(ROOT_PATH_PROTECTED . '/config.php')
			);

		$conn = $this->app->db->default;

		$tasks = $conn->query('SELECT * FROM umail WHERE status = 0')->fetchAll(\PDO::FETCH_ASSOC);

		foreach ( $tasks as $task ) {
			$user = $conn->query('SELECT * FROM users WHERE __id = :id', [':id' => $task['to']])->fetch(\PDO::FETCH_ASSOC);

			if (!empty($user)) {

				$params = unserialize($task['params']);

				$sender = new SenderValid();

				$result = $sender->sendMail($user['email'], $params->subject, $params->message);

				if ($result) {
					$conn->execute('UPDATE umail set status = 1 WHERE __id = :id', [':id' => $task['__id']]);
					$this->writeLn("[send/umailsend]: email was sent successfully");
				} else {
					$this->writeLn("[send/umailsend]: error: email wasn't sent");
				}

			} else {
				$conn->execute('UPDATE umail set status = -1 WHERE __id = :id', [':id' => $task['__id']]);
				$this->writeLn("[send/umailsend]: error: user does not exists");
			}
		}
	}
}