<?php


namespace App\Models;

use T4\Mail\Sender;

class SenderValid
	extends Sender
{
	protected function validateEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public function isValid($email) {
		return (bool)$this->validateEmail($email);
	}
}