<?php
return array (
  'utf_mode' => 
  array (
    'value' => true,
    'readonly' => true,
  ),
	'cache' => array (
		'value' => array (
		  'type' => 'files',
		),
		'readonly' => false,
	  ),
  'cache_flags' => 
  array (
    'value' => 
    array (
      'config_options' => 3600,
      'site_domain' => 3600,
    ),
    'readonly' => false,
  ),
  'cookies' => 
  array (
    'value' => 
    array (
      'secure' => false,
      'http_only' => true,
    ),
    'readonly' => false,
  ),
  'exception_handling' => 
  array (
    'value' => 
    array (
      'debug' => true,
      'handled_errors_types' => 4437,
      'exception_errors_types' => 4437,
      'ignore_silence' => false,
      'assertion_throws_exception' => true,
      'assertion_error_type' => 256,
      'log' => array (
        'settings' => array (
          'file' => '/error.log',
          'log_size' => 10000000,
        ),
      ),
    ),
    'readonly' => false,
  ),
  'connections' => 
  array (
    'value' => 
    array (
      'default' => 
      array (
        'className' => '\\Bitrix\\Main\\DB\\MysqlConnection',
        'host' => 'localhost',
        'database' => 'szvdom',
        'login' => 'szvdom',
        'password' => 'Z8f5S9v8',
        'options' => 2,
      ),
    ),
    'readonly' => true,
  ),
);
