<?php 


class TicTacToe 
{

    private $difficulty , $gameMode , $winner = false , $players , $moveIndex=1 , $sessionID ,$mysqli;

    private $board = array(
        array("" ,"" ,""),
        array("" ,"" ,""),
        array("" , "" ,  "")
    );


    function __construct($gameMode , $players , $difficulty) {
      
        $this->gameMode = $gameMode;
        $this->players = $players;
        $this->difficulty =$difficulty;
    
        
        if($gameMode==1){
            $this->players[] = "cmp";
        }


        //$this->mysqli = mysqli_connect("localhost","root","","compie");

/* 
        if (mysqli_connect_errno()) {
            $this->mysqli = false;
        } */

    }

      public function initGame(){
  
        $this->sessionID = session_id();


        echo $this->sessionID;


/*         if ($this->mysqli) {
            $this->mysqli->query("INSERT INTO `tictactoe` (`session_id` ,`player1`,`player2`)
            VALUES ('$this->sessionID' , '".$this->players[0]."' , '".$this->players[1]."')");       
        } */

      }

      public function nextMove($x , $y){

        $letter = ($this->moveIndex%2==0) ? "X" : "O";
        $playerName = ($this->moveIndex%2==0) ? $this->players[0] : $this->players[1];
    
 
        if($this->gameMode==1 && $playerName=="cmp"){
            $this->cmpMove($letter);
        }else{

            if($this->board[$x][$y]!=""){
                die;
            }

            $this->board[$x][$y] = $letter;
        }

        $this->moveIndex++;
        $this->response($playerName , $letter);
    





    }



    private function response($playerName , $letter){

    

        $this->winner = $this->checkWinner($letter);
        $this->draw = $this->checkDraw();

        
        echo json_encode($this->board);die;

        if($this->winner){ 

            if ($this->mysqli) {
                $this->mysqli->query("UPDATE`tictactoe` SET `winner`='$playerName'");
            }
        }


        if($this->draw && !$this->winner){
           

            if ($this->mysqli) {
                $this->mysqli->query("UPDATE`tictactoe` SET `winner`='tie'");
            }
        }

    }



      private function cmpMove($letter){

                    $bestScore = -INF;
                    $bestMove = null;

                    $board = $this->board;
            
    
                    for ($i=0; $i <count($board) ; $i++) { 
                        for ($j=0; $j <count($board[$i]) ; $j++) { 
                            
                            if($board[$i][$j] == " "){
                                $board[$i][$j] = $letter;
                                $score = $this->minimax($board, 0 , 0 , 0, false);
                                $board[$i][$j]=" ";
                                
                                if($score > $bestScore){
                                    $bestScore = $score;
                                    $bestMove = array("x"=>$i , "y"=>$j);
                                }

                            }
            
            
                        }
                    }

        
                    $this->board[$bestMove['x']][$bestMove['y']] = "$letter"; 


      }


      private function minimax($board , $depth ,$alpha , $beta ,  $isMaximizing){


            if($this->difficulty == 1 && $depth>2){
                return $depth;
            }



            if($this->checkWinner("X" , $board) && $this->difficulty == 3){
                return -$depth;
            }

          
            if($this->checkWinner("O" , $board)){
                return $depth;
            }

            if($this->checkDraw($board)){
                return 0;
            }


           
            
            
            $bestScore = $lastBestScore = ($isMaximizing) ? -INF :INF;

            for ($i=0; $i <count($board) ; $i++) { 
                for ($j=0; $j <count($board[$i]) ; $j++) { 
                    if($board[$i][$j] == " "){
                        $board[$i][$j] = ($isMaximizing) ? "O" :"X";
                        $score = $this->minimax($board ,$depth+1, $alpha ,$beta ,!$isMaximizing);
                        $board[$i][$j] = " ";

                        if($isMaximizing){
                            if($score > $bestScore){
                                $bestScore = $score;
                                $alpha = $score;
                                if($beta<= $alpha){
                                    break;
                                }
                            }
                        }else{
                            if($score < $bestScore){
                                $bestScore = $score;
                                $beta = $score;
                                if($beta<= $alpha){
                                    break;
                                }
                            }
                        }

                        $lastBestScore = $bestScore;

                    }
    
    
                }
            }
    
            return $bestScore;
    
      }



      private function checkDraw($board=false){


        if(!$board){
            $board = $this->board;
        }


        for ($i=0; $i < count($board) ; $i++) { 
            for ($j=0; $j <count($board[$i]) ; $j++) { 
                
                 if($board[$i][$j] === " ")
                 return false;

            }
       }


       return true;

      }

      private function checkWinner($letter , $board=false){
         

    
        if(!$board){
            $board = $this->board;
        }

        for ($i=0; $i <count($board) ; $i++) { 
            for ($j=0; $j < count($board[$i]) ; $j++) { 
                if($board[$i][$j] == $letter){

                    if($i==0){
                        if($board[$i+1][$j] == $letter &&  $board[$i+2][$j] == $letter){
                            return true;
                        }
                    }

                    if($j==0){
                        if($board[$i][$j+1] == $letter &&  $board[$i][$j+2] == $letter){
                            return true;
                        }
                    }
            
                    if($i==0 && $j==0){
                        if($board[$i+1][$j+1] == $letter &&  $board[$i+2][$j+2] == $letter){
                            return true;
                        }
                    }


                    if($i==2 && $j==2){
                        if($board[$i-1][$j-1] == $letter &&  $board[$i-2][$j-2] == $letter){
                            return true;
                        }
                    }

    
                    if($i==2 && $j==0){
                        if($board[$i-1][$j+1] == $letter &&  $board[$i-2][$j+2] == $letter){
                            return true;
                        }
                    }

    
                    if($i==0 && $j==2){
                        if($board[$i+1][$j-1] == $letter &&  $board[$i+2][$j-2] == $letter){
                            return true;
                        }
                    }
    
    
                }
            }
        }
   

      }

      private function printBoard($board=false){

    
    
        if(!$board){
            $board = $this->board;
        }


        echo "\n";

    
        for ($i=0; $i < count($board); $i++) { 
    
            for ($j=0; $j < 3 ; $j++) { 
    
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
    
}
