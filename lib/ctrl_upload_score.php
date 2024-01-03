<?php
namespace trapta_score;

class ControlerUploadScore
{
    private $_configuration;
    private $_bdd;
    public function __construct( $configuration, $bdd )
    {
        $this->_configuration = $configuration;
        $this->_bdd = $bdd;
    }


    public function uploadFunction()
    {

        $account = $this->_helper_authent->getAccount();
        
        
    }
}
?>