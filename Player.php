<?php

class Player 
{
    public $id;
    public $key = 'X';
    public $name = '';

    public function __construct(int $id, string $key, string $name)
    {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
    }

    public function getKey()
    {
        return $this->key;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    
    
}
