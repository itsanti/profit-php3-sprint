<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\User;

class Index
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
    
    public function actionDefault($id = 0)
    {
        $this->data->user = User::getUserFullName(User::findByPK($id));
        $this->data->domain = $this->app->config->site->domain;
    }
    
    public function actionUmail($id = 0)
    {
        if($id == 0) {
          $this->data->response = 'need user id for operation!';
          $this->data->qid = -1;
          return;
        }
        
        $query = [
            "id" => $this->app->request->get['id'],
            "template" => "standard",
            "params" => [
                "subject" => "hello, world",
                "message" => "first service"
            ],
            "created" => time()
        ];

        $response = $this->sendQuery($query, 'http://umail.loc/add');
        $data = json_decode($response);
        $this->data->response = $response;
        $this->data->qid = $data->qid;
    }
    
    public function actionStatus($qid = 0)
    {
        if($qid == -1) {
          $this->data->qid = -1;
          $this->data->status = 'task does not exists';
          return;
        }
        
        $query = [
            "qid" => $this->app->request->get['qid'],
        ];

        $response = $this->sendQuery($query, 'http://umail.loc/status');
        $data = json_decode($response);
        $this->data->qid = $data->qid;
        $this->data->status = $data->task;
    }

}