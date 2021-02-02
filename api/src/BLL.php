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

require_once "DAL.php";

/**
 * Business Logic Layer
 * 
 * PHP Version 8
 * 
 * @category Application
 * @package  Web_Application
 * @author   Joseph Samuel <joseph.samuel@cinfores.com>
 * @license  GITHUB github.com
 * @link     ("Blank", "http://localhost/cinfolympics.com/index.html)
 */
class BLL
{
    private $_data;

    /**
     * Business Logic Layer class
     */
    function __construct()
    {
        $this->_data = new DAL;
    }

    /**
     * User login method, manages the users login process.
     * 
     * @return array
     */
    public function getTeam()
    {
        $result = $this->_data->getTeams();        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get details of all registered players.
     * 
     * @return array
     */
    public function getPlayersList()
    {
        $result = $this->_data->getAllPlayers();        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update player info based on selecting team.
     * 
     * @return array
     */
    public function updatePlayer($data)
    {
        $result = $this->_data->updatePlayerToTeam($data);        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update player info based on selecting team.
     * 
     * @return array
     */
    public function getUpdatedPlayer()
    {
        $result = $this->_data->getUpdatedPlayers();        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @return array
     */
    public function getGame()
    {
        $result = $this->_data->getGames();        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @return array
     */
    public function getFixture()
    {
        $result = $this->_data->getFixtures();        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @param object $data an object of required user login details
     * 
     * @return array
     */
    public function addGames($data)
    {
        $result = $this->_data->addNewGame($data);        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Game score for current fixtures.
     * 
     * @param object $data Scores object
     * 
     * @return array
     */
    public function addScores($data)
    {
        $result = $this->_data->addNewScore($data);        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @param object $data an object of required user login details
     * 
     * @return array
     */
    public function addTeams($data, $file, $dir)
    {
        $result = $this->_data->addNewTeam($data, $file, $dir);
        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @param object $data player object
     * @param object $file player photo object
     * @param string $dir  photo upload directory
     * 
     * @return bool
     */
    public function addPlayer($data, $file, $dir)
    {
        $result = $this->_data->addPlayers($data, $file, $dir);
        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * User login method, manages the users login process.
     * 
     * @param object $data participant object
     * 
     * @return bool
     */
    public function addParticipant($data)
    {
        return $this->_data->addParticipants($data);                
    }
    
}

?>