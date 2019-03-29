<?php

class Tateti
{
    public $tablero = [];
    public $players = [];
    public $turnId;
    public $key;
    public $winner='';

    public function __construct($players)
    {
        $this->tablero[] = array(1,1,1);
        $this->tablero[] = array(1,1,1);
        $this->tablero[] = array(1,1,1);
        $this->players = $players;
        $this->turnId = 0;
        $this->key = $this->players[$this->turnId]->getKey();

    }

    public function play()
    {   
         
        $randX = rand(0,count($this->tablero)-1);
        $randY = rand(0,count($this->tablero)-1);
        if( $this->available($randX,$randY) )
        {
            $this->tablero[$randX][$randY] = $this->key;
        }else {
            $this->play();
        }
    }

    public function available(int $x, int $y)
    {
        return !is_string( $this->tablero[$x][$y] );
    }

    public function getKey()
    {
        foreach ($this->players as $player) {
            if ($player->id == $this->trunId) {
                return $player->getKey(); 
            }
        }        
    }

    public function nextPlayer()
    {
        //echo "jugador: ".$this->turnId. "</br>";
        $id = $this->turnId+1;        

        if( $this->turnId == count( $this->players)-1 )
        {   
            $id = 0;
        }

        //echo "jugador: ".$id. "</br>";
        $this->key = $this->players[ $id ]->getKey();
        $this->turnId = $this->players[ $id ]->getId();
        //echo $this->players[ $id ]->getId();
    }

    public function winner()
    {
        //tomo todas las keys
        //Check winner
        
        foreach ($this->players as $player) {
            $key = $player->getKey();
            if($this->checkVertical($key) || $this->checkHorizontal($key) || $this->checkDiagonal($key))
            {
                $this->winner = $player->getName();
                return true;
            }
        }
        return false;
    }
    public function print()
    {
        foreach ($this->tablero as $line) {
            foreach ($line as $key => $item) {
                if($key == count($line)-1)
                {
                    echo $item. "</br>";
                }else {
                    echo $item. '-';
                }
            }
        } 
        echo "</br>";
    }

    public function checkVertical($key)
    {
        $sum=0;
        for ($x=0; $x < 3; $x++) {
            for ($y=0; $y < 3; $y++) {
                if($this->tablero[$y][$x]==$key)
                {
                    $sum++;
                }
            }
            if($sum == 3 )
            {
                return true;
            }else {
                $sum=0;
            }               
        }
        return false;
    }
    public function checkHorizontal($key)
    {
        $sum=0;
        for ($x=0; $x < 3; $x++) 
        {
            for ($y=0; $y < 3; $y++) 
            { 
                if( $this->tablero[$x][$y]==$key )
                {
                    $sum++;
                }
            }

            if($sum == 3 )
            {
                return true;
            }else {
                $sum=0;
            }               
        }
        return false; 
    }
    public function checkDiagonal($key)
    {
        $sum=0;
        $result=false;
        //primera diagonal
        for ($x=0; $x < 3; $x++)  
        {
            for ($y=$x; $y <= $x; $y++) 
            {                 
                if ($this->tablero[$x][$y]==$key) 
                {
                    $sum++;
                }                 
            }                         
        }
        if($sum == 3 )
        {
            $result = true;
        }else {
            $sum = 0;
        }

        //segunda diagonal
        if($sum ==0){
            for ($x=2; $x >=0; $x--) 
            {
                for ($y=-$x+2; $y <= -$x+2; $y++) 
                { 
                    if ($this->tablero[$x][$y]==$key) 
                    {
                        $sum++;
                    }
                }                         
            }
            if($sum == 3 )
            {
                $result = true;
            }

        }
                
        
        return $result; 
    }
    public function run(){
        $jugadas=0;

        while( !$this->winner() && $jugadas<9) {            
            echo "jugando: ". $this->key. "</br>";            
            $this->play();
            $this->print();
            $this->nextPlayer();
            $jugadas++;  
        }
        if($this->winner != '')
        {
            echo "ganó: ".$this->winner;
        }else{
            echo "empate";
        }
    }
}