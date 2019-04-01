<?php

require_once 'Player.php';
require_once 'Ship.php';
require_once 'Tateti.php';
require_once 'BattleShip.php';
require_once 'BattleShipPlayer.php';


/*  TATETI
    $players = [];
    $players[] = new Player(0, 'X', 'Ivan');
    $players[] = new Player(1, 'O', 'Pablo');
    $tateti = new Tateti($players);
    $tateti->run();
*/
/*  BATTLESHIP 
    $ships=[
        array(1), array(1), array(1), array(1),
        array(2,2),array(2,2),array(2,2),
        array(3,3,3),array(3,3,3),
        array(4,4,4,4)
    ];
*/

    

$player1 = new BattleShipPlayer('Ivan');
$player2 = new BattleShipPlayer('Leo');
$battleShip = new BattleShip($player1,$player2);
$battleShip->play();

//$player->printTable();
//var_dump($player);


/**
 * =====================================
 * 1 - Cuanto vale $a en los tres casos:
 * =====================================
 */
//a
/*
$a = 10;
function ej1_a() {
  $a = 11;
}
ej1_a();
echo "cuanto vale a?</br>";
echo "a vale 10 ($a)</br>";
//b
$b = 10;
function ej1_b() {
  global $b;
  $b = 11;
}
ej1_b();
echo "cuanto vale a?</br>";
echo "b vale 11 ($b)</br>";
//c
$c = 10;
function ej1_c() {
  $c = 11;
  global $c;
}
ej1_c();
echo "cuanto vale c?</br>";
echo "c vale 10 ($c)</br>";
//d
$d = 10;
function ej1_d() {
  global $d;
  $d = 11;
}
echo "cuanto vale d?</br>";
echo "d vale 10 ($d)</br>";


$mano = array(4, 5, 10);

function calcularTanto($mano)
{
    $envido=20;
    for ($i=0;$i<count($mano); $i++)
    {        
        if($mano[$i]<8)
        {
            $envido+=$mano[$i];
        }
    }
    
    return $envido;
}
var_dump($mano);
echo "el envido es: ".calcularTanto($mano);
// 1 -10

*/