<?php namespace trapta_score;

include_once "lib/conf.php";
include_once "lib/bdd.php";
include_once "lib/logger.php";

class TraptaScore
{
    
    private $_configuration = NULL;
    private $_logger = NULL;
    private $_bdd = NULL;

    public function __construct($conf_file_name)
    {
        $this->_configuration = new Configuration( dirname(__FILE__)."/conf/".$conf_file_name );

        $this->_logger = new Logger( $this->_configuration );
        $this->_bdd = new BDD( $this->_configuration );
    }    

    public function print_logs ($div=false){
        return $this->_logger->print_logs($div);
    }
    

}

?>