<?php

require 'conn.php';
use DByte\DB;

define('ROOT_PATH', realpath(__DIR__));
define('TPL_PATH', realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'tpl'));

function sendMail($to, $subject, $message) {
  $headers = 'From: no-replay@dev.loc' . "\r\n" .
    'X-Mailer: PHP/7';
  return mail($to, $subject, $message, $headers);
}

function render($template, $variables) {
  extract($variables);
  ob_start();
  include $template;
  return ob_get_clean();
}

$tasks = DB::fetch('SELECT * FROM umail WHERE status = 0');

foreach ( $tasks as $task ) {

  $user = DB::row('SELECT * FROM users WHERE __id = :id', [':id' => $task['to']]);

  if (!empty($user)) {

    $params = unserialize($task['params']);
    
    $template = TPL_PATH . DIRECTORY_SEPARATOR  . $task['template'] . '.tpl.php';
    
    $msg = render($template, get_object_vars($params));
   
    $result = sendMail($user['email'], $params->subject, $msg);

    if ($result) {
      DB::update('umail', ['status' => 1], $task['__id'], '__id');
      echo "[umail_cli]: email was sent successfully\n";
    } else {
      echo "[umail_cli]: error: email wasn't sent\n";
    }

  } else {
    DB::update('umail', ['status' => -1], $task['__id'], '__id');
    echo "[umail_cli]: error: user does not exists\n";
  }
}
