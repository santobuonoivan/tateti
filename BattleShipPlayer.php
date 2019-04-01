<?php

class BattleShipPlayer
{
    const FILAS = 10;
    const COLUMNAS = 10;
    private $table = [];
    private $enemyTable = [];
    private $ships = [];
    private $name = '';
    private $lose;
    private $iA;
    private $lastIA;
    

    public function __construct( string $name)
    {
        $this->name = $name;
        $this->createTables(10);
        //echo " CREATING TABLE </br>";
        $this->lose = $this->createShips(4);
        //echo " CREATING SHIPS </br>";

        //$this->printShips();                 // IMPRIME BARCOS DEL PLAYER
        $this->setShips();
        //$this->printTable();               // IMPRIME LA TABLA DE PLAYER
        //var_dump($this->enemyTable);       // IMPRIME TABLA DE SHOTS AL ENEMIGO
        //echo " SHIPS COLOCADOS</br>";
        $this->shots = 0;
        $this->fails = 0;
        $this->success = 0;

        //IA
        $this->iA=0;
        $this->lastIA=0;
    }
    public function setIA($coord)
    {
        $values = json_decode($coord);
        $this->iA=$values;
        if ($this->lastIA==0)
        {
            $this->lastIA=$values;
        }
 
    }
    public function receiveShot(string $coords)
    {
        //echo "{$this->getName()} receiveShot in : ". $coords."</br>";


        $values = json_decode($coords);
        $x = $values[0];
        $y = $values[1];
        $response = '';
        if($this->table[$x][$y]==='A')
        {
            //echo "Agua en ($x,$y)</br>";
            $response = 'AGUA';
        }elseif( $this->table[$x][$y]!='X' ) {
            //echo "Barco en ($x,$y)</br>";
            $response='BARCO';
            $this->lose--;
        }else
        {
            $response = "revisar xq llega a una coordenada X en ($x,$y)</br>";
            return $response;
        }
        $this->table[$x][$y]='X';
        return $response;

    }

