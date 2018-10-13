<?php


		echo "Recibo enviado!";

		echo updateRecibo($_POST["ins_id"],$_SESSION['gsr']['usr']);

		echo "<script>setTimeout(function () { close();}, 2000);</script>";

?>

