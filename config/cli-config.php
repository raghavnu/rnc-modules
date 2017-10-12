<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;

$settings = include 'Settings.php';

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['doctrine']['meta']['entity_path'],
    $settings['doctrine']['meta']['auto_generate_proxies'],
    $settings['doctrine']['meta']['proxy_dir'],
    $settings['doctrine']['meta']['cache'],
    false
);

$em = EntityManager::create($settings['doctrine']['connection'], $config);

return ConsoleRunner::createHelperSet($em);
