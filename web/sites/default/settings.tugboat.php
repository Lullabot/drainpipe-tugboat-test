<?php

if (getenv('TUGBOAT_REPO') !== FALSE) {
  $databases['default']['default'] = [
    'database' => 'tugboat',
    'username' => 'tugboat',
    'password' => 'tugboat',
    'prefix' => '',
    'host' => 'mysql',
    'port' => '3306',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
  ];

  if (file_exists('modules/contrib/memcache/memcache.info.yml')) {
    $settings['memcache']['servers'] = ['memcached:11211' => 'default'];
    $settings['cache']['default'] = 'cache.backend.memcache';
  }
  else {
    error_log("This project is configured to use Memcached for caching. Please download and install the Drupal Memcache module. See https://architecture.lullabot.com/adr/20220906-identical-cache-backends/.");
  }
}
