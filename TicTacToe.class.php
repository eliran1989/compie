<?php 


class TicTacToe 
{

    private $difficulty ,$lockBoard = false , $gameMode , $winner = false  , $draw = false, $players , $moveIndex=1 , $sessionID ,$mysqli;

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


       $this->mysqli = new mysqli("localhost","root","","compie");


        if ($this->mysqli->connect_errno) {
            $this->mysqli = false;
        }

    }

      public function initGame(){
  
        $this->sessionID = session_id();


        if ($this->mysqli) {
            $this->mysqli->query("INSERT INTO `tictactoe` (`session_id` ,`player1`,`player2`)
            VALUES ('$this->sessionID' , '".$this->players[0]."' , '".$this->players[1]."')");       
        }


            $this->nextMove();


      }

      public function nextMove($x=false , $y=false){

        if(!$this->draw && !$this->winner && !$this->lockBoard){

        $this->lockBoard = true;

        $letter = ($this->moveIndex%2==0) ? "X" : "O";
        $playerName = ($this->moveIndex%2==0) ? $this->players[0] : $this->players[1];
    

        $this->moveIndex++;
 
        if($this->gameMode==1 && $playerName=="cmp"){
            $this->cmpMove($letter);


            $this->winner = $this->checkWinner($letter);
            $this->draw = $this->checkDraw();

            $this->response($playerName , $letter);
            $this->lockBoard = false;
        }else{

            if($this->board[$x][$y]!=""){

                echo json_encode(array("error"=>array("message"=>"The selected location is occupied")));
                $this->lockBoard = false;
                $this->moveIndex--;
                die;
            }

            if($x!==false && $y!==false){

       
                $this->board[$x][$y] = $letter;


                $this->winner = $this->checkWinner($letter);
                $this->draw = $this->checkDraw();


                if($this->gameMode==1 && !$this->winner && !$this->draw){
                    $this->lockBoard = false;
                    $this->nextMove();
                }else{
                    $this->response($playerName , $letter);
                }

            }else{
                $this->response($playerName , $letter);
            }
        }


        if($this->winner || $this->draw){
            $this->moveIndex--;
        }

        $this->lockBoard = false;
        }else{

            if($this->lockBoard){
                echo json_encode(array("error"=>array("message"=>"The board is lock. you need to wait that other player finish is move")));
            }else{
                    
                $letter = ($this->moveIndex%2==0) ? "X" : "O";
                $playerName = ($this->moveIndex%2==0) ? $this->players[0] : $this->players[1];
                
                $this->response($playerName , $letter);
            }

        }

    


    }



    private function response($playerName,$letter){

        $response = array("session_id" =>$this->sessionID  ,"winner"=>false , "draw"=>false,  "board" => $this->board);


        if($this->winner){ 

            $response['winner'] = array(
                "name"=>$playerName,
                "letter" =>$letter
            );

            if ($this->mysqli) {
                $this->mysqli->query("UPDATE`tictactoe` SET `winner`='$playerName' WHERE `session_id`='$this->sessionID'");
            }
        }



        if($this->draw && !$this->winner){
           
            $response['draw'] = true;

            if ($this->mysqli) {
                $this->mysqli->query("UPDATE`tictactoe` SET `winner`='tie' WHERE `session_id`='$this->sessionID'");
            }
        }

        echo json_encode($response);


    }



      private function cmpMove($letter){

                    $bestScore = -INF;
                    $bestMove = null;

                    $board = $this->board;
            
    
                    for ($i=0; $i <count($board) ; $i++) { 
                        for ($j=0; $j <count($board[$i]) ; $j++) { 
                            
                            if($board[$i][$j] == ""){
                                $board[$i][$j] = $letter;
                                $score = $this->minimax($board, 0 , 0 , 0, false);
                                $board[$i][$j]="";
                                
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
                    if($board[$i][$j] == ""){
                        $board[$i][$j] = ($isMaximizing) ? "O" :"X";
                        $score = $this->minimax($board ,$depth+1, $alpha ,$beta ,!$isMaximizing);
                        $board[$i][$j] = "";

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
                
                 if($board[$i][$j] === "")
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
