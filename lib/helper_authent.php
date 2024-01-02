<?php
namespace trapta_score;

class HelperAuthent
{
    private $_configuration;
    public function __construct( $configuration )
    {
        $this->_configuration = $configuration;
    }


    public function getAccount()
    {
        $username = NULL;
        $password = NULL;

        if (isset($_SERVER['PHP_AUTH_USER']))
            $username = htmlspecialchars($_SERVER['PHP_AUTH_USER'], ENT_QUOTES);
        if (isset($_SERVER['PHP_AUTH_PW']))
            $password = htmlspecialchars($_SERVER['PHP_AUTH_PW'], ENT_QUOTES);

        // No valid login
        if(is_null($username) || is_null($password)){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die('Accès non autorisé.');
        }

        $account = $this->_configuration->check_credential($username, $password);
        if( !$account ){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die('Accès non autorisé.');
        }
        return $account;
    }
}
?>