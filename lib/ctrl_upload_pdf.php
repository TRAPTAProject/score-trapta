<?php
namespace trapta_score;

class ControlerUploadPdf
{
    private $_configuration;
    private $_helper_authent;
    public function __construct( $configuration, $helper_authent )
    {
        $this->_configuration = $configuration;
        $this->_helper_authent = $helper_authent;
    }


    public function uploadFunction($account)
    {
        if (isset($_FILES['fileToUpload'])) {
            $temp = explode('.', $_FILES['fileToUpload']['name']);
            $extension = end($temp);
            if (
                ($_FILES['fileToUpload']['type'] == 'application/pdf') &&
                ($_FILES['fileToUpload']['size'] < 5000000) &&
                ($extension == 'pdf')
            ) {

                $LIB_HOME = dirname(__FILE__).'/..';
                
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $this->_configuration->get_pdf_path($account) . '\/' .date('Y-m-d_hia'). '.pdf')) {
                    echo('Le fichier a ete mis en ligne.<br>Vous pouvez le retrouver sur votre page de resultats.');

                } else {
                    echo('<p style=\'color:#F00\'>Impossible de mettre en ligne ce fichier.</p>');
                }

            } else {
                echo('<p style=\'color:#F00\'>Le fichier doit etre un PDF de moins de 5Mo.</p>');
            }
        } else {
            echo('<p style=\'color:#F00\'>Aucun fichier spécifié.</p>');
        }
    }
}
?>