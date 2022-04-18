<?php 


class TicTacToe 
{

    private $difficulty , $gameMode , $winner = false , $players , $moveIndex=1;

    private $board = array(
        array(" " ," " ," "),
        array(" " ," " ," "),
        array(" " , " " ,  " ")
    );


    function __construct($gameMode , $players , $difficulty) {
      
        $this->gameMode = $gameMode;
        $this->players = $players;
        $this->difficulty =$difficulty;

        
        if($gameMode==1){
            $this->players[] = "cmp";
        }


    }



      public function initGame(){

   
        do {
            $this->nextMove();
            $this->moveIndex++;
        } while (!$this->winner && !$this->draw);


      }

      private function nextMove(){

        $letter = ($this->moveIndex%2==0) ? "X" : "O";
        $playerName = ($this->moveIndex%2==0) ? $this->players[0] : $this->players[1];

        echo "$playerName -$letter- select move (x ,y):\n";
    
 
        if($this->gameMode==1 && $playerName=="cmp"){
            $this->cmpMove($letter);
        }else{

            
            $x = readline("x:");
            $y = readline("y:");

            while(($x<0 || $x>2) || ($y<0 || $y>2)){
                echo "You need to choose x and y between 0-2\n";
                $x = readline("x:");
                $y = readline("y:");
            }



            while($this->board[$x][$y]!=" "){
                echo "The selected location is occupied\n";
                $x = readline("x:");
                $y = readline("y:");
            }
            
            $this->board[$x][$y] = $letter;
        }

    
        

        $this->printBoard();
 

        $this->winner = $this->checkWinner($letter);
        $this->draw = $this->checkDraw();
        

        if($this->winner){
            echo "$playerName -$letter- is the Winner";
        }

        if($this->draw && !$this->winner){
            echo "This a Tie";
        }





      }



      private function cmpMove($letter){

            switch ($this->difficulty) {
                case 1:
                    
                    do {
                        $x = rand(0 ,2);
                        $y =rand(0 ,2);
                    } while ($this->board[$x][$y]!= " ");

                    $this->board[$x][$y] = $letter;

                    break;
                case 2:
                 if($this->moveIndex==1){

                        do {
                            $x = rand(0 ,2);
                            $y =rand(0 ,2);
                        } while ($this->board[$x][$y]!= " ");
                        $this->board[$x][$y] = $letter;

                 }else{

                     for ($i=0; $i < count($this->board) ; $i++) { 
                         for ($j=0; $j <count($this->board[$i]) ; $j++) { 
                            
                                if($this->board[$i][$j]==" "){
                                    $this->board[$i][$j]=$letter;
                                    if($winner = $this->checkWinner($letter)){
                                        break;
                                    }else{
                                        $this->board[$i][$j]=" ";
                                    }
                                }

                         }
                     }


                     if(!$winner){

                        do {
                            $x = rand(0 ,2);
                            $y =rand(0 ,2);
                        } while ($this->board[$x][$y]!= " ");
                        $this->board[$x][$y] = $letter;

                     }


                 }

                    break;
                case 3:


                    $bestScore = -INF;
                    $bestMove;

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

                    break;
            }






      }


      private function minimax($board , $depth ,$alpha , $beta ,  $isMaximizing){


            if($this->checkWinner("X" , $board)){
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

         print_r($board);
    
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