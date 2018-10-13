<?php
		$ev_id = $_SESSION['gsr']['ev_id'];
		$result = getAllCracha($_SESSION['gsr']['ev_id']);

		foreach ($result as $row) {
			$info = $result -> fields;

			$crachas .= "<div class='divCracha' style='margin-left:41px; margin-top:23px; width: 95mm; background-color: #FFF; border: 2px solid;'>
								<span style='float: center; top:30px;'>
								{$_SESSION['gsr']['ev_nome']}
								</span>

							  <img src='imgs/logo_gid.gif' style='margin-left:5px; float: left; height='60' width='60'><br/><br/>
			
							  <br/>
							  <br/>
							  <span class='title' style='text-align: center;' >{$info['as_apelido']}</span>
							  <br/>{$info['as_nome']}
							  <br/>{$info['campo']}
							  <br/>
							  <br/>
							  
							  <div style='text-align: right; font-size: 10px;margin-top: 8px; padding-right:2mm;'>
							  <br/>{$info['ref']}</div>
							</div>";
		}
		echo "<input type='hidden' id='ev_id' name='ev_id' value='$ev_id'>";
		
?>
<script type="text/javascript" src='js/updateInscCracha.js'></script>
<h4>Crachá Convencional</h4>
<hr>
<div class="row">	
	<div style="overflow: scroll; z-index:5; height: 320px;" class="col-md-6" id="printableArea">
			<?=$crachas?>
	</div>
</div>
<hr>
<div>	
		<button class="btn btn-primary" id="impr-all" name="impr-all" onclick="printDiv('printableArea');"> Imprimir </button>
</div>