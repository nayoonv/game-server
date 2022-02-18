<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        PDO::class => function (ContainerInterface $c) {

            $settings = $c->get(SettingsInterface::class);

            $dbSettings = $settings->get('db');
            $host = $dbSettings['host'];
            $dbname = $dbSettings['database'];
            $username = $dbSettings['username'];
            $password = $dbSettings['password'];
            $charset = $dbSettings['charset'];
            $flags = $dbSettings['flags'];
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            return new PDO($dsn, $username, $password, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        },

        Twig::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $twigSettings = $settings->get('twig');
            $loader = new FilesystemLoader($twigSettings['path_templates']);
            $options = ['cache' => $twigSettings['path_cache']];

            return new Twig($loader, $options);
        },
    ]);
};
