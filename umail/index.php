<?php

require 'conn.php';
use DByte\DB;

header('Content-Type: application/json');

class Umail {
	const STATUS_ERROR = -1;
	const STATUS_WAIT = 0;
	const STATUS_SENDED = 1;
}

function add()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo json_encode(['code' => 405, 'status' => 'method not allowed', 'message' => 'try post method']);
        die;
    }
    $data = json_decode(file_get_contents('php://input'));
    
    $data = [
      'to' => $data->id,
      'template' => $data->template,
      'params' => serialize($data->params),
      'status' => Umail::STATUS_WAIT,
      'created' => $data->created,
    ];
    
    $qid = DB::insert('umail', $data);
    
    echo json_encode(['code' => 200, 'status' => 'ok', 'message' => 'mail added to base', 'qid' => $qid]);
}

function status()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo json_encode(['code' => 405, 'status' => 'method not allowed', 'message' => 'try post method']);
        die;
    }
    
    $statuses = [
        Umail::STATUS_ERROR => 'ERROR',
        Umail::STATUS_WAIT => 'WAIT',
        Umail::STATUS_SENDED => 'SENDED',
    ];

    $data = json_decode(file_get_contents('php://input'));
    
    $task = DB::row('SELECT * FROM `umail` WHERE `__id` = :id', [':id' => $data->qid]);
    
    if (isset($task['status'])) {
        $status = $statuses[$task['status']];
    } else {
        $status = $statuses[Umail::STATUS_ERROR];
    }
    echo json_encode(['code' => 200, 'status' => 'ok', 'qid' => $data->qid, 'task' => $status]);
}

/* routing */

$url = $_SERVER['REQUEST_URI'];

switch($url) {
  case '/add':
    add();
    break;
  case '/status':
    status();
    break;
  default:
    echo json_encode(['code' => 404, 'status' => 'not found', 'message' => 'try another uri']);
}
