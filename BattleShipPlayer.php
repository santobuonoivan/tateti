<?php

class BattleShipPlayer
{
    public $table = [];
    public $ships = [];
    public $name = '';

    public function __construct( string $name, array $ships)
    {
        $this->name = $name;
        $this->table = $this->createTable(10);
        $this->ships=$ships;
        $this->setShips();
    }
    public function createTable(int $n)
    {
        $vec=[];
        for ($i=0; $i < $n; $i++) 
        {             
            for ($y=0; $y < $n; $y++) 
            { 
                $vec[$i][$y] = 'O';              
            }
        }
        //var_dump($vec);
        return $vec;
    }
    public function setShips()
    {
        for ($vuelta=0; $vuelta < count($ships); $vuelta++) {        
            $x = rand(0,9);
            $y = rand(0,9);
            
            if( $this->available($x,$y) )
            {   
                $direction = $this->direction($x,$y, count($ships[$vuelta]) );
                switch ($direction) {
                    case '':
                        //pedir x.y nuevos
                        break;
                    case 'H':
                        for ($i=0; $i < count($ships[$vuelta]) ; $i++) { // HORIZONTALMENTE
                            $this->table[$x][$y+$i] = $ships[$vuelta][$i];
                        }
                    case 'V':
                        for ($i=0; $i < count($ships[$vuelta]) ; $i++) { // HORIZONTALMENTE
                            $this->table[$x][$y+$i] = $ships[$vuelta][$i];
                        }
                        break;
                    default:
                        # code...
                        break;
                }
                
            }else{

            }
            $x = $x;
            $y = $y+1;
            
        }
    }
    public function printTable()
    {
        foreach ($this->table as $line) {
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
    public function available(int $x, int $y)
    {
        return !is_string( isset( $this->table[$x][$y]) ? $this->table[$x][$y] : 'fuera del tablero' );
    }
    public function direction(int $x, int $y, int $count)
    {
        $result = true;
        for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  HORIZONTALMENTE
            $result = $this->available( $x , $y+$i );
        }



        if($resul == false){
            $result = true;
        }else{
            return 'H';
        }


        for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  VERTICALMENTE
            $result = $this->available( $x+$i , $y );
        }


        if($resul == false){
            return '';
        }else{
            return 'V';
        }

    }
}
