<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("gamemodel");
        $this -> load -> model("namesmodel");
        $this -> load -> model("usermodel");
        $this -> load -> model("newsmodel");
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
            $userTotalScore = $this -> usermodel -> getUserTotalScore($nickname);

            $isAdmin = $this -> usermodel -> isAdmin($nickname);
            $isThereNews = $this -> newsmodel -> isThereNews($nickname);

            if($this -> gamemodel -> checkActiveGame($nickname)){

                $activeGame = $this -> gamemodel -> getActiveGame($nickname);
                $gameList   = $this -> gamemodel ->getListOfGames();

                $gid = $activeGame[0]['gid'];
                $gameState  = $this -> gamemodel -> getGameState($gid);

                if($gameState != 2 && $gameState != 3 && $gameState != 6){

                    $data = array('gameList' => $gameList, 
                                  'activeGame' => $activeGame,
                                  'totalScore' => $userTotalScore,
                                  'isThereNews' => $isThereNews,
                                  'isAdmin' => $isAdmin);

                }else if($gameState == 2 || $gameState == 3){ // tempResult and ResutTillNow

                    $resultTillNow = $this -> gamemodel -> getGameResultUntilNow($gid);

                    $data = array('gameList' => $gameList,
                                  'activeGame' => $activeGame,
                                  'result' => $resultTillNow,
                                  'totalScore' => $userTotalScore,
                                  'isThereNews' => $isThereNews,
                                  'isAdmin' => $isAdmin);

                }else if($gameState == 6){

                    $resultTillNow = $this -> gamemodel -> getGameResultUntilNow($gid);
                    $ToJudgeNames  = $this -> gamemodel -> getToJudgeNamesForUser($gid,$nickname);

                    $data = array('activeGame' => $activeGame,
                                  'result' => $resultTillNow,
                                  'toJudge' => $ToJudgeNames,
                                  'totalScore' => $userTotalScore,
                                  'isThereNews' => $isThereNews,
                                  'isAdmin' => $isAdmin);

                }

            } else {

                $data = array('gameList' => $this -> gamemodel ->getListOfGames(),
                              'totalScore' => $userTotalScore,
                              'isThereNews' => $isThereNews,
                              'isAdmin' => $isAdmin);

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

            $lastTurnId = $this -> gamemodel -> getLastTurnId($gid);
            $turnState  = $this -> gamemodel -> getTurnState($lastTurnId);
            $gameState  = $this -> gamemodel -> getGameState($gid);

            if($turnState == 2 && $gameState == 2){
                
                $this -> checkAndCreateNewRound($gid);

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
    public function checkAndStartGame($gid){ // checked

        if(!$this -> gamemodel -> gameHasFreeCapacity($gid)){

            $this -> checkAndCreateNewRound($gid);

        }else{

            return false;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkAndCreateNewRound($gid){ // checked

        if(!$this -> gamemodel -> isGameRoundsCompleted($gid)){

            $this -> createNewRound($gid);

        }else{

            return false;
            //$this -> scheduleFinishGame($gid);

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

        $this -> gamemodel -> setReferies($tid);
        $this -> gamemodel -> changeGameState($gid,6);

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
            $gameState = $this -> gamemodel -> getGameState($gid);

            if($turnState != 1 && $gameState == 1){

                $this -> stopTurn($gid,$tid);

            }
            
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function updateGameStateOnLastJudge($nid,$gid){

        $lastTurnId = $this -> gamemodel -> getLastTurnId($gid);
        $turnState  = $this -> gamemodel -> getTurnState($lastTurnId);

        if($this -> namesmodel -> lastJudgeInThisTurn($lastTurnId) == 1 && $turnState != 2){

            $this -> gamemodel -> changeTurnState($lastTurnId,2);

            if(!$this -> gamemodel -> isGameRoundsCompleted($gid)){

                $this -> gamemodel -> changeGameState($gid,2);
                $this -> scheduleStartNewTurn($gid);

            }else{

                $this -> gamemodel -> changeGameState($gid,3);
                $this -> scheduleFinishGame($gid);

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

        if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $data = $this->gamemodel->get20BestUsersAcordingTotalScores();

            echo json_encode($data);

        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function updateUserTotalScore($uid){
            
    	$userTotalScore = $this -> namesmodel -> getUserTotalNamesScore($uid);
	
        $this -> usermodel -> updateUserTotalScore($uid , $userTotalScore);

	}
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function test(){

        //$uid = $this -> usermodel -> getUserIdByNickname('emadagha');

        $temp  = $this -> gamemodel -> getGameMembers(1);

        print_r($temp);

        $userIds = $this -> usermodel -> getUserIds($temp);

        print_r($userIds);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function judge(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else if(!isset($_POST['name']) || !isset($_POST['family']) || !isset($_POST['car']) || !isset($_POST['color']) ||
                    !isset($_POST['city']) || !isset($_POST['objects']) ||  !isset($_POST['nid']) || !isset($_POST['gid']) || count($_POST)!= 8){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid

        }else {

            $nickname = $this->session->userdata('nickname');
            $nid = $_POST['nid'];
            $gid = $_POST['gid'];

            $checkNameIsScored = $this -> gamemodel -> checkNameIsScored($nid);

            if($checkNameIsScored == 1 ){

                echo json_encode(array("result" => "57")); // This name was not found

            } else if($checkNameIsScored == -1){

                echo json_encode(array("result" => "54")); // This name is scored before
                
            }else if($this -> gamemodel -> checkUserIsValidForJudgment($nid,$nickname) == 0 ){

                echo json_encode(array("result" => "55")); // The user is not valid for judging this name

            }else if($this -> gamemodel -> namesIsForThisGame($nid,$gid) == 0){

                echo json_encode(array("result" => "58")); // names is not for this game

            }else{

                $score = ($_POST['name'] * 10) + ($_POST['family'] * 10) + ($_POST['car'] * 10) + 
                         ($_POST['color'] * 10) + ($_POST['city'] * 10) + ($_POST['objects'] * 10) ;

                $result = $this -> gamemodel -> setNameScore($score, $nid);

                if($result){
                    
                    $uidWhoHasBeenJudged = $this -> namesmodel -> getUserIdByNid($nid);
                    $this -> updateUserTotalScore($uidWhoHasBeenJudged);

                    $this -> updateGameStateOnLastJudge($nid,$gid);

                    echo json_encode(array("result" => "30")); // Success

                }else{

                    echo json_encode(array("result" => "56")); // Error in judging names

                }

            }
        }
    }

}
?>
