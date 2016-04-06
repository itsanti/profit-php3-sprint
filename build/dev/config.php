<?php

return [
  'site' => [
    'domain' => '{{domain}}'
  ],
  
  'db' => [
    'default' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'user' => 'root',
      'password' => '{{db.password}}',
      'dbname' => 'fw'
    ]
  ]
];