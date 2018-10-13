<?php
	
	$infoEvento = getInfoEvento($_SESSION['gsr']['ev_id'],$_SESSION['gsr']['usr']);
	$arrayGetInsList = getInscricoesList($_SESSION['gsr']['ev_id']);

//echo $arrayGetInsList;
 // echo getInscricoesList($_SESSION['gsr']['ev_id']);
 // die();
?>

<table>
		<tr>
			<td>
				<h3>Evento</h3>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo "<h5>".$infoEvento['ev_nome']."</h5>"; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $infoEvento['ev_dt']; ?>
			</td>
		</tr>
</table>
<br>
<div class="table-responsive col-md-6">
<h5 align="center">Inscrições</h5>
<table class="table table-striped">
  <thead class="thead-inverse">
    <tr>
      <th>Tipo</th>
      <th>Solicitada</th>
      <th>Efetivada</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Gideões</th>
      <td><?=$arrayGetInsList[0]?></td>
      <td><?=$arrayGetInsList[4]?></td>
    </tr>
    <tr>
      <th scope="row">Auxiliares</th>
      <td><?=$arrayGetInsList[1]?></td>
      <td><?=$arrayGetInsList[5]?></td>
    </tr>
    <tr>
      <th scope="row">Visitantes</th>
      <td><?=$arrayGetInsList[2]?></td>
      <td><?=$arrayGetInsList[7]?></td>
    </tr>
    <tr>
      <th scope="row">Crianças/Jovens</th>
      <td><?=$arrayGetInsList[3]?></td>
      <td><?=$arrayGetInsList[6]?></td>
    </tr>
    <thead class="thead-inverse">
    <tr>
      <th>Total</th>
      <th><?=$arrayGetInsList[8]?></th>
      <th><?=$arrayGetInsList[9]?></th>
    </tr>
  </thead>
  </tbody>
</table>
</div>

<div class="table-responsive col-md-6">
<h5 align="center">Jantar com Pastores</h5>
<table class="table table-striped">
  <thead class="thead-inverse">
    <tr>
      <th>Tipo</th>
      <th>Solicitada</th>
      <th>Efetivada</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Gideões</th>
      <td><?=$arrayGetInsList[10]?></td>
      <td><?=$arrayGetInsList[14]?></td>
    </tr>
    <tr>
      <th scope="row">Auxiliares</th>
      <td><?=$arrayGetInsList[11]?></td>
      <td><?=$arrayGetInsList[15]?></td>
    </tr>
    <tr>
      <th scope="row">Visitantes</th>
      <td><?=$arrayGetInsList[12]?></td>
      <td><?=$arrayGetInsList[16]?></td>
    </tr>
    <tr>
      <th scope="row">Pastores</th>
      <td><?=$arrayGetInsList[13]?></td>
      <td><?=$arrayGetInsList[17]?></td>
    </tr>
    <thead class="thead-inverse">
    <tr>
      <th>Total</th>
      <th><?=$arrayGetInsList[18]?></th>
      <th><?=$arrayGetInsList[19]?></th>
    </tr>
  </thead>
  </tbody>
</table>
</div>

<div class="table-responsive col-md-6">
<h5 align="center">Transporte</h5>
<table class="table table-striped">
  <thead class="thead-inverse">
    <tr>
      <th>Tipo</th>
      <th>Solicitada</th>
      <th>Efetivada</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Gideões</th>
      <td><?=$arrayGetInsList[20]?></td>
      <td><?=$arrayGetInsList[23]?></td>
    </tr>
    <tr>
      <th scope="row">Auxiliares</th>
      <td><?=$arrayGetInsList[21]?></td>
      <td><?=$arrayGetInsList[24]?></td>
    </tr>
    <tr>
      <th scope="row">Visitantes</th>
      <td><?=$arrayGetInsList[22]?></td>
      <td><?=$arrayGetInsList[25]?></td>
    </tr>
    <thead class="thead-inverse">
    <tr>
      <th>Total</th>
      <th><?=$arrayGetInsList[26]?></th>
      <th><?=$arrayGetInsList[27]?></th>
    </tr>
  </thead>
  </tbody>
</table>
</div>

<div class="table-responsive col-md-6">
<h5 align="center">Almoço das Auxiliares</h5>
<table class="table table-striped">
  <thead class="thead-inverse">
    <tr>
      <th>Tipo</th>
      <th>Solicitada</th>
      <th>Efetivada</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Auxiliares</th>
      <td><?=$arrayGetInsList[28]?></td>
      <td><?=$arrayGetInsList[30]?></td>
    </tr>
    <tr>
      <th scope="row">Visitantes</th>
      <td><?=$arrayGetInsList[29]?></td>
      <td><?=$arrayGetInsList[31]?></td>
    </tr>
    <thead class="thead-inverse">
    <tr>
      <th>Total</th>
      <th><?=$arrayGetInsList[32]?></th>
      <th><?=$arrayGetInsList[33]?></th>
    </tr>
  </thead>
  </tbody>
</table>
</div>

