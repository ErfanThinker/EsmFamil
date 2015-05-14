<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("gamemodel");
        $this -> load -> model("namesmodel");
        $this -> load -> model("usermodel");
        $this -> load -> library('session');

        require "../../../../../../home/emad/vendor/autoload.php";

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewGame(){ //Checked
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['maxPlayer']) || !isset($_POST['rounds']) || !isset($_POST['gname']) || count($_POST) != 3){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else if(intval($this->input->post('maxPlayer')) < 2){

            echo json_encode(array("result" => "48")); // Max Number of Players should be at least 2

        }else{

            $gname = $this -> input -> post('gname');
            $maxPlayer = intval($this->input->post('maxPlayer'));
            $rounds = intval($this->input->post('rounds'));
            $creatorNickname = $this->session->userdata('nickname');

            if($this -> gamemodel -> userIsParticipatingAnotherGame($creatorNickname)){

                echo json_encode(array("result" => "38")); // Player can not creat new game while he is playing another game!

            }else if($this -> gamemodel -> checkIfUserHasAnUnfinishedGame($creatorNickname)){

                echo json_encode(array("result" => "39")); // Each player could be owner of at most 1 game.

            }else{

                $result = $this -> gamemodel -> createNewGame($maxPlayer,$rounds,$creatorNickname, $gname);
                
                if($result){

                    // $result is gid of game
                    $this -> gamemodel -> addPlayerToGame($result,$creatorNickname);
                    echo json_encode(array("result" => "30")); // Game Created Successfully.

                }
                else {
                    
                    echo json_encode(array("result" => "41")); // There was an error in creating game

                }

            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getListOfGames(){ //checked

        if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $nickname = $this->session->userdata('nickname');

            if($this -> gamemodel -> checkActiveGame($nickname)){

                $activeGame = $this -> gamemodel -> getActiveGame($nickname);
                $gameList   = $this -> gamemodel ->getListOfGames();

                $gid = $activeGame[0]['gid'];
                $gameState  = $this -> gamemodel -> getGameState($gid);

                if($gameState != 2 && $gameState != 3){

                    $data = array('gameList' => $gameList, 
                            'activeGame' => $activeGame);

                }else if($gameState == 2){ // tempResult

                    $lastTurnResult = $this -> gamemodel -> getLastRoundResults($gid);

                    $data = array('gameList' => $gameList,
                                  'activeGame' => $activeGame,
                                  'turnResult' => $lastTurnResult);

                }else if($gameState == 3){ // finalResult

                    $finalGameResult = $this -> gamemodel -> getGameResultUntilNow($gid);

                    $data = array('gameList' => $gameList,
                                  'activeGame' => $activeGame,
                                  'finalResult' => $finalGameResult);

                }

            } else {

                $data = array('gameList' => $this -> gamemodel ->getListOfGames());

            }

            echo json_encode($data);
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removeGame(){ // Checked
        if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $nickname = $this->session->userdata('nickname');

            if(!$this -> gamemodel -> userHasAnActiveGame($nickname)){

                echo json_encode(array("result" => "42")); // User Do not have a Game

            }else{

                $gid    = $this -> gamemodel -> getUsersUnfinishedGameGid($nickname);

                if($this -> gamemodel -> getGameState($gid) == 5){
                
                    echo json_encode(array("result" => "53")); // In this state users cannot leave game

                }else{

                    $result = $this -> gamemodel -> removeGame($gid);

                    if($result){

                        echo json_encode(array("result" => "30")); // Sucsses

                    }else{

                        echo json_encode(array("result" => "43")); // There was an error in removing Game

                    }
                }
            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function addPlayerToGame(){//Checked
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['gid']) || count($_POST) != 1){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $gid = $this->input->post('gid');
            $nickname = $this->session->userdata('nickname');
            
            if($this -> gamemodel -> userIsParticipatingAnotherGame($nickname)){

                echo json_encode(array("result" => "44")); // Player can not join new game when he is participating another game

            }else if($this -> gamemodel -> checkIfUserHasAnUnfinishedGame($nickname)){

                echo json_encode(array("result" => "39")); // Player is owner of another game that is not finished yet

            }else{

                $result = $this -> gamemodel -> addPlayerToGame($gid, $nickname);

                if($result){

                    echo json_encode(array("result" => "30")); // Success
                    $this -> scheduleCheckAndStartGame($gid);

                }else{

                    echo json_encode(array("result" => "45")); // Game do not have enough capacity for new player to add

                }
            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removePlayerFromGame(){//checked
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['gid']) || count($_POST) != 1){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $nickname = $this -> session -> userdata('nickname');
            $gid      = $this -> input -> post('gid');

            if($this -> gamemodel -> ownsTheGame($nickname,$gid)){

                echo json_encode(array("result" => "46")); // Creator of Game can not remove himself from Game

            }else if(!$this -> gamemodel -> isUserParticipatingThisGame($nickname,$gid)){
                
                echo json_encode(array("result" => "47")); // User does not participate in this game

            }else if($this -> gamemodel -> getGameState($gid) == 5){
                
                echo json_encode(array("result" => "53")); // In this state users cannot leave game

            }else{
            
                $result = $this -> gamemodel -> removePlayerFromGame($gid, $nickname);
                  
                echo json_encode(array("result" => "30")); // Succese
            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewRound($gid){ // checked

        $tid = $this -> gamemodel -> createNewTurn($gid);

        $users = $this -> gamemodel -> getGameMembers($gid);
        $userIds = $this -> usermodel -> getUserIds($users);
        $this -> namesmodel -> createNames($tid,$userIds);
        
        $this -> gamemodel -> changeGameState($gid,1); // State 1 : Playing (90 seconds)

        $this -> scheduleStopTurn($gid,$tid);

        return $tid;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function scheduleCheckAndStartGame($gid){

        if(!$this -> gamemodel -> gameHasFreeCapacity($gid)){

            $this -> gamemodel -> changeGameState($gid,5); // in this state users can not leave game.

            $loop = React\EventLoop\Factory::create();

            $i = 0;
            $loop->addPeriodicTimer(7, function(React\EventLoop\Timer\Timer $timer) use (&$i, $loop,$gid) {
                $i++;

                $gameState = $this -> gamemodel -> getGameState($gid);
                
                if($gameState != 1){
                
                    $this -> checkAndStartGame($gid);
                
                }

                if ($i >= 0) {
                    $loop->cancelTimer($timer);
                }
            });

            $loop->run();
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function scheduleFinishGame($gid){

        $gameState = $this -> gamemodel -> getGameState($gid);
        
        if($gameState != 3){

            $this -> gamemodel -> changeGameState($gid,3);

        }

        $loop = React\EventLoop\Factory::create();

        $i = 0;
        $loop->addPeriodicTimer(30, function(React\EventLoop\Timer\Timer $timer) use (&$i, $loop,$gid) {
            $i++;
            
            $gameState = $this -> gamemodel -> getGameState($gid);
            
            if($gameState != 4){
            
                $this -> finishGame($gid);
            
            }

            if ($i >= 0) {
                $loop->cancelTimer($timer);
            }
        });

        $loop->run();

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function scheduleStopTurn($gid,$tid){

        $turnState = $this -> gamemodel -> getTurnState($tid);
        
        if($turnState == 0){

            $loop = React\EventLoop\Factory::create();

            $i = 0;
            $loop->addPeriodicTimer(90, function(React\EventLoop\Timer\Timer $timer) use (&$i, $loop,$gid,$tid) {
                $i++;
                
                $turnState = $this -> gamemodel -> getTurnState($tid);
                $gameState = $this -> gamemodel -> getGameState($gid);
                
                if($turnState != 1 && $gameState == 1){
                
                    $this -> stopTurn($gid,$tid);
                
                }

                if ($i >= 0) {
                    $loop->cancelTimer($timer);
                }
            });

            $loop->run();

        } 

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function scheduleStartNewTurn($gid){

        $loop = React\EventLoop\Factory::create();

        $i = 0;
        $loop->addPeriodicTimer(20, function(React\EventLoop\Timer\Timer $timer) use (&$i, $loop,$gid) {
            $i++;
                
            $this -> checkAndCreateNewRoundOrFinishGame($gid);

            if ($i >= 0) {
                $loop->cancelTimer($timer);
            }
        });

        $loop->run();

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkAndStartGame($gid){ // checked

        if(!$this -> gamemodel -> gameHasFreeCapacity($gid)){

            $this -> checkAndCreateNewRoundOrFinishGame($gid);

        }else{

            return false;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkAndCreateNewRoundOrFinishGame($gid){ // checked

        if(!$this -> gamemodel -> isGameRoundsCompleted($gid)){

            $this -> createNewRound($gid);

        }else{

            $this -> scheduleFinishGame($gid);

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function finishGame($gid){ // checked

        $this -> gamemodel -> changeGameState($gid,4); // State 4 : Finish Game


    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function stopTurn($gid,$tid){

        $this -> gamemodel -> changeTurnState($tid,1);
        $this -> gamemodel -> changeGameState($gid,2);

        $this -> scheduleStartNewTurn($gid);


    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkAndSetNames(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['gid']) || !isset($_POST['name']) || !isset($_POST['family']) || 
                 !isset($_POST['car']) || !isset($_POST['color']) || !isset($_POST['city']) || 
                 !isset($_POST['objects']) || count($_POST) != 7){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $nickname = $this -> session -> userdata("nickname");
            $gid      = $this -> input   -> post("gid");

            if(!$this -> gamemodel -> isUserParticipatingThisGame($nickname,$gid)){
                
                echo json_encode(array("result" => "47")); // User does not participate in this game

            }else{

                $userActiveGame = $this -> gamemodel -> getActiveGame($nickname);
                $activeGameGid  =  $userActiveGame[0]['gid'];

                if($activeGameGid != $gid){

                    echo json_encode(array("result" => "49")); // User's active game is not this game!

                }else{

                    $name     = $this -> input   -> post("name");
                    $family   = $this -> input   -> post("family");
                    $car      = $this -> input   -> post("car");
                    $color    = $this -> input   -> post("color");
                    $city     = $this -> input   -> post("city");
                    $objects  = $this -> input   -> post("objects");

                    $result = $this -> namesmodel -> setNames($nickname,$gid,$name,$family,$car,$color,$objects,$city);

                    if($result){
                        
                        echo json_encode(array("result" => "30")); // Success
                        $this -> updateGameStateOnFirstSetNames($nickname,$gid);

                    }else{

                        echo json_encode(array("result" => "50")); // Names had been set before

                    }
                }
            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function updateGameStateOnFirstSetNames($nickname,$gid){

        if($this -> namesmodel -> firstSetNameInThisTurn($nickname,$gid) == 1){
            
            $tid = $this -> namesmodel -> getUserLastTurn($nickname,$gid);
            $turnState = $this -> gamemodel -> getTurnState($tid);

            if($turnState == 0){
                $this -> stopTurn($gid,$tid);
            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getLastRoundResult(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['gid']) || count($_POST) != 1){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this -> gamemodel -> getNumberOfGameRoundsPlayed($gid) == 0 ){

            echo json_encode(array("result" => "51")); // Game do not have a turn to calculate it's results

        }else{

            $gameState = $this -> gamemodel -> getGameState($gid);

            if($gameState != 2){

                echo json_encode(array("result" => "52")); // You Can not have game results in this game state

            }else{

                $lastRoundResult = $this -> gamemodel -> calculateAndReturnLastRoundResults($gid);
            
                echo json_encode($lastRoundResult);

            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getGameTotalResult($gid){

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function test(){

        /*$loop = React\EventLoop\Factory::create();

        $i = 0;
        $loop->addPeriodicTimer(5, function(React\EventLoop\Timer\Timer $timer) use (&$i, $loop) {
            $i++;

            $this -> finishGame(9+$i);

            if ($i >= 0) {
                $loop->cancelTimer($timer);
            }
        });

        $loop->run();*/

        $temp = $this -> gamemodel -> getGameResultUntilNow(197);

        print_r($temp);

        //$gid = $temp[0]['gid'];

        //print_r($temp);
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function showTempResult(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $this->session->gamedata('gid');

            $data = $this->gamemodel->getTempResult($gid);

            echo json_encode($data);

        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function get20BestUsersAcordingTotalScores(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else{

            $data = $this->gamemodel->get20BestUsersAcordingTotalScores();

            echo json_encode($data);

        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function updateUserTotalScoreFromNamesTable($uid){
            
	$query = $this->namesmodel->getUserTotalNamesScore($uid);
	$myScore = 0;

	foreach ($query->result() as $myNameTable) {
		$myScore = $myScore + $myNameTable->score;
	}

	$this->usermodel->updateUserTotalScore($uid , $myScore);
    }
}
?>