    public function sendShot()
    {
        $posible = false;
        while (!$posible) {
            if($this->iA == 0 && $this->lastIA == 0)
            {
                $a = rand(0,9);
                $b = rand(0,9);
                $posible = $this->available($a,$b,'E');
            }elseif($this->iA != 0 )
                {

                    // (+1, )
                    $a = $this->iA[0]+1;
                    $b = $this->iA[1];
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // (-1, )

                    $a = $this->iA[0]-1;
                    $b = $this->iA[1];
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // ( ,+1)

                    $a = $this->iA[0];
                    $b = $this->iA[1]+1;
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // ( ,-1)

                    $a = $this->iA[0];
                    $b = $this->iA[1]-1;
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // ya no sirve la coordenada de referencia
                    $this->iA=0;
                }else{
                    // (+1, )
                    $a = $this->lastIA[0]+1;
                    $b = $this->lastIA[1];
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // (-1, )

                    $a = $this->lastIA[0]-1;
                    $b = $this->lastIA[1];
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // ( ,+1)

                    $a = $this->lastIA[0];
                    $b = $this->lastIA[1]+1;
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }

                    // ( ,-1)

                    $a = $this->lastIA[0];
                    $b = $this->lastIA[1]-1;
                    $posible = $this->available($a,$b,'E');
                    if($posible)
                    {
                        break;
                    }
                    
                    // ya no me sirve el punto de referencia
                    $this->lastIA = 0;

            }
        }
        //echo "posible send a ($a,$b)";
            $this->enemyTable[$a][$b] = 'X';
            $coords[]=$a;
            $coords[]=$b;
            $this->shots++;
            //echo "sending: {$this->getName()}". json_encode($coords)."</br>";
        return json_encode($coords);
    }

    public function createTables(int $n) 
    {
        for ($i=0; $i < $n; $i++) 
        {             
            for ($y=0; $y < $n; $y++) 
            { 
                $this->table[$i][$y] = 'A';
                $this->enemyTable[$i][$y] = 'A';              
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
                        //echo 'no-exist-space '. "</br>";
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
                //echo "coordenada no disponible en ($P,$T) valor: {$this->table[$P][$T]} </br>";
                $vuelta--; // no disponible la coordenada
            }                      
        }
    }
    public function printTable()
    {   
        /*
        for ($i=0; $i < count($this->table); $i++) { 
            
            var_dump($this->table[$i]);
            
        }
        */
        $respuesta= "
            <table  align='center' border=1 cellspacing=1 cellpadding=1>
                <tr>
                    <td>                    
                        <table border='1'>
                            <caption>{$this->getName()}</caption>";
                                foreach ($this->table as $line) {
                                    $respuesta.= "<tr>";
                                    foreach ($line as $item) {                
                                        if ($item ==='A') {
                                            $respuesta.= "<td bgcolor='blue'>▒</td>";
                                        }elseif($item ==='X') {
                                            $respuesta.= "<td bgcolor='red'>$item</td>";
                                        }else{
                                            $respuesta.= "<td>$item</td>";
                                        }                
                                    }
                                    $respuesta.= "</tr>";
                                } 
                        $respuesta.=    "</table>                        
                    </td>
                    <td>                    
                        <table border='1'>
                            <caption>Enemy</caption>";
                                foreach ($this->enemyTable as $line) {
                                    $respuesta.= "<tr>";
                                    foreach ($line as $item) {                
                                        if ($item ==='A') {
                                            $respuesta.= "<td bgcolor='blue'>▒</td>";
                                        }elseif($item ==='X') {
                                            $respuesta.= "<td bgcolor='red'>$item</td>";
                                        }else{
                                            $respuesta.= "<td>$item</td>";
                                        }                
                                    }
                                    $respuesta.= "</tr>";
                                } 
                        $respuesta.=    "</table>
                </td>
            </tr>
        </table>";
    echo $respuesta;   
    /*   
    $respuesta.= "
        <table border='1'>
            <caption>{$this->getName()}</caption>";
        foreach ($this->table as $line) {
            $respuesta.= "<tr>";
            foreach ($line as $item) {                
                if ($item ==='A') {
                    $respuesta.= "<td bgcolor='blue'>▒</td>";
                }elseif($item ==='X') {
                    $respuesta.= "<td bgcolor='red'>$item</td>";
                }else{
                    $respuesta.= "<td>$item</td>";
                }                
            }
            $respuesta.= "</tr>";
        } 
        $respuesta.=    "</table>
            
            </br>";*/
    }
    public function printShips()
    {   
        
        echo "[ ";
        for ($i=0; $i < count($this->ships)-1; $i++) { 
            echo count($this->ships[$i]).",";
        }
        echo count( $this->ships[count($this->ships)-1]) ." ]</br>";   
        
        
    }
    public function available(int $coordX, int $coordy, $enemy = null)
    {
        if( ($coordX<10 && $coordX>=0) && ($coordy<10 && $coordy>=0))
        {
            if ($enemy != null)
            {
                $value = $this->enemyTable[$coordX][$coordy];
            }else{
                $value = $this->table[$coordX][$coordy];
            }            
            //echo $value . "($coordX , $coordy)</br>";
            return 'A'=== $value;
        }else {
            //echo "fuera del tablero  ($coordX,$coordy) </br>";
            return false;
        }
    }
    public function direction(int $x, int $y, int $count):string
    {
        $case = rand(0,3);

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
            echo "llega al defoult del switch del direction con case: $case";
            return '';
                break;
            
        }
        return '';
    }
    public function createShips(int $k)
    {
        $types = $k;
        $h=0;
        for ($i=1; $i <= $types; $i++) { //tipos de barcos 
            for ($n=0 ; $n < $types-($i-1) ; $n++) { //cantidad de cada tipo
                for ($t=0; $t < $i; $t++) { //largo dinamico de un tipo
                    $ship[] = $i;
                    $h++;
                }
                $this->ships[]=$ship;
                $ship = [];
            }
        }
        //echo " ship parts: $h";
        return $h;
    }
    public function lose()
    {
        //echo $this->lose."</br>";
        return $this->lose;    
    }
    public function getName()
    {
        return $this->name;
    }
}
