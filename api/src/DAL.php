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


require_once "config/Connection.php";

/**
 * Data Access Layer class
 */
class DAL extends Connection
{
    private $_conn;
    public $db;
    /**
     * Class constuctor
     */
    function __construct()
    {
        $this->_conn = new Connection;
        $this->db = $this->_conn->dbConnection();
    }

    /**
     * Login method
     * 
     * @param object $data Login parameters
     * 
     * @return array
     */
    public function addNewTeam($data, $file, $dir)
    {
        // $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data != "") {
            return $this->uploads($data, $file, $dir);
        } else {
            return false;
        }
    }

    /**
     * Login method
     * 
     * @param object $data Login parameters
     * 
     * @return array
     */
    public function addNewGame($data)
    {
        // $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data != "") {
            $datas = array($data->gameName, $data->gameRules, $data->teamSize, $data->gameType);
            $qry = "INSERT INTO games(gameName, rules, teamSize, gameType) VALUES(?, ?, ?, ?)";
            $stmt = $this->db->prepare($qry);
            $stmt->execute($datas);
            if ($stmt) {
                return true;
            } else {
                return false; 
            }            
        } else {
            return 0;
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getTeams()
    {
        $json = array();
        $qry = "SELECT * FROM team";
        $stmt = $this->db->prepare($qry);
        $stmt->execute();            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getSingleGame($data)
    {
        $json = array();
        $qry = "SELECT * FROM games WHERE gameid = ?";
        $stmt = $this->db->prepare($qry);
        $stmt->execute($data);            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getGames()
    {
        $json = array();
        $qry = "SELECT * FROM games";
        $stmt = $this->db->prepare($qry);
        $stmt->execute();            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getAllPlayers()
    {
        $json = array();
        $qry = "SELECT * FROM players WHERE teamid = null OR teamid = 0";
        $stmt = $this->db->prepare($qry);
        $stmt->execute();            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getSinglePlayerById($data)
    {
        $json = array();
        $qry = "SELECT * FROM players WHERE pId = ?";
        $stmt = $this->db->prepare($qry);
        $stmt->execute($data->playerid);            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Get team details     
     * 
     * @return array
     */
    public function getFixtures()
    {
        $json = array();
        $qry = "SELECT g.*, f.* FROM games g LEFT OUTER JOIN fixtures f ON g.gameId = f.gameId";
        $stmt = $this->db->prepare($qry);
        $stmt->execute();            
        if ($stmt) {
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($json, $rows);
            }
            return $json;
        } else {
            return false; 
        }
    }

    /**
     * Login method
     * 
     * @param object $data Login parameters
     * 
     * @return array
     */
    public function addNewScore($data)
    {        
        if ($data != "") {
            $datas = array($data->score, $data->teamscore, $data->fixturescore);
            $qry = "INSERT INTO scores(pointsr1, pointsr2, pointsr3, pointsr4, gamestatus, totalpoints, teamid, fixturesid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($qry);
            return $stmt->execute($datas);            
        } else {
            return 0;
        }
    }

    /**
     * Create game fixtures
     * 
     * @param object $data game fixtures parameters
     * 
     * @return array
     */
    public function createFixtures($data)
    {        
        if ($data != "") {
            $datas = array($data->gameId, $data->gameDate, $data->gameTime, $data->gameWeek, $data->team1, $data->team2, $data->team3, $data->team4);
            $qry = "INSERT INTO games(gameId, gameDate, gameTime, gameWeek, team1, team2, team3, team4) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($qry);
            return $stmt->execute($datas);                       
        } else {
            return 0;
        }
    }

    /**
     * Login method
     * 
     * @param object $data an object of player
     * @param object $file player photo object
     * @param string $dir  upload directory
     * 
     * @return array
     */
    public function addPlayers($data, $file, $dir)
    {
        if ($data != "") {
            return $this->uploadImg($data, $file, $dir);
        } else {
            return false;
        }        
    }

    /**
     * Login method
     * 
     * @param object $data Participants Object
     * 
     * @return array
     */
    public function addParticipants($data)
    {        
        if ($data != "") {
            if ($this->_checkGameLimit($data->player)) {
                return 1;
            } else {
                $datas = array($data->player, $data->fixture);
                $qry = "INSERT INTO games(playerid, fixtureid) VALUES(?, ?)";
                $stmt = $this->db->prepare($qry);
                return $stmt->execute($datas);                
            }            
        } else {
            return 0;
        }
    }

    /**
     * Upload team and palyer images
     * 
     * @param object $data Object of data parsed
     * @param object $file Object file details
     * @param string $dir  directory name to upload image
     * 
     * @return mix
     */
    public function uploads($data, $file, $dir)
    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        
        $target_dir = $root."/assets/images/uploads/".$dir."/";
        
        // $target_file = $target_dir . basename($file['teamlogo']["name"]);
        $uploadOk = 1;
        $imageFileType = explode("/", $file['teamlogo']["type"]);
        $filename = str_replace(' ', '', $data->teamName).".".$imageFileType[1];
        $target_file = $target_dir . str_replace(' ', '', $data->teamName).".".$imageFileType[1];
        $check = explode("/", $file['teamlogo']["type"]);
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        } 
        
        if ($check[0] === "image") {
            $uploadOk = 1;
        } else {
            $uploadOk = 2;
        }
        
        if (file_exists($target_file)) {
            $uploadOk = 1;
        }
        // 149525
        if ($file['teamlogo']["size"] > 500000) {
            $uploadOk = 0;
        }

        if (strtolower($imageFileType[1]) != "jpg" && strtolower($imageFileType[1]) != "png" && strtolower($imageFileType[1] != "jpeg")) {
            $uploadOk = 3;
        }

        if ($uploadOk != 1) {
            $ret = $uploadOk;
        } else {
            
            if (move_uploaded_file($file['teamlogo']["tmp_name"], $target_file)) {
                $datas = array($data->teamName, $target_dir.$filename, $data->description);
                $qry = "INSERT INTO team(teamName, teamLogo, description) VALUES(?, ?, ?)";
                $stmt = $this->db->prepare($qry);
                $stmt->execute($datas); 
                $ret = true;
            } else {
                $ret = false;
            }
        }
        return $ret;        
    }

    /**
     * Upload team and palyer images
     * 
     * @param object $data Object of data parsed
     * @param object $file Object file details
     * @param string $dir  directory name to upload image
     * 
     * @return mix
     */
    public function uploadImg($data, $file, $dir)
    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        
        $target_dir = $root."/assets/images/uploads/".$dir."/";
        
        // $target_file = $target_dir . basename($file['teamlogo']["name"]);
        $uploadOk = 1;
        $imageFileType = explode("/", $file['playerphoto']["type"]);
        $name = $data->lastName.$data->firstName;
        $filename = str_replace(' ', '', $name).".".$imageFileType[1];
        $target_file = $target_dir . str_replace(' ', '', $name).".".$imageFileType[1];
        $check = explode("/", $file['playerphoto']["type"]);
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        } 
        
        if ($check[0] === "image") {
            $uploadOk = 1;
        } else {
            $uploadOk = 2;
        }
        
        if (file_exists($target_file)) {
            $uploadOk = 1;
        }
        // 149525
        if ($file['playerphoto']["size"] > 500000) {
            $uploadOk = 0;
        }

        if (strtolower($imageFileType[1]) != "jpg" && strtolower($imageFileType[1]) != "png" && strtolower($imageFileType[1] != "jpeg")) {
            $uploadOk = 3;
        }

        if ($uploadOk != 1) {
            $ret = $uploadOk;
        } else {
            // die(var_dump($target_file, $target_dir));
            if (move_uploaded_file($file['playerphoto']["tmp_name"], $target_file)) {
                $datas = array($data->team, $data->firstName, $data->lastName, $data->dateofbirth, $data->gender, $data->height, $data->weight, $data->dept, $data->position, $target_dir.$filename);
                $qry = "INSERT INTO players(teamid, firstName, lastName, dateofbirth, gender, height, weight, department, position, img) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($qry);
                $stmt->execute($datas); 
                $ret = true;
            } else {
                $ret = false;
            }
        }
        return $ret;        
    }

    /**
     * Check maximum game limit for each player
     * 
     * @param int $playerid player id integer value
     * 
     * @return bool
     */
    private function _checkGameLimit($playerid) 
    {
        $qry = "SELECT gamelimit FROM players WHERE pid = ?";
        $stmt = $this->db->prepare($qry);
        $stmt->execute($playerid);
        if ($stmt) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['gamelimit'] >= 4) {
                return true;
            }
        } 
        return 0;
    } 
    
    /**
     * Update player and add player to team
     * 
     * @param object $data an object of player and team parameters
     * 
     * @return bool
     */
    public function updatePlayerToTeam($data)
    {
        if ($data != "") {
            
            $datas = array($data->teamid, $data->playerid);
            $qry = "UPDATE players SET teamid = ?, updated_at = CURRENT_TIMESTAMP WHERE pId = ?";
            $stmt = $this->db->prepare($qry);
            $result = $stmt->execute($datas);
            if ($result) {
                $qry1 = "INSERT INTO selections(teamid, playerid) VALUES(?, ?)";
                $stmt1 = $this->db->prepare($qry1);
                $stmt1->execute($datas);
            }
            return $result;
        }
    }
    
    /**
     * Update player and add player to team
     * 
     * @return bool
     */
    public function getUpdatedPlayers()
    {
        $qry = "SELECT s.playerid, s.teamid, p.*, (SELECT teamName FROM team WHERE teamid = s.teamid) AS teamName FROM selections s, players p WHERE p.teamId = s.teamid AND p.pId = s.playerid ORDER BY p.updated_at DESC LIMIT 1";
        $stmt = $this->db->prepare($qry);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);        
    }
}
?>