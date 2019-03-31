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

    

$player = new BattleShipPlayer('Ivan');
//$player->printTable();
//var_dump($player);



