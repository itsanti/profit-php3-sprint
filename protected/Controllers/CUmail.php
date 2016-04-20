<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\Umail;

class CUmail
    extends Controller
{
    private function sendQuery($query, $url) {
        $data = json_encode($query);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                           . "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data,
            ]
        ]);

        $response = file_get_contents(
            $url, false, $context
        );

        return $response;
    }

    public function actionDefault()
    {
        $query = [
            "id" => $this->app->request->get['id'],
            "template" => "standard",
            "params" => [
                "subject" => "hello, world",
                "message" => "first service"
            ],
            "created" => time()
        ];

        $response = $this->sendQuery($query, 'http://localhost/umail/add');
        
        $this->data->response = $response;

    }

    public function actionAdd()
    {
        if ($this->app->request->method == 'get') {
            echo json_encode(['code' => 405, 'status' => 'method not allowed', 'message' => 'try post method']);
        } else {
            $data = json_decode(file_get_contents('php://input'));
            $umail = new Umail();
            $umail->to = $data->id;
            $umail->template = $data->template;
            $umail->params = serialize($data->params);
            $umail->status = Umail::STATUS_WAIT;
            $umail->created = $data->created;
            $umail->save();
            echo json_encode(['code' => 200, 'status' => 'ok', 'message' => 'mail added to base', 'qid' => $umail->getPk()]);
        }
        die;
    }

    public function actionStatus()
    {
        $statuses = [
            Umail::STATUS_ERROR => 'ERROR',
            Umail::STATUS_WAIT => 'WAIT',
            Umail::STATUS_SENDED => 'SENDED',
        ];

        if ($this->app->request->method == 'post') {
            $data = json_decode(file_get_contents('php://input'));
            $task = Umail::findByPK($data->qid);
            if (isset($task->status)) {
                $status = $statuses[$task->status];
            } else {
                $status = $statuses[Umail::STATUS_ERROR];
            }
            echo json_encode(['code' => 200, 'status' => 'ok', 'qid' => $data->qid, 'task' => $status]);
            die;
        }

        $query = [
            "qid" => $this->app->request->get['qid'],
        ];

        $response = $this->sendQuery($query, 'http://localhost/umail/status');
        $data = json_decode($response);
        $this->data->qid = $data->qid;
        $this->data->status = $data->task;
    }
}