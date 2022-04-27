<?php

class OracleFactory implements ORMFactoryInterface
{

    public function getDb(): DBInterface
    {
        return new Oracle();
    }
}