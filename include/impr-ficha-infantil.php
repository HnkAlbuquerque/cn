<?php

		echo "Ficha enviada";

		echo updateFicha($_POST["ins_id"],$_SESSION['gsr']['usr']);

		echo "<script>setTimeout(function () { close();}, 2000);</script>";

?>

