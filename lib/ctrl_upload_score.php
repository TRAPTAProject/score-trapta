<?php
namespace trapta_score;

class ControlerUploadScore
{
    private $_configuration;
    private $_helper_authent;
    public function __construct( $configuration, $helper_authent )
    {
        $this->_configuration = $configuration;
        $this->_helper_authent = $helper_authent;
    }


    public function uploadFunction()
    {

        $account = $this->_helper_authent->getAccount();
        
        
    }
}
?>