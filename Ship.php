<?php

class Ship
{
    public function createShip(int $lengt)
    {
        $ship = [];
        for ($i=0; $i < $lengt; $i++) { 
            $ship[] = $lengt;
        }
        return $ship;
    }
    
}