<?php
/**
 * PHP Version 8
 * 
 * @category Application
 * @package  Web_Application
 * @author   Joseph Samuel <joseph.samuel@cinfores.com>
 * @license  GITHUB github.com
 * @link     ("Blank", "http://localhost/cinfolympics.com/index.html)
 */

require_once "src/BLL.php";
/**
 * A fake router that behaves like a router routing all POST and GET request from presentaion to the api.
 */
$parse_data = new BLL;

if (isset($_POST)) {
    $data = (object) $_POST;
    $file = $_FILES;
    
    switch ($data->action) {

    case 'get_teams':
        
        $result = $parse_data->getTeam();
        if (!$result) {
            $response = array("status"=>"No teams available now", "statuscode"=>1);
        } else {
            $response = array("status"=> " Available teams", "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'get_players':
        
        $result = $parse_data->getPlayersList();
        if (!$result) {
            $response = array("status"=>"No Players available now", "statuscode"=>1);
        } else {
            $response = array("status"=> " Available players", "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'update_players':
        // die(var_dump($data));
        $result = $parse_data->updatePlayer($data);
        if (!$result) {
            $response = array("status"=>"No Players available now", "statuscode"=>1);
        } else {
            $response = array("status"=> "A Member has been added to your team", "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'get_updated_players':
        $result = $parse_data->getUpdatedPlayer();
       
        if (!$result) {
            $response = array("status"=>"No Players available now", "statuscode"=>1);
        } else {
            $response = array("status"=> "This player has been selected by ".$result['teamName'], "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'get_games':
        
        $result = $parse_data->getGame();
        if (!$result) {
            $response = array("status"=>"No games available now", "statuscode"=>1);
        } else {
            $response = array("status"=> " Available games", "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'get_fixtures':
        
        $result = $parse_data->getFixture();
        if (!$result) {
            $response = array("status"=>"No fixture available now", "statuscode"=>1);
        } else {
            $response = array("status"=> " Available fixtures", "data"=>$result, "statuscode"=>0);
        }
        break;

    case 'add_score':        
        $result = $parse_data->addScores($data);
        if (!$result) {
            $response = array("status"=>"No fixture available now", "statuscode"=>1);
        } else {
            $response = array("status"=> " Available fixtures", "data"=>$result, "statuscode"=>0);
        }
        break;
    
    case 'addteam':
        $dir = "teamLogos";
        $result = $parse_data->addTeams($data, $file, $dir);
        if (!$result) {
            $response = array("status"=>"Team add failed", "statuscode"=>1);
        } else if ($result === 2) {
            $response = array("status"=>"File is not an image.", "statuscode"=>1);
        } else if ($result === 0) {
            $response = array("status"=>"Sorry, your file is too large.", "statuscode"=>1);
        } else if ($result === 3) {
            $response = array("status"=>"Sorry, only JPG, JPEG, PNG & GIF files are allowed.", "statuscode"=>1);
        } else {
            $response = array("status"=>"The file ". htmlspecialchars(basename($file['teamlogo']["name"])). " has been uploaded.", "statuscode"=>0);
        }
        break;
    
    case 'addplayer':
        $dir = str_replace(' ', '', $data->teamname);
        
        $result = $parse_data->addPlayer($data, $file, $dir);
        // die(var_dump($result));
        if ($result) {
            $response = array("status"=>"The file ". htmlspecialchars(basename($file['playerphoto']["name"])). " has been uploaded.", "statuscode"=>0);
        } else if ($result === 2) {
            $response = array("status"=>"File is not an image.", "statuscode"=>1);
        } else if ($result === 0) {
            $response = array("status"=>"Sorry, your file is too large.", "statuscode"=>1);
        } else if ($result === 3) {
            $response = array("status"=>"Sorry, only JPG, JPEG, PNG & GIF files are allowed.", "statuscode"=>1);
        } else {
            $response = array("status"=>"Team add failed", "statuscode"=>1);
        }
        break;

    case 'addgame':
        
        $result = $parse_data->addGames($data);
        if (!$result) {
            $response = array("status"=>"Team add failed", "statuscode"=>1);
        } else {
            $response = array("status"=> htmlspecialchars($data->gameName). " has been added.", "statuscode"=>0);
        }
        break;

    case 'addparticipants':
        
        $result = $parse_data->addParticipant($data);
        if (!$result) {
            $response = array("status"=>"Participant add failed", "statuscode"=>1);
        } else {
            $response = array("status"=> "Participant has been added.", "statuscode"=>0);
        }
        break;
    
    default:
        $response = array("status"=>"invalid request action");
        break;
    }

} else if (isset($_GET)) {
    $data = (object) $_POST;
}
echo json_encode($response);

?>