<?php
namespace trapta_score;

class ControlerUploadPdf
{
    private $_configuration;
    private $_bdd;
    public function __construct( $configuration, $bdd )
    {
        $this->_configuration = $configuration;
        $this->_bdd = $bdd;
    }

    private function set_event_status($account, $status){

        if (!isset($_POST['eventname']) || !isset($_POST['eventdate'])) {
            header('HTTP/1.0 400 Bad Request');
            die();
        }
        $eventname = $_POST['eventname'];
        $eventdate = $_POST['eventdate'];

        $pdo = $this->_bdd->get_PDO();
        $stmt = $pdo->prepare("UPDATE EVENTS SET SHOW=:SHOW_STATUS WHERE USERNAME=:USERNAME AND EVENTDATE=:EVENTDATE AND EVENTNAME=:EVENTNAME");
        $stmt->bindValue(":USERNAME", $account['username']);
        $stmt->bindValue(":EVENTNAME", $eventname);
        $stmt->bindValue(":EVENTDATE", $eventdate);
        $stmt->bindValue(":SHOW_STATUS", $status);
        $stmt->execute();
    }

    public function show($account)
    {
        $this->set_event_status($account, 'TRUE');
    }

    public function hide($account)
    {
        $this->set_event_status($account, 'FALSE');
    }
}
?>