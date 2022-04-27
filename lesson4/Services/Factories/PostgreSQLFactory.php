<?php

class PostgreSQLFactory implements ORMFactoryInterface
{

    public function getDb(): DBInterface
    {
        return new PostgreSQL();
    }
}