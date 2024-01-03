<?php namespace trapta_score;

include_once "lib/conf.php";
include_once "lib/bdd.php";
include_once "lib/logger.php";
include_once "lib/helper_authent.php";
include_once "lib/ctrl_upload_pdf.php";
include_once "lib/ctrl_upload_score.php";

class TraptaScore
{
    
    private $_configuration = NULL;
    private $_logger = NULL;
    private $_bdd = NULL;
    private $_helper_authent = NULL;
    private $_ctrl_upload_pdf = NULL;
    private $_ctrl_upload_score = NULL;

    private $_account = NULL;

    public function __construct($conf_file_name)
    {
        $this->_configuration = new Configuration( dirname(__FILE__)."//conf//".$conf_file_name );

        $this->_logger = new Logger( $this->_configuration );
        $this->_bdd = new BDD( $this->_configuration );

        $this->_helper_authent = new HelperAuthent( $this->_configuration );

        $this->_ctrl_upload_pdf = new ControlerUploadPdf( $this->_configuration, $this->_bdd );
        $this->_ctrl_upload_score = new ControlerUploadScore( $this->_configuration, $this->_bdd );
        $this->_ctrl_show = new ControlerUploadScore( $this->_configuration, $this->_bdd );
    }    

    public function print_logs ($div=false){
        return $this->_logger->print_logs($div);
    }

    public function manage_authent (){
        $this->_account = $this->_helper_authent->getAccount();
    }

    public function upload_score (){
        return $this->_ctrl_upload_pdf->uploadFunction($this->_account);
    }
    

}

?>