<?php
	require_once('../header.php');


$ev_id = $_POST['ev_id'];


if ($ev_id > 0 ) {

	$result = 
	"update ev_inscricao_detail set ins_credencial = true where ins_id in (select ins_id from ev_inscricao where ins_status = '1' and ev_id = $ev_id)";
	$sql = $db->Execute($result);

}
else
{
	
}

?>