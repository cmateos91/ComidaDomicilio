<?php
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../../vendor/autoload.php';

$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . '/../Models'],
    $isDevMode
);

$conn = [
    'dbname' => 'comida_domicilio',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

// ⚠️ Esta es la forma correcta en Doctrine 3
$connection = DriverManager::getConnection($conn, $config);
$entityManager = new EntityManager($connection, $config);
