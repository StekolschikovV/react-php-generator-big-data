<?php

class Math
{

    public $min = null;
    public $max = null;

    public $rand = null;

    public $res = [
        "rand" => null,
        "randTow" => null,
        "randOne" => null,
        "average" => null,
        "deviation" => null,
        "abs" => null,
        "median" => null,
    ];

    public function __construct()
    {
    }

    public function generator($min, $max)
    {
        $this->min = $min;
        $this->max = $max;

        $this->res["rand"] = $this->genRand();
        $this->res["randOne"] = $this->genRand();
        $this->res["randTow"] = $this->genRand();
        $this->res["average"] = $this->getAverage();
        $this->res["deviation"] = $this->getStandardDeviation([$this->res["randOne"],$this->res["randTow"]]);
        $this->res["abs"] = $this->getStandardDeviation([$this->res["randOne"],$this->res["randTow"]]);
        $this->res["median"] = $this->getMedian();

        return implode ("/",$this->res);
    }

    public function genRand()
    {
        return rand($this->min, $this->max);
    }

    public function getAverage()
    {
        return ($this->min + $this->max) / 2;
    }

    function getStandardDeviation($aValues, $bSample = false)
    {
        $fMean = array_sum($aValues) / count($aValues);
        $fVariance = 0.0;
        foreach ($aValues as $i)
        {
            $fVariance += pow($i - $fMean, 2);
        }
        $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
        return (float) sqrt($fVariance);
    }

    public function getAbs()
    {
        return abs($this->res["rand"]);
    }

    public function getMedian()
    {
        $arr = [$this->res["randOne"], $this->res["randTow"]];
        sort ($arr);
        $count = count($arr);
        $middle = floor($count/2);
        if ($count%2) return $arr[$middle];
        else return ($arr[$middle-1]+$arr[$middle])/2;
    }

}
