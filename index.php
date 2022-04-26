<?php



    include_once("TicTacToe.class.php");

    if(isset($_GET['session_id'])){
        session_id($_GET['session_id']);
        session_start();
        ///session_destroy();
        $ticTacToe = $_SESSION['ticTacToe'];
      
        
    }



    if(isset($_GET['init_game'])){
       
        session_start();

        if(!isset($_GET['mode'])){
            echo "error";
            die;
        }

        if((!isset($_GET['players']))){
            echo "error";
            die;
        }


        $ticTacToe = new TicTacToe($_GET['mode'] , explode(","  , $_GET['players']) , (isset($_GET['difficulty']) ? $_GET['difficulty'] : false));
        $ticTacToe->initGame();

        $_SESSION['ticTacToe']  = $ticTacToe;

    }else{

        if(isset($_GET['x']) && isset($_GET['y'])){
            $ticTacToe->nextMove($_GET['x'] ,$_GET['y']);
        }

    }





    



/* 
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
 */


