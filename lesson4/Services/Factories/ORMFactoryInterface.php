<?php

interface ORMFactoryInterface
{
    public function getDb(): DBInterface;
}