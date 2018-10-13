<?php

$numIns = $_POST['numIns'];
$ev_id = $_SESSION['gsr']['ev_id'];
$ev_ano = $_SESSION['gsr']['ev_data']-1;
$evInfo = getInfoEvento($ev_id);
$mesNome = getStringMes(date('m'));
$evMesNome = getStringMes(intval($evInfo['evmesfim']));
$infoPessoa = explode("?", $_POST['convencional']);


switch ($_POST['aba']) {
	case '1':
		$aba1 = "in active";
		break;

	case '2':
		$aba2 = "in active";
		break;
	
	default:
		$aba1 = "in active";
		break;
}

?>


<script>
	$(document).ready(function() {

		$("#numIns2").blur(function() {
			$.ajax({
				url: "include/selectconv.php",
				data: {numIns2: $(this).val()},
				type: "POST",
				cache: true
			}).done(function(html) {
				$("#convencional").html(html);
			});
		});


	});
	</script>


<div>
<h4> Documentos</h4>
<hr>
</div>

<div class="tab-content">

		<div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#recibo" aria-controls="recibo" role="tab" data-toggle="tab">Recibo</a></li>
              <li role="presentation"><a href="#dispensa" aria-controls="dispensa" role="tab" data-toggle="tab">Dispensa de Ponto</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
             		<br>
              		<?php echo "<div role='tabpanel' class='tab-pane fade $aba1' id='recibo'>"; ?>
                    	<form method="post">
                    	<input type="hidden" name="aba" value="1">

		                     <div class="row">	
		                        <div class="col-md-3">
		                        	Número de Inscrição	
			                        <input type="text" name="numIns" id="numIns" placeholder="Número Inscrição" class="form-control">
		                        </div>

		                    </div> <!-- Fexa row-->

		                    <br>

		                    <div class="col-md-3">
		                    	<button type="submit" formaction="index.php?page=documentos" class="btn btn-primary" > Gerar em tela </button>
		                    </div>
	
						</form>

					  <br>
		              <br>
		              <hr>

             				<?php
					              if(isset($numIns) && $numIns > 0)
					              {
					        ?>
					        		
								<div id="printableArea">
									<div style="width:100%; margin:0; page-break-after: always; text-align: center;">

										<style type="text/css">
									        * { padding:0; margin:0; font: 100%/1.25 Arial, Helvetica, sans-serif; }
									        .title, .subtitle { font-weight: bold; }
									        .title { font-size:16px; text-align: center; }
									        .subtitle { font-size:14px;  position: static;}
									        .notation { font-size:13px; }
									        .nome { font: 100%/1.25 Arial, Helvetica, sans-serif; }
									        u { font-size:80%; }
									        .nomecracha { font:20px "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;}
									        .cracha {
									            background-image:url(imgs/logo_gid_20porcento_cracha.gif);
									            background-repeat:no-repeat;
									            background-position:130px 90px;
									            text-align: center;
									        }
									        .cracha_body,
									        .cracha_body_title,
									        .cracha_body_moeda,
									        .cracha_body_valor {
									            text-align: left;
									            font-size: 12pt;
									        }
									        .cracha_body {
									            border-bottom:1px dotted #999;
									        }
									        .cracha_body_title {
									            padding-top: 5px;
									            font-size: small;
									            text-decoration: underline;
									        }
									        .cracha_body_moeda {
									            text-align: center;
									            width: 25px;
									        }
									        .cracha_body_valor {
									            text-align: right;
									            width: 70px;
									        }
									    </style>

									    
									    
									    <img src="imgs/logo_gid.gif" style="margin-left:50px; float: right;" alt="">
									    <img src="imgs/logo_gid.gif" style="float: left;" alt="">
									    <span class="subtitle">Os Gideões Internacionais no Brasil</span><br>
									    <span class="title"><?=$evInfo['ev_nome'] ?></span>

									    <br><br><br>
									    <div>
									    	<p class="cracha_apelido">
									    	<br>
									    		<span class="title" style="border-bottom:1px dotted #000;">R E C I B O</span>
									    	<br>
									   	 		Nº. <?=$numIns?>
											</p>
									    </div>
									    
									<!--<div style='z-index:0; position:relative; top:1cm; left:0cm;'><img src='images/logo_gid_20porcento.gif' alt="" /></div>//-->
									<div style="z-index:1; position:relative; background-image: url(imgs/logo_gid_20porcento.gif); background-repeat: no-repeat; background-position: center;">
									    <br>
											<table width="100%" border="0">
											    <tbody>
														    <tr>
														        <td colspan="3" class="cracha_body_title">
														        Inscrição para a Convenção
														        </td>
														    </tr>
														    
														    	<?php
														    	$insNomes = getInsIndividual($numIns);
														    	//echo "getInsIndividual($numIns)$insNomes";
														    	foreach ($insNomes as $row) 
														    		{
														    			//echo $insNomes;
														    			$temp = $insNomes -> fields;
														    			echo "<tr><td class='cracha_body'>{$temp['new_as_cod']} - {$temp['nome']}</td></tr>";
														    		}
														    	?>
														        
													
														     <tr>
														        <td colspan="3" class="cracha_body_title">
														        Itens pedidos
														        </td>
														    </tr>
														    
														    	<?php
														    	$insItens = getItensInsc($numIns);
														    	//echo "getInsIndividual($numIns)$insNomes";
														    	foreach ($insItens as $row) 
														    		{
														    			//echo $insNomes;
														    			$temp = $insItens -> fields;
														    			echo "<tr>
														    					<td class='cracha_body'>{$temp['descricao']}</td>
														    					<td class='cracha_body'>{$temp['quantidade']}</td>
														    					<td class='cracha_body'>{$temp['valor']}</td>
														    				</tr>";
														    		}

														    		$valoresRecibo = getTotaisReais($numIns);
														    	?>


											        
											    
											    <tr>
											        <td class="cracha_body" style="border:0;">&nbsp;</td>
											        <td class="cracha_body_moeda">&nbsp;</td>
											        <td class="cracha_body_valor">-------------</td>
											    </tr>
											    <tr>
											        <td class="cracha_body" style="border:0; text-align: right;">Sub-total</td>
											        <td class="cracha_body_moeda">R$</td>
											        <td class="cracha_body_valor"><?=$valoresRecibo[0]?>,00</td>
											    </tr>
											    
											    <tr>
											        <td class="cracha_body" style="border:0; text-align: right;">Desconto</td>
											        <td class="cracha_body_moeda">R$</td>
											        <td class="cracha_body_valor"><?=$valoresRecibo[1]?>,00</td>
											    </tr>
											    <tr>
											        <td class="cracha_body" style="border:0; text-align: right;">TOTAL</td>
											        <td class="cracha_body_moeda">R$</td>
											        <td class="cracha_body_valor"><?=$valoresRecibo[2]?>,00</td>
											    </tr>
											    </tbody>
											</table>
											    <br>
									</div>
									    <div style="text-align:right; font-size: 70%; z-index:1; border-top: 1px solid #BBB;"></div>
								</div>
							</div>

									<hr>
						                    <span align='center'>
						                            <button class='btn btn-primary' onclick='printDiv("printableArea");'> - Imprimir Recibo - </button>
						                    </span>
						                    <br>
						            <hr>
					              		

					        <?php
					              		
					              }	
            				?>
              		</div> <!-- fexa home-->

              		<?php echo "<div role='tabpanel' class='tab-pane fade $aba2' id='dispensa'>"; ?>
              			<form method="post">
              				<input type="hidden" name="aba" value="2">
		                    <div class="row">	
		                        <div class="col-md-3">
		                        	Número de Inscrição	
			                        <input type="text" name="numIns2" id="numIns2" placeholder="Número Inscrição" class="form-control">
		                        </div>

		                        <div class="col-md-4">
		                        	Selecione o convencional
			                        <select class="form-control" name="convencional" id="convencional">
	
			                        </select>
		                        </div>  
		                    </div> <!-- Fexa row-->
		                    <br>
		                    <div class="col-md-3">
		                    	<button type="submit" formaction="index.php?page=documentos" class="btn btn-primary" > Gerar em tela </button>
		                    </div>    
						</form>
						<br>
						<br>
						<hr>

						<?php
							if (isset($_POST['convencional']) && $_POST['convencional'] != 0)
								{
								?>

					              <div style="width:19.7cm; margin-top:0cm; font-size: 9pt;" class="cracha_body" id="printableArea">
							            <img src="imgs/top_carta.jpg" style="border:0; width: 19.7cm;" alt=""/>
							            <p style="text-align:center; font-size:14px;" class="cracha_title"><?=$evInfo['ev_nome'];?></p>
							            <p style="text-align: right;"><?=date('d')." de ".$mesNome." de ".date('Y');?></p>
							            <p>
							                Prezados Senhores
							                <br />
							                <ul>
							                    Referente: Dispensa de ponto do(a)<br />
							                    Sr(a) <span style="font-weight: bold;"><?=$infoPessoa[3];?></span>
							                </ul>
							            </p>

							            <p align="justify"><span style="font-weight: bold;">“OS GIDEÕES INTERNACIONAIS NO BRASIL”</span>, é uma Associação Cristã de Homens de Negócio e Profissionais Liberais, com Sede na Rua Camargo Paes, 474 – Jardim Guanabara, em Campinas, Estado de São Paulo, inscrita no Cadastro Nacional das Pessoas Jurídicas sob nº 49.413.776/0001-22 e seu Estatuto acha-se registrado sob nº 636, no 1º Cartório de Registro Civil das Pessoas Jurídicas dessa cidade.</p>
							            <p align="justify">Associação educativa e religiosa, sem fins lucrativos, tem como objetivo distribuir gratuitamente o Novo Testamento em hospitais, clinicas médicas, médicos, em prisões e penitenciárias, escolas, hotéis, entre as Forças Armadas e autoridades governamentais.</p>
							            <p align="justify">Anualmente esta Associação realiza sua Convenção Estadual com o propósito de reunir seus membros para ouvirem palestras inspirativas, testemunhos de pessoas salvas pelo Senhor Jesus Cristo através da leitura da Bíblia e outras partes importantes da programação.</p>
							            <p align="justify">Neste ano, a Convenção Estadual de Os Gideões acontece nos dias <?=$evInfo['evdiaini'];?> a <?=$evInfo['evdiafim'];?> de <?=$evMesNome;?>.</p>
							            <p align="justify">Entre seus membros, a Associação conta com alguns que são funcionários públicos, autárquicos e estudantes, desejosos de participarem daquele conclave, que muito representará para suas vidas espirituais.</p>
							            <p align="justify">Face ao exposto, declaramos à Vossa Excelência que o referenciado(a) <span style="font-weight: bold;"><?=$infoPessoa[3];?> participou do dia <?=$evInfo['evdiaini'];?> até o dia <?=$evInfo['evdiafim'];?> de <?=$evMesNome;?> de <?=$evInfo['evano'];?></span> no elucidado evento.</p>
							            <p align="justify">Esperando contar com seu alto espírito cristão, dando aprovação ao nosso pedido de dispensa de ponto, antecipamos nossos agradecimentos.</p>
							            <p>Aproveitamos a oportunidade para apresentar a Vossa Excelência os protestos de estima e distinta consideração.</p>
							            <p>&nbsp;</p>

							            <p style="text-align:center; font-weight: bold;">
							                <img src="imgs/assinatura_Delcio.jpg" alt="" style="border: 0; width: 150px;"/>
							                <br/>Delcio Ferreira Manrique<br />
							                Diretor Executivo</p>
							        </div>

					              			<hr>
						                    <span align='center'>
						                            <button class='btn btn-primary' onclick='printDiv("printableArea");'> - Imprimir Dispensa - </button>
						                    </span>
						                    <br>

						        <?php
						    	}
						        ?>
						        		

	
              		</div> <!-- fexa presença-->

            </div> <!-- Tab panes content-->

        </div> <!-- tab panel fecha -->


</div>

              

							
