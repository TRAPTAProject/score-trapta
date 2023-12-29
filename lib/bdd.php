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
          die("SQLite 3 NOT supported.");
        
        try{

            $LIB_HOME = dirname(__FILE__).'/..';
            $this->_pdo = new PDO(
                str_replace('$LIB_HOME', $LIB_HOME, $this->_configuration->get_configuration_bdd("url")),
                $this->_configuration->get_configuration_bdd("login"),
                $this->_configuration->get_configuration_bdd("password") );
                $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_pdo->query("PRAGMA synchronous = OFF");
                $this->_pdo->query("PRAGMA journal_mode = MEMORY");
        } catch(Exception $e) {
            echo "Impossible d'accéder à la base de données ".$this->_configuration->get_configuration_bdd("url")." : ".$e->getMessage();
            die();
        }
    }

    public function get_PDO(){
        return $this->_pdo;
    }

}

?>