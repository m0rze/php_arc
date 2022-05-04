<?php

interface ISquare
{
    function squareArea(int $sideSquare);
}

interface ICircle
{
    function circleArea(int $circumference);
}

class SquareAreaLib
{
    public function getSquareArea(int $diagonal)
    {
        $area = ($diagonal ** 2) / 2;
        return $area;
    }
}

class CircleAreaLib
{
    public function getCircleArea(int $diagonal)
    {
        $area = (M_PI * $diagonal ** 2) / 4;
        return $area;
    }
}


class SquareAdapter implements ISquare
{

    private SquareAreaLib $areaLib;

    public function __construct(SquareAreaLib $areaLib)
    {
        $this->areaLib = $areaLib;
    }

    function squareArea(int $sideSquare)
    {
        return $this->areaLib->getSquareArea(sqrt(2) * $sideSquare);
    }
}

class CircleAdapter implements ICircle
{

    private CircleAreaLib $areaLib;

    public function __construct(CircleAreaLib $areaLib)
    {
        $this->areaLib = $areaLib;
    }


    function circleArea(int $circumference)
    {
        return $this->areaLib->getCircleArea($circumference / M_PI);
    }
}

$square = new SquareAdapter(new SquareAreaLib());
var_dump($square->squareArea(4));

$circle = new CircleAdapter(new CircleAreaLib());
var_dump($circle->circleArea(12));
