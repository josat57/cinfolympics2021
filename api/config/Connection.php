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

require_once "config.php";
/**
 * Database connection class.
 * This class has only one method the initiates database connection and returns the response from the database.
 */
class Connection
{
    private $_db_host = DBHOST;
    private $_db_name = DBNAME;
    private $_db_user = USERNAME;
    private $_db_key = PASSWORD;
    /**
     * DB Connection method 
     * 
     * @return object
     */
    public function dbConnection()
    {
        try {
            $dbconn = new PDO('mysql:host='.$this->_db_host.';dbname='.$this->_db_name, $this->_db_user, $this->_db_key);
            $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if ($dbconn) {
                return $dbconn;
            } else {                
                return false;
            }
            $dbconn->null;
        } catch (PDOException $e) {
            return $e->getMessage();        
        }
    }
    
    /**
     * Create database user with previlages
     * 
     * @param object $dbconn Database connection string
     * 
     * @return bool
     */
    public function createDBUser($dbconn)
    {
        try {
            $sql = "CREATE USER 'rivbiobank'@'%' IDENTIFIED WITH mysql_native_password AS '***';GRANT ALL PRIVILEGES ON *.* TO 'rivbiobank'@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
            $dbconn->exec($sql);
            return true;
        } catch (\Throwable $e) {
            return $sql . "<br />" . $e->getMessage();
        } catch (PDOException $e) {
            return $sql . "<br />" .$e->getMessage();
        }
    }

    /**
     * Create database for the application
     * 
     * @param string $dbName name of database to be created
     * @param object $dbconn database connection string
     * 
     * @return bool
     */
    public function createDB($dbName, $dbconn)
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS".$dbName;
            // use exec() because no results are returned
            $dbconn->exec($sql);
            return true;
        } catch(PDOException $e) {
            return $sql . "<br>" . $e->getMessage();
        }
    }

    /**
     * Create databse schemas
     * 
     * @param string $query  Query string
     * @param object $dbconn database connection string
     * 
     * @return bool
     */
    public function createSchema($query, $dbconn)
    {
        try {            
            $dbconn->exec($query);
            return true;
        } catch(PDOException $e) {
            return $query . "<br>" . $e->getMessage();
        }
    }
}

?>