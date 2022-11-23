<?php

if (getenv('TUGBOAT_REPO') !== FALSE) {
  $databases['default']['default'] = [
    'database' => 'tugboat',
    'username' => 'tugboat',
    'password' => 'tugboat',
    'prefix' => '',
    'host' => 'mariadb',
    'port' => '3306',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
  ];

  $redis_config = 'modules/contrib/redis/example.services.yml';
  if (file_exists($redis_config) && is_readable($redis_config)) {
    $settings['container_yamls'][] = $redis_config;
    $settings['redis.connection']['interface'] = 'PhpRedis';
    $settings['redis.connection']['host'] = 'redis';
    $settings['cache']['default'] = 'cache.backend.redis';
  }
  else {
    error_log("This project is configured to use Redis for caching. Please download and install the Drupal Redis module. See https://architecture.lullabot.com/adr/20220906-identical-cache-backends/.");
  }
}
