<?php
		$ev_id = $_SESSION['gsr']['ev_id'];
		$result = getAllCracha($_SESSION['gsr']['ev_id']);

		foreach ($result as $row) {
			$info = $result -> fields;

			$crachas .= "<div class='pag divCracha' style='width: 60mm; background-color: #EEE;'>".
                                            "<span class='title'>{$info['as_apelido']}</span><br/>".
                                                    "{$info['campo']}".
                                                    "<div style='text-align: right; font-size: 8px;margin-top: 8px; padding-right:2mm;'>".
                                                        "<br/>{$info['ref']}</div></div>";
		}
		echo "<input type='hidden' id='ev_id' name='ev_id' value='$ev_id'>";
?>
<script type="text/javascript" src='js/updateInscCracha.js'></script>
<h4>Etiqueta térmica 62mm</h4>
<hr>
<div class="row">	
	<div style="overflow: scroll; z-index:5; height: 320px;" class="col-md-3" id="printableArea">
			<?=$crachas?>
	</div>
</div>
<hr>
<div>	
		<button class="btn btn-primary" id="impr-all" name="impr-all" onclick="printDiv('printableArea');"> Imprimir </button>
</div>