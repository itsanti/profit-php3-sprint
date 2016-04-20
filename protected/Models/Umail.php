<?php


namespace App\Models;

use T4\Orm\Model;

class Umail
	extends Model
{
	const STATUS_ERROR = -1;
	const STATUS_WAIT = 0;
	const STATUS_SENDED = 1;

	protected static $schema = [
		'table' => 'umail',
		'columns' => [
			'to' => ['type' => 'string'],
			'template' => ['type' => 'string'],
			'params' => ['type' => 'string'],
			'status' => ['type' => 'int', 'length' => 'tiny'],
			'created' => ['type' => 'int', 'default' => 0],
		],
	];
}
