<?php

class Tateti
{
    private $tablero = [];

    public function __construct()
    {
        $this->tablero[] = array(0,0,0);
        $this->tablero[] = array(0,0,0);
        $this->tablero[] = array(0,0,0);


    }

    public function play()
    {
        $x = rand(0,count($this->tablero));
    }
}