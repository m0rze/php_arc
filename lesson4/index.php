<?php

include "autoload.php";

$mysql = dbWork(new MySQLFactory());
$mysql->DBConnection();
$mysql->DBQueryBuilder();
$mysql->DBRecord();

$postgre = dbWork(new PostgreSQLFactory());
$postgre->DBConnection();
$postgre->DBQueryBuilder();
$postgre->DBRecord();

$oracle = dbWork(new OracleFactory());
$oracle->DBConnection();
$oracle->DBQueryBuilder();
$oracle->DBRecord();

function dbWork(ORMFactoryInterface $ORMFactory): DBInterface
{
    return $ORMFactory->getDb();
}