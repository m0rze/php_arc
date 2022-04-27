<?php

class MySQLFactory implements ORMFactoryInterface
{
    public function getDb(): DBInterface
    {
        return new MySQL();
    }
}