<?php
session_start();
 
define("DS","/");

require_once("adodb".DS."adodb.inc.php");


// conexao com baanco de dados
$db =& ADONewConnection("postgres9");
$db->debug = false;
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->Connect("localhost", "postgres", "deybacsac4", "gideoes");

//verifica a sessao:
if (!validSession() && $_SERVER['SCRIPT_FILENAME'] != 'capture.php') {
    $_SESSION["gsr"]["rdrt"] = "";
    header("Location: login.php");
}


function validSession() {
    if (isset($_SESSION["gsr"]) AND isset($_SESSION["gsr"]["vldusr"])) {
        if ($_SESSION["gsr"]["vldusr"] >= time()) {
            $_SESSION["gsr"]["vldusr"] = time() + 1800;
            return true;
        }
    }
    return false;
}



?>
