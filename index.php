<?php

    include_once("TicTacToe.class.php");

    session_start();



    do {
        if(!isset($mode)){
            echo "Please select game mode:\n";
            echo "1.Single player\n";
            echo "2.Multiplayer\n";
        }

        $mode = readline(">");

        if($mode < 0  || $mode > 2){
            echo "Player choosee 1 or 2\n";
        }

    } while ($mode < 0  || $mode > 2);



    if($mode==1){

        do {
            if(!isset($difficulty)){
                echo "Please select game difficulty:\n";
                echo "1.Easy\n";
                echo "2.Normal\n";
                echo "3.Hard\n";
            }
    
            $difficulty = readline(">");
    
            if($difficulty < 0  || $difficulty > 3){
                echo "Player choose between 1-3\n";
            }
    
        } while ($difficulty < 0  || $difficulty > 3);

        $players = array( readline("Player name:") , "cmp");

    }else{
        $players = array( readline("Player 1 name:") , readline("Player 2 name:"));
    }



    $ticTacToe = new TicTacToe($mode , $players , (isset($difficulty) ? $difficulty : false));


    $ticTacToe->initGame();



  /* 

    $board = array(
        array(" " ," " ," "),
        array(" " ," " ," "),
        array(" " , " " ,  " ")
    );
     
    
    $player1 = "X";
    $player2 = "O";
    $winner = false;
    $moveIndex = 1;
    
    while(!$winner){
        playerMove($board , ($moveIndex%2==0) ? $player1 : $player2  ,$winner , $moveIndex);
        $moveIndex++;
    }
    
    
    function checkWinner($board , $currentPlayer ,$moveIndex){
    
    
        for ($i=0; $i <count($board) ; $i++) { 
            for ($j=0; $j < count($board[$i]) ; $j++) { 
                if($board[$i][$j] == $currentPlayer){
            
                    if($i==0){
                        if($board[$i+1][$j] == $currentPlayer &&  $board[$i+2][$j] == $currentPlayer){
                            return true;
                        }
                    }
    
                    if($j==0){
                        if($board[$i][$j+1] == $currentPlayer &&  $board[$i][$j+2] == $currentPlayer){
                            return true;
                        }
                    }
    
    
                    if($i==0 && $j==0){
                        if($board[$i+1][$j+1] == $currentPlayer &&  $board[$i+2][$j+2] == $currentPlayer){
                            return true;
                        }
                    }
    
    
                    if($i==0 && $j==2){
                        if($board[$i+1][$j-1] == $currentPlayer &&  $board[$i+2][$j-2] == $currentPlayer){
                            return true;
                        }
                    }
    
    
                }
            }
        }
    
    
    
    
    
    
    }
    
    
    function playerMove(&$board , $player , &$winner , $moveIndex){
    
            echo "Player -$player- select move (x ,y):\n";
    
            $x = readline("x:");
            $y = readline("y:");
    
            while(($x<0 || $x>2) || ($y<0 || $y>2)){
                echo "You need to choose x and y between 0-2\n";
                $x = readline("x:");
                $y = readline("y:");
            }
    
    
    
            while($board[$x][$y]!=" "){
                echo "The selected location is occupied\n";
                $x = readline("x:");
                $y = readline("y:");
            }
            
            $board[$x][$y] = $player;
     
        
            
    
            print_board($board);
     
    
            $winner = checkWinner($board , $player , $moveIndex);
    
            if($winner){
                echo "-$player- is the Winner";
            }
    
    
    }
    
    
    function print_board($board){
        echo "\n";
    
        for ($i=0; $i < count($board); $i++) { 
    
            for ($j=0; $j < count($board[$i]) ; $j++) { 
    
                echo $board[$i][$j]." ";
    
    
                if($j==(count($board[$i])-1)){
                    echo "\n";
                }else{
                    echo "| ";
                }
    
            }
    
            if($i == 0  || $i == 1){
                echo "---------\n";
            }
    
        }
        echo "\n";
    }
     */
    
