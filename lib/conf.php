<?php namespace trapta_score;

class Configuration
{
    private $_fichier = NULL;
    private $_config = NULL;

    private $_accounts = array();

    public function __construct($fichier)
    {
        $this->_fichier = $fichier;
        
        $jsonStr = file_get_contents($fichier);
        $this->_config = json_decode($jsonStr, true);

        foreach ($this->_config["accounts"] as $account){
            $this->_accounts[$account["login"]] = $account;
        }

    }

    public function get_configuration_bdd( $data ){
        return $this->_config["bdd"][$data];
    }

    public function get_configuration_log( $data ){
        return $this->_config["log"][$data];
    }
    
    public function get_configuration_accounts( $login ){
        return $this->_accounts[$login];
    }
}

?>