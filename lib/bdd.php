<?php namespace trapta_score;

use \PDO;

class BDD
{

    private $_configuration;
    private $_pdo;
    public function __construct( $configuration )
    {
        $this->_configuration = $configuration;

        if(!class_exists('SQLite3'))
          die('SQLite 3 NOT supported.');
        
        try{
            $LIB_HOME = dirname(__FILE__).'/..';
            $this->_pdo = new PDO(
                str_replace('$LIB_HOME', $LIB_HOME, $this->_configuration->get_configuration_bdd('url')),
                $this->_configuration->get_configuration_bdd('login'),
                $this->_configuration->get_configuration_bdd('password') );
                $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_pdo->query('PRAGMA synchronous = OFF');
                $this->_pdo->query('PRAGMA journal_mode = MEMORY');
        } catch(Exception $e) {
            echo 'Impossible d\'accéder à la base de données ' . $this->_configuration->get_configuration_bdd('url') . ' : ' . $e->getMessage();
            die();
        }
        $this->create_table_results();
    }

    public function get_PDO(){
        return $this->_pdo;
    }
    public function create_table_results(){

        $this->_pdo->query("DROP TABLE IF EXISTS RESULTS") or die("Error to DROP RESULTS");
        
        $query = "CREATE TABLE IF NOT EXISTS EVENTS(
            USERNAME varchar(20) NOT NULL,
            EVENTDATE datetime NOT NULL,
            EVENTNAME varchar(300) NOT NULL,
            SHOW int(11) NOT NULL,
            PRIMARY KEY (USERNAME, EVENTNAME) )";
        $this->_pdo->query($query) or die("Error to CREATE EVENTS");

    }

}

?>