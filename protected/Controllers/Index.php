<?php

namespace App\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
      $this->data->domain = $this->app->config->site['domain'];
    }

}