<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

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
        }
            ,
        ]);

        /* $containerBuilder->addDefinitions([
     'bd' => function (ContainerInterface $c) {
     $settings = $c->get(SettingsInterface::class);
     $bdSettings = $settings->get('bd');
     // $driver = $bdSettings['driver'];
     $host = $bdSettings['host'];
     $dbname =  $bdSettings['database'];
     $username = $bdSettings['username'];
     $password = $bdSettings['password'];
     //$dsn = "$driver:host=$host;dbname=$dbname;";
     $con = mysqli_connect($host, $username, $password, $dbname);
     
     return $con;
     }
     ]); */

        $containerBuilder->addDefinitions([
            'bd' => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $dbSettings = $settings->get('bd');

            $drive = $dbSettings['driver'];
            $host = $dbSettings['host'];
            $port = $dbSettings['port'];
            $dbname = $dbSettings['database'];
            $username = $dbSettings['username'];
            $password = $dbSettings['password'];

            $pdo = new PDO("$drive:host=$host;port=$port;dbname=$dbname", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
            ,
        ]);
    };
