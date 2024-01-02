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

        foreach ($this->_config['accounts'] as $account){
            $this->_accounts[$account['login']] = $account;
        }

    }

    public function get_configuration_bdd( $data ){
        return $this->_config['bdd'][$data];
    }

    public function get_configuration_log( $data ){
        return $this->_config['log'][$data];
    }
    
    public function get_configuration_accounts( $id ){
        return $this->_accounts[$id];
    }
    public function check_credential( $username, $password ){
        foreach ($this->_accounts as $account) {
            if ($account['username'] === $username && $account['password'] === $password) {
                return $account;
            }
        }
        return false;
    }

    public function get_pdf_path($account){
        $LIB_HOME = dirname(__FILE__).'/..';
        return $LIB_HOME . '\/data\/' . $account['username'];
    }
}

?>