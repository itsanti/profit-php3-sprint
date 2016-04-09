<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\User;

class Index
    extends Controller
{

    public function actionDefault($id = 0)
    {
        $this->data->user = User::getUserFullName(User::findByPK($id));
        $this->data->domain = $this->app->config->site->domain;
    }

}