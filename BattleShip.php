<?php

class BattleShip
{
    private $playerA;
    private $playerB;
    private $currentPlayer;
    private $shots = [];


    public function __construct(BattleShipPlayer $p1, BattleShipPlayer $p2)
    {
        $this->playerA = $p1;
        $this->playerB = $p2;
        $this->currentPlayer='A';
        $this->shots = [
            'A' => [
                'shots' => 0,
                'fails' => 0,
                'success' => 0,
            ],
            'B' => [
                'shots' => 0,
                'fails' => 0,
                'success' => 0,
            ]
        ];
    
    }
    public function play()
    {      
        $j1=0;
        $j2=0;  
        while ($this->playerB->lose() > 0 && $this->playerA->lose() >0 ) 
        {
            if($this->currentPlayer === 'A'){

                //SHOT PLAYER 1
                    $shot = $this->playerA->sendShot();
                    $response = $this->playerB->receiveShot( $shot ) ;

                // STATICS

                    $this->shots['A']['shots']++; //suma tiros
                    if($response === 'AGUA')
                    {
                        $this->shots['A']['fails']++;// suma fails
                    }elseif($response === 'BARCO') {
                        $this->playerA->setIA($shot);
                        $this->shots['A']['success']++;// suma aciertos
                    }else {
                        echo "error en shots";
                    }

                //CHANGE PLAYER

                    $this->currentPlayer ='B';

            }else {

                //SHOT PLAYER 2
                    $shot = $this->playerB->sendShot();
                    $response = $this->playerA->receiveShot( $shot ) ;
                    
                    
                    
                    //echo $response. "en: $shot" ;
                    //$this->playerB->printTable();



                // STATICS

                    $this->shots['B']['shots']++; //suma tiros
                    if($response === 'AGUA') {
                        $this->shots['B']['fails']++;// suma fails
                    }elseif($response === 'BARCO') {
                        $this->playerB->setIA($shot);
                        $this->shots['B']['success']++;// suma aciertos
                    }else {
                        echo "error en shots";
                    }

                //CHANGE PLAYER

                    $this->currentPlayer ='A';
            }           
            
        }
        if($this->playerB->lose()==0)
        {
            echo "ganador Player1: {$this->playerA->getName()}";            
        }else{
            echo "ganador player2: {$this->playerB->getName()}";            
        }
        $this->playerA->printTable();
        echo    "ship patrs = {$this->playerA->lose()}, 
                shots = {$this->shots['A']['shots']},
                fails = {$this->shots['A']['fails']},
                success = {$this->shots['A']['success']}";
        $this->playerB->printTable();
        echo    "ship patrs = {$this->playerB->lose()}, 
                shots = {$this->shots['B']['shots']},
                fails = {$this->shots['B']['fails']},
                success = {$this->shots['B']['success']}";

    }

    //winner() chequea que niguno de los tableros esten sin barcos
    //shot( x,y ) el usuario de turno dispara al tablero del otro y recive un mensaje de Agua o Le diste a mi barco

}