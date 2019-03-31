<?php

class BattleShipPlayer
{
    private $table = [];
    private $enemyTable = [];
    private $ships = [];
    private $name = '';

    public function __construct( string $name)
    {
        $this->name = $name;
        $this->createTable(10);
        //echo " CREATING TABLE </br>";
        //$this->printTable();
        $this->createShips(4);
        //echo " CREATING SHIPS </br>";

        //$this->printShips();
        $this->setShips();
        echo "</br> SETING SHIPS </br>";
        $this->printTable();
        //echo " SHIPS COLOCADOS</br>";

        //$this->printShips();


    }
    public function createTable(int $n) 
    {
        for ($i=0; $i < $n; $i++) 
        {             
            for ($y=0; $y < $n; $y++) 
            { 
                $this->table[$i][$y] = 'A';              
            }
        }
    }

    public function setShips()
    {
        for ($vuelta=0; $vuelta < count($this->ships); $vuelta++) {        
            $P = rand(0,9);
            $T = rand(0,9);
            
            if( $this->available($P,$T) )
            {   
                $direction = $this->direction($P,$T, count($this->ships[$vuelta]) );
                
                switch ($direction) {
                    case '':
                        echo 'no-exist-space '. "</br>";
                        $vuelta--; //está disponible pero no entra el barco para ninguna dirección
                        break;

                    case 'H+':
                        for ($i=0; $i < count($this->ships[$vuelta]) ; $i++) { // HORIZONTALMENTE derecha
                            $this->table[$P][$T+$i] = $this->ships[$vuelta][$i];
                        }
                        break;

                    case 'H-':
                        for ($i=0; $i < count($this->ships[$vuelta]) ; $i++) { // HORIZONTALMENTE izquierda
                            $this->table[$P][$T-$i] = $this->ships[$vuelta][$i];
                        }
                        break;

                    case 'V+':
                        for ($i=0; $i < count($this->ships[$vuelta]) ; $i++) { // VERTICALMENTE ARRIBA
                            $this->table[$P+$i][$T] = $this->ships[$vuelta][$i];
                        }
                        break;

                    case 'V-':
                        for ($i=0; $i < count($this->ships[$vuelta]) ; $i++) { // VERTICALMENTE ABAJO
                            $this->table[$P-$i][$T] = $this->ships[$vuelta][$i];
                        }
                        break;

                    default:
                        echo ":( revisar switch";
                        break;
                }
                
            }else{
                echo "coordenada no disponible en ($P,$T) valor: {$this->table[$P][$T]} </br>";
                $vuelta--; // no disponible la coordenada
            }                      
        }
    }
    public function printTable()
    {   /*
        for ($i=0; $i < count($this->table); $i++) { 
            if( count($this->table[$i]) >10 )
            {
                var_dump($this->table[$i]);
            }
        }
        */
        
        
        echo "<pre>";
        foreach ($this->table as $line) {
            foreach ($line as $key => $item) {
                if($key == count($line)-1)
                {    
                    if ($item ==='A') {
                        echo  " </br>";
                    }else {
                        echo $item. "</br>";
                    }               
                }else {
                    if ($item ==='A') {
                        echo  " -";
                    }else {
                        echo $item. '-';
                    }
                }
            }
        } 
        echo "</pre></br>";
    }
    public function printShips()
    {   echo "[ ";
        for ($i=0; $i < count($this->ships)-1; $i++) { 
            echo count($this->ships[$i]).",";
        }
        echo count( $this->ships[count($this->ships)-1]) ." ]</br>";
        
        /*
        echo "<pre>";
        foreach ($this->table as $line) {
            foreach ($line as $key => $item) {
                if($key == count($line)-1)
                {    
                    if ($item ==='A') {
                        echo  " </br>";
                    }else {
                        echo $item. "</br>";
                    }               
                }else {
                    if ($item ==='A') {
                        echo  " -";
                    }else {
                        echo $item. '-';
                    }
                }
            }
        } 
        echo "</pre></br>";*/
    }
    public function available(int $coordX, int $coordy)
    {
        if( ($coordX<10 && $coordX>0) && ($coordy<10 && $coordy>0)){
            $value = $this->table[$coordX][$coordy];
            //echo $value . "($coordX , $coordy)</br>";
            return "A"== $value;
        }else {
            echo "fuera del tablero  ($coordX,$coordy) </br>";
            return false;
        }
    }
    public function direction(int $x, int $y, int $count):string
    {
        $case = rand(0,4);

        switch ($case) {
            case 0:
                $result = true;
                for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  HORIZONTALMENTE derecha
                    if(!$this->available( $x , $y+$i ))
                    {
                        $result = false;
                    }
                }
                if($result == true){
                    return 'H+';
                }
                break;
            
            case 1:
                $result = true;
                for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  HORIZONTALMENTE izquierda
                    if(!$this->available( $x , $y-$i ))
                    {
                        $result = false;
                    }
                }
                if($result == true){
                    return 'H-';
                }
            break;
            case 2:
                $result = true;
                for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  VERTICALMENTE arriba
                    if(!$this->available($x+$i, $y))
                    {
                        $result = false;
                    }
                }
                if($result == true){
                    return 'V+';
                }
            break;
            case 3:
                $result = true;
                for ($i=0; $i < $count && $result ; $i++) { // valida si entra el barco  VERTICALMENTE arriba
                    if(!$this->available($x+$i, $y))
                    {
                        $result = false;
                    }
                }
                if($result == true){
                    return 'V+';
                }else {
                    return '';
                }
            break;     
                
            default:
            echo "llega al defoult del switch del direction";
            return '';
                break;
            
        }
        return '';
    }
    public function createShips(int $k)
    {
        $types = $k;
        for ($i=1; $i <= $types; $i++) { //tipos de barcos 
            for ($n=0 ; $n < $types-($i-1) ; $n++) { //cantidad de cada tipo
                for ($t=0; $t < $i; $t++) { //largo dinamico de un tipo
                    $ship[] = $i;
                }
                $this->ships[]=$ship;
                $ship = [];
            }
        }
    }
}
