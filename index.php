<?php

require_once 'Player.php';
require_once 'Tateti.php';

// create Players
$players = [];
$players[] = new Player(0, 'X', 'Ivan');
$players[] = new Player(1, 'O', 'Pablo');
//$players[] = new Player(2, 'Y', 'Alex');


//instancio juego
$tateti = new Tateti($players);
//echo json_encode($tateti);
$tateti->run();
