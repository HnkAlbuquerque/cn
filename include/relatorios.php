
<?php

$insTipo = $_POST['insTipo'];
$insOrder = $_POST['insOrder'];
$insStatus = $_POST['insStatus'];
$ev_id = $_SESSION['gsr']['ev_id'];
$ev_ano = $_SESSION['gsr']['ev_data']-1;
$ev_nome = getInfoEvento($ev_id);
$radioMembro = $_POST['radioMembro'];
$rep_tipo = $_POST['rep_tipo'];
$tipo = $_POST['owner_tipo'];

switch ($_POST['aba']) {
    case '1':
        $aba1 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs1').addClass('active'); }); </script>";
        break;

    case '2':
        $aba2 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs2').addClass('active'); }); </script>";
        break;

    case '3':
        $aba3 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs3').addClass('active'); }); </script>";
        break;

    case '4':
        $aba4 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs4').addClass('active'); }); </script>";
        break;

    case '5':
        $aba5 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs5').addClass('active'); }); </script>";
        break;

    case '6':
        $aba6 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs6').addClass('active'); }); </script>";
        break;

    default:
        $aba1 = "in active";
        echo "<script> $(document).ready(function(){ $('#tabs1').addClass('active'); }); </script>";
        break;
}

?>


<div>
    <h4> Listas</h4>
    <hr>
</div>

<div class="tab-content">

    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" id="tabs1"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Relação de Inscrições</a></li>
            <li role="presentation" id="tabs2"><a href="#presenca" aria-controls="presenca" role="tab" data-toggle="tab">Lista de Presença</a></li>
            <li role="presentation" id="tabs3"><a href="#representacao" aria-controls="representacao" role="tab" data-toggle="tab">Representação</a></li>
            <li role="presentation" id="tabs4"><a href="#infantoJuvenil" aria-controls="infantoJuvenil" role="tab" data-toggle="tab">Infanto Juvenil</a></li>
            <li role="presentation" id="tabs5"><a href="#mensageiros" aria-controls="mensageiros" role="tab" data-toggle="tab">Mensageiros</a></li>
            <li role="presentation" id="tabs6"><a href="#poder-voto" aria-controls="poder-voto" role="tab" data-toggle="tab">Poder de Voto</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <br>
            <?php echo "<div role='tabpanel' class='tab-pane fade $aba1' id='home'>"; ?>
            <form method="post">
                <input type="hidden" name="aba" value="1">

                <div class="row">
                    <div class="col-md-2">
                        Listar por
                        <select class="form-control" name="insTipo">
                            <option value="G','A','V','C">TODOS</option>
                            <option value="G">Gideões</option>
                            <option value="A">Auxiliares</option>
                            <option value="V">Visitantes</option>
                            <option value="C">Crianças</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        Ordenar por
                        <select class="form-control" name="insOrder">
                            <option value="nome">Nome</option>
                            <option value="inscricao">Inscrição</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        Inscrições
                        <select class="form-control" name="insStatus">
                            <option value="1">Confirmadas</option>
                            <option value="0">Não confirmadas</option>
                            <option value="1','0','2','9">Todas</option>
                        </select>
                    </div>
                </div> <!-- Fexa row-->

                <br>
                <div class="table-responsive col-md-12">
                        <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar </button>
                        <button type="submit" formaction="relatorios/listaInscricoes.php" class="btn btn-success" > Excel <span class="glyphicon glyphicon-download-alt"></span></button>
                </div>

            </form>

            <br>
            <br>
            <hr>

            <?php
            if(isset($insTipo))
            {
                echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";

                echo "<div class='col-md-12'>

					              				  	<div class='col-md-12'>
					              				  	<table class='table'>
					              				  		<THEAD>
					              				  			<tr>
											              		<th colspan='2'><img src='imgs/logo_gid.gif'></th>
											              		<th colspan='3' align='center'><h5>Os Gideões Internacionais no Brasil</h5>
					              								<h6>{$ev_nome['ev_nome']}</h6></th>
											              	</tr>
						              				  		<tr>
												              		<th colspan='5' style='text-align: center;'><h5>Relação de Inscrições</h5></th>
												            </tr>
										              	<tr>
										              		<th>Inscrição</th>
										              		<th>Número</th>
										              		<th>Nome</th>
										              		<th>Campo</th>
										              		<th>Jantar</th>
										              	</tr>
										              	</THEAD>";

                $relacao = getInscricaoListTela($ev_id,$ev_ano,$insStatus,$insOrder,$insTipo);

                foreach ($relacao as $row)
                {
                    $temp = $relacao -> fields;
                    echo "
					              						<TBODY>
										              	<tr style='font-size:12px;'>
										              		<td>{$temp['inscricao']}</td>
										              		<td>".$temp['numero']."</td>
										              		<td>{$temp['nome']}</td>
										              		<td>{$temp['secmp']}</td>
										              		<td>{$temp['jantar']}</td>
										              	</tr>
										              	</TBODY>
										             	
					              				  ";


                }

                echo "</table></div></div></div>";
                ?>

                <hr>
                <span align='center'>
						                            <button class='btn btn-primary' onclick='printDiv("printableArea");'> Imprimir <span class="glyphicon glyphicon-print"></span></button>
						                    </span>
                <?php

            }
            ?>
        </div> <!-- fexa home-->

        <?php echo "<div role='tabpanel' class='tab-pane fade $aba2' id='presenca'>"; ?>
        <form method="post">
            <input type="hidden" name="aba" value="2">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail">Listar por</label>
                        <div class="form-check">
                            <p class="form-check-label">
                                <input type="radio" class="form-check-input" name="radioMembro" id="optionsRadios1" value="G" checked>
                                Gideões
                            </p>
                        </div>
                        <div class="form-check">
                            <p class="form-check-label">
                                <input type="radio" class="form-check-input" name="radioMembro" id="optionsRadios2" value="A">
                                Auxiliar
                            </p>
                        </div>
                    </div>
                </div>
            </div> <!-- Fexa row-->
            <div class="col-md-3">
                <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar </button>
            </div>
        </form>
        <br>
        <br>
        <hr>
        <?php

        if(isset($radioMembro))
        {
            echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";

            echo "<div class='col-md-12'>
				<div class='col-md-12'>";

            $relacao = getInscricaoListTelaEleicao($ev_id,$ev_ano,$radioMembro);

            $es = null;

            foreach ($relacao as $row)
            {
            	$temp = $relacao -> fields;

            	if($temp['nm_estadual'] != $es)
            	{
            		if($es != null)
            		{

            			echo "</table>
            			<div style='page-break-after: always'></div>";
            		}

            		echo "<table class='table'>			<THEAD>
					              				  			<tr>
											              		<th colspan='2'><img src='imgs/logo_gid.gif'></th>
											              		<th colspan='3' align='center'><h5>Os Gideões Internacionais no Brasil</h5>
					              								<h6>{$ev_nome['ev_nome']}</h6></th>
											              	</tr>
						              				  		<tr>
												              		<th colspan='5' style='text-align: center;'><h5>{$temp['nm_estadual']} - Lista de Presença</h5></th>
												            </tr>
										              	<tr style='font-size:14px;'>
										              		<th>Inscrição</th>
										              		<th>Número</th>
										              		<th>Nome</th>
										              		<th>Campo</th>
										              		<th>Assinatura</th>
										              	</tr>
										              	</THEAD>
										              	

										              	";
            	}

                
                echo "
					              						<TBODY>
										              	<tr style='font-size:12px; height:70px;'>
										              		<td style='vertical-align: middle;'>{$temp['inscricao']}</td>
										              		<td style='vertical-align: middle;'>".$temp['numero']."</td>
										              		<td style='vertical-align: middle;'>{$temp['nome']}</td>
										              		<td style='vertical-align: middle;'>{$temp['secmp']}</td>
										              		<td style='vertical-align: middle;'>X_____________________________________</td>
										              	</tr>
										              	</TBODY>
										             	
					              				  ";


				$es = $temp['nm_estadual'];


            }

            echo "</table></div></div></div>";
            ?>

            <hr>
            <span align='center'>
						                            <button class='btn btn-primary' onclick='printDiv("printableArea");'>Imprimir  <span class="glyphicon glyphicon-print"></span></button>
						                    </span>
            <?php

        }

        ?>


    </div> <!-- fexa presença-->


    <?php echo "<div role='tabpanel' class='tab-pane fade $aba3' id='representacao'>"; ?>
    <form method="post">
        <input type="hidden" name="aba" value="3">

        <div class="row">
            <div class="col-md-12">
                <label>Representação das Inscrições</label><br>
                <div class="form-check">
                    <p class="form-check-label">
                        <input type="radio" class="form-check-input" name="rep_tipo" id="optionsRadios1" value="se">
                        Por Estadual
                    </p>
                </div>
                <div class="form-check">
                    <p class="form-check-label">
                        <input type="radio" class="form-check-input" name="rep_tipo" id="optionsRadios2" value="cpo">
                        Por Campo
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar</span></button>
        </div>
    </form>
    <br>
    <br>
    <hr>
    <?php

    if(isset($rep_tipo))
    {
        echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";

        echo "<div class='col-md-12'>

				<div class='col-md-12'>
					<div class='col-md-1'>
						<img src='imgs/logo_gid.gif'>
					</div>
					<div class='col-md-11'><br/>
						<h5>Os Gideões Internacionais no Brasil</h5>
					    <h6>{$ev_nome['ev_nome']}</h6>
					</div>
					<div class='col-md-12'><br><br>";

					    if($rep_tipo == 'se'){

                            echo "<h5 align='center'>ESTADUAIS REPRESENTADAS</h5>";

                        }
                        elseif($rep_tipo == 'cpo'){

                            echo "<h5 align='center'>CAMPOS REPRESENTADOS</h5>";

                        }
        echo        "</div>";



        echo "<table width='98%' cellpadding='2' cellspacing='2' border='0' align='center' class='body_ut'>";

    if($rep_tipo == 'se') {
            echo "          <tr>
                               <td class='body_ub' colspan='2' rowspan='2'>Se&ccedil;&atilde;o Estadual</td>
                               <td class='body_ub' colspan='3' align='center'>Gideoes</td>
                               <td class='body_ub' colspan='3' align='center'>Auxiliares</td>
                            </tr>
                            <tr>
                                <td class='body_ub' width='80' align='center'>Na Estadual</td>
                                <td class='body_ub' width='80' align='center'>Representados</td>
                                <td class='body_ub' width='80' align='center'>Campos Repres.</td>
                                <td class='body_ub' width='80' align='center'>Na Estadual</td>
                                <td class='body_ub' width='80' align='center'>Representadas</td>
                                <td class='body_ub' width='80' align='center'>Campos Repres.</td>
                            </tr>";
    }
    elseif($rep_tipo == 'cpo'){
        echo    "<tr>
                    <td class='body_ub' width='20' align='center' rowspan='2'>Seq</td>
                    <td class='body_ub' width='50' align='center' rowspan='2'>Estadual</td>
                    <td class='body_ub' width='50' align='center' rowspan='2'>Setor</td>
                    <td class='body_ub' width='280' colspan='2' rowspan='2'>Campo</td>
                    <td class='body_ub' colspan='2' align='center'>Gideoes</td>
                    <td class='body_ub' colspan='2' align='center'>Auxiliares</td>
                </tr>
                <tr>
                    <td class='body_ub' width='80' align='center'>No Campo</td>
                    <td class='body_ub' width='80' align='center'>Representados</td>
                    <td class='body_ub' width='80' align='center'>No Campo</td>
                    <td class='body_ub' width='80' align='center'>Representadas</td>
                </tr>";
    }

    $inscritos = reportPresence($ev_id, $rep_tipo);
    if($rep_tipo == 'se') {
        foreach ($inscritos as $a => $b) {

            echo "<tr>
                        <td class='body_u' colspan='2'><b>{$b["nome"]}</b></td>";
            $totalsetor["qde_G"] = 0;
            $totalsetor["qde_A"] = 0;
            $totalsetor["ins_G"] = 0;
            $totalsetor["ins_A"] = 0;
            $totalsetor["cmp_G"] = 0;
            $totalsetor["cmp_A"] = 0;
            foreach ($b as $s => $sv) {
                if ($s != "nome") {
                    $totalsetor["qde_G"] += $sv["qde_G"];
                    $totalsetor["qde_A"] += $sv["qde_A"];
                    $totalsetor["ins_G"] += $sv["ins_G"];
                    $totalsetor["ins_A"] += $sv["ins_A"];
                    $totalsetor["cmp_G"] += $sv["cmp_G"];
                    $totalsetor["cmp_A"] += $sv["cmp_A"];

                    $total["qde_G"] += $sv["qde_G"];
                    $total["qde_A"] += $sv["qde_A"];
                    $total["ins_G"] += $sv["ins_G"];
                    $total["ins_A"] += $sv["ins_A"];
                    $total["cmp_G"] += $sv["cmp_G"];
                    $total["cmp_A"] += $sv["cmp_A"];
                }
            }
            echo "   
                           <td class='body_u' align='right'>" . number_format($totalsetor["qde_G"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                           <td class='body_u' align='right'>" . number_format($totalsetor["ins_G"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                           <td class='body_u' align='right'>" . number_format($totalsetor["cmp_G"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                           <td class='body_u' align='right'>" . number_format($totalsetor["qde_A"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                           <td class='body_u' align='right'>" . number_format($totalsetor["ins_A"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                           <td class='body_u' align='right'>" . number_format($totalsetor["cmp_A"], 0, ",", ".") . "&nbsp;&nbsp;</td>
                        </tr>";
        }
        if (count($inscritos) > 0) {
            echo "<tr>
                                 <td class='body' colspan='2' align='right'><strong>Totais&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["qde_G"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["ins_G"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["cmp_G"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["qde_A"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["ins_A"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                                 <td class='body_u' align='right'><strong>" . number_format($total["cmp_A"], 0, ",", ".") . "&nbsp;&nbsp;</strong></td>
                               </tr>";
        } else {

            echo "<tr>
                                    <td class='body' valign='top' colspan='5'>
                                        <b>N&atilde;o foi possivel localizar INSCRI&Ccedil;&Otilde;ES com essa condi&ccedil;&atilde;o !!</b>
                                    </td>
                                  </tr> ";

        }
    }
    elseif($rep_tipo == 'cpo'){
        $seq=0;
        foreach($inscritos as $a => $b) {
            if ($b["ins_G"] > 0 OR $b["ins_A"] > 0) {
                echo "<tr>
                            <td class='body_u' align='center'>".(++$seq)."</td>
                            <td class='body_u' align='center'>{$b["est"]}</td>
                            <td class='body_u' align='center'>{$b["set"]}</td>
                            <td class='body_u' align='right' width='30'>$a</td>
                            <td class='body_u'>-{$b["nome"]}</td>
                            <td class='body_u' align='right'>".number_format($b["qde_G"],0,",",".")."&nbsp;&nbsp;</td>
                            <td class='body_u' align='right'>".number_format($b["ins_G"],0,",",".")."&nbsp;&nbsp;</td>
                            <td class='body_u' align='right'>".number_format($b["qde_A"],0,",",".")."&nbsp;&nbsp;</td>
                            <td class='body_u' align='right'>".number_format($b["ins_A"],0,",",".")."&nbsp;&nbsp;</td> 
			        </tr>";
                $total["qde_G"] += $b["qde_G"];
                $total["qde_A"] += $b["qde_A"];
                $total["ins_G"] += $b["ins_G"];
                $total["ins_A"] += $b["ins_A"];
            }
        }

        if (count($inscritos) > 0){
            echo "<tr>
                    <td class='body' colspan='5' align='right'><strong>Totais&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                    <td class='body_u' align='right'><strong>".number_format($total["qde_G"],0,",",".")."&nbsp;&nbsp;</strong></td>
                    <td class='body_u' align='right'><strong>".number_format($total["ins_G"],0,",",".")."&nbsp;&nbsp;</strong></td>
                    <td class='body_u' align='right'><strong>".number_format($total["qde_A"],0,",",".")."&nbsp;&nbsp;</strong></td>
                    <td class='body_u' align='right'><strong>".number_format($total["ins_A"],0,",",".")."&nbsp;&nbsp;</strong></td>
	            </tr> ";

        }
        else{
            echo "<tr><td class=\"body\" valign='top' colspan='5'><b>N&atilde;o foi possivel localizar INSCRI&Ccedil;&Otilde;ES com essa condi&ccedil;&atilde;o !!</b></td></tr>";

        }
    }

        echo "</table></div></div></div>";
        ?>

        <hr>
        <span align='center'>
			<button class='btn btn-primary' onclick='printDiv("printableArea");'>Imprimir  <span class="glyphicon glyphicon-print"></span></button>
		</span>
        <?php

    }

    ?>
    </div> <!-- fechaa representacao-->

    <?php echo "<div role='tabpanel' class='tab-pane fade $aba4' id='infantoJuvenil'>"; ?>
        <form method="post">
            <input type="hidden" name="aba" value="4">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail">Listar inscrições infanto juvenil</label>
                     
                    </div>
                </div>
            </div> <!-- Fechaa row-->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        
                        <div class="col-md-3">
                        	De<input type="text" name="idadeMin" class="form-control">Anos
                        </div>
                        <div class="col-md-3">
                        	Até<input type="text" name="idadeMax" class="form-control">Anos
                        </div>
                    </div>
                </div>
            </div> <!-- Fechaa row-->

            <div class="col-md-3">
                <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar </button>
            </div>
        </form>
        <br>
        <br>
        <hr>
        <?php

        if(isset($_POST['aba']) && $_POST['aba'] == 4)
        {
            echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";

            echo "<div class='col-md-12'>
				<div class='col-md-12'>";

         //   $criancas =
           $criancas = reportInfantoJuvenil($ev_id,$_POST['idadeMin'],$_POST['idadeMax']);

           //////////////////////////////////////////////////////////////
		           echo "					              	<div class='col-md-12'><br/>
											              		<h5>Os Gideões Internacionais no Brasil</h5>
					              								<h6>{$ev_nome['ev_nome']}</h6>
					              							</div>
					              							<div class='col-md-12'><br/>
											              		<h5>RELA&Ccedil;&Atilde;O DE INSCRITOS</h5>
					              								<h6>CONVEN&Ccedil;&Atilde;O INFANTO JUVENIL</h6>
					              							</div>
					              				

					<table width='98%' cellpadding='2' cellspacing='2' border='0' align='center' style='background-color:#FFFFFF;'>
					<tr>
					    <td class='body_ub' width='50' align='center'>Inscri&ccedil;&atilde;o</td>
					    <td class='body_ub' width='50' align='center'>N&uacute;mero</td>
						<td class='body_ub'>Nome</td>
						<td class='body_ub' width='70' align='center'>Idade</td>
					    <td class='body_ub' width='200'>Nome do Respons&aacute;vel</td>
						<td class='body_ub' width='120' align='center'>Fone</td>
					</tr>";

					
					$contador=0;
					foreach ($criancas as $r)
		            {
		            	$row = $criancas -> fields;

					    if ($row["owner_tipo"] == "G") $codigo = "00";
					    elseif ($row["owner_tipo"] == "A") $codigo = "01";
					    elseif ($row["owner_tipo"] == "C") $codigo = "98";
					    elseif ($row["owner_tipo"] == "V") $codigo = "99";
					    $codigo .= trim(sprintf("%05d",$row["owner_id"]));
						echo "<tr>
							<td class='body_u' align='center' valign='top'>{$row["ins_id"]}&nbsp;&nbsp;</td>
							<td class='body_u' align='right' valign='top'>$codigo&nbsp;</td>
							<td class='body_u' valign='top'>".trim($row["nome"]);
						if ($row["owner_tipo"] == "C") {
							echo "<br />
								Em caso de febre ";
							if ($row["febre"] == "1") {
								echo "PODE tomar ";
								if (trim($row["medica"]) != "") echo "<strong>{$row["medica"]}</strong>.";
								else echo " medicamento.";
							} else {
								echo "<strong>NAO PODE TOMAR MEDICAMENTO</strong>.";
							}
							echo "<br />Restrição alimentar: ".($row["restricao"]=="1" ? "SIM ({$row["alimento"]}).":"NAO.");
							echo "<br />Alergia: ".($row["alergia"]=="1" ? "SIM ({$row["alergico"]}).":"NAO.");
						}
						echo "</td><td class='body_u' valign='top' align='right'>{$row["idade"]}".($row["idade_tipo"]=="M"?" m&ecirc;s(es)":" ano(s)")."</td>
					        <td class='body_u' align='center' valign='top'>".($row["vis_resp"]==""?$row["responsavel"]:$row["vis_resp"])."</td>
					        <td class='body_u' align='center' valign='top'>".($row["vis_fone"]==""?$row["fone"]:$row["vis_fone"])."</td>
					        </tr>";

                            $contador++;
					}
                   

           //////////////////////////////////////////////////////////////



            echo "</table>

            Total: $contador

            </div></div></div>";
            ?>

            <hr>
            <span align='center'>
				<button class='btn btn-primary' onclick='printDiv("printableArea");'>Imprimir  <span class="glyphicon glyphicon-print"></span></button>
			</span>
            <?php

        }

        ?>
    </div> <!-- fecha infanto juvenil-->

    <?php echo "<div role='tabpanel' class='tab-pane fade $aba5' id='mensageiros'>"; ?>
        <form method="post">
            <input type="hidden" name="aba" value="5">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail">Listar Mensageiros</label>
                     
                    </div>
                </div>
            </div> <!-- Fechaa row-->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        
                      
                    </div>
                </div>
            </div> <!-- Fechaa row-->

            <div class="col-md-3">
                <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar </button>
            </div>
        </form>
        <br>
        <br>
        <hr>
        <?php

        if(isset($_POST['aba']) && $_POST['aba'] == 5)
        {
            echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";

            echo "<div class='col-md-12'>
				<div class='col-md-12'>";

           $mensageiros = reportMensageiros($ev_id);

           //////////////////////////////////////////////////////////////
		           echo "<table style='width:100%; margin-top:0.5em; margin-left:0.5em;' cellpadding='0' cellspacing='0' border='0'>
							<tr>
								<td rowspan='2' style='width:2cm;' valign='top'>$logo</td>
								<td style='text-align:center;'>
									<font size='3'><strong>Os Gide&otilde;es Internacionais no Brasil</strong></font><br />
									<font size='2'>{$ev_nome['ev_nome']}</font><br />&nbsp;
								</td>
								<td rowspan='2' style='width:2cm;'>&nbsp;</td>
							</tr><tr>
								<td class='title' align='center'>Lista de Mensageiros<br />&nbsp;</td>
							</tr>
							</table>";

		           echo "<table cellpadding='2' cellspacing='2' border='0' align='center' style='width:100%; background-color:#FFFFFF;'>
							<tr>
								<td class='body_ub' style='width:1.5cm; text-align:center;'>Inscri&ccedil;&atilde;o</td>
								<td class='body_ub' style='width:1.5cm; text-align:center;'>N&uacute;mero</td>
								<td class='body_ub'>Nome / Campo</td>
								<td class='body_ub' style='width:6.5cm; text-align:center;'>Denomina&ccedil;&atilde;o</td>
							</tr>";				              
					
					$contador=0;
					foreach ($mensageiros as $r)
		            {
		            	$row = $mensageiros -> fields;
						$contador++;
					    echo "<tr>
								<td class='body_u' style='width:1.5cm; text-align:center; font-size:10pt; vertical-align:top;'>{$row["ins_id"]}</td>
								<td class='body_u' style='width:1.5cm; text-align:right; font-size:10pt; vertical-align:top;'>
									{$row["idmembro"]}&nbsp;</td>
								<td class='body_u' style='font-size:10pt; vertical-align:top;'>{$row["nome"]}<br />
									<spam style='font-size:85%;'>{$row["geo_cod"]} - {$row["campo"]}</spam></td>
								<td class='body_u' style='width:6.5cm; font-size:10pt; vertical-align:top;'>".($row["deno_descr"])."&nbsp;</td>
							</tr>\n";
					}

           //////////////////////////////////////////////////////////////

            echo "</table>
						<strong>Total de Mensageiros Listados: $contador</strong>
            		</div></div></div>";
            ?>

            <hr>
            <span align='center'>
				<button class='btn btn-primary' onclick='printDiv("printableArea");'>Imprimir  <span class="glyphicon glyphicon-print"></span></button>
			</span>
            <?php

        }

        ?>
</div> <!-- fecha mensageiros-->

<?php echo "<div role='tabpanel' class='tab-pane fade $aba6' id='poder-voto'>"; ?>
<form method="post">
    <input type="hidden" name="aba" value="6">

    <div class="row">
        <div class="col-md-12">
            <label>Poder de Voto das Estaduais</label><br>
            <div class="form-check">
                <p class="form-check-label">
                    <input type="radio" class="form-check-input" name="owner_tipo" id="owner_tipo" value="G">
                    Gideão
                </p>
            </div>
            <div class="form-check">
                <p class="form-check-label">
                    <input type="radio" class="form-check-input" name="owner_tipo" id="owner_tipo" value="A">
                    Auxiliar
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <button type="submit" formaction="index.php?page=relatorios" class="btn btn-primary" > Gerar</span></button>
    </div>
</form>
<br>
<hr>
<?php

if(isset($tipo)) {
    echo "<div style='overflow: scroll; z-index:5; height: 250px;' id='printableArea' name='printableArea'>";
    echo "<div class='col-md-12'>

				<div class='col-md-12'>
					<div class='col-md-1'>
						<img src='imgs/logo_gid.gif'>
					</div>
					<div class='col-md-11'><br/>
						<h5>Os Gideões Internacionais no Brasil</h5>
					    <h6>{$ev_nome['ev_nome']}</h6>
					</div>
					<div class='col-md-12'><br><br>";

    if ($tipo == 'G') {

        echo "<h5 align='center'>PODER DE VOTO DAS ESTADUAIS - GIDEÕES</h5>";
        $as_tipo = "GIDEÕES";
    } elseif ($tipo == 'A') {

        echo "<h5 align='center'>PODER DE VOTO DAS ESTADUAIS - AUXILIARES</h5>";


        $as_tipo = "AUXILIARES";
    }
    echo "<table width='98%' cellpadding='2' cellspacing='2' border='0' align='center' class='body_ut'>
            <tr><td class='body_ub' colspan='2' rowspan='2'>Estadual</td>
                    <td class='body_ub' colspan='3' align='center'>$as_tipo</td>
            </tr><tr>
                <td class='body_ub' width='80' align='center'>Na Estadual</td>
                <td class='body_ub' width='80' align='center'>Representados</td>
                <td class='body_ub' width='80' align='center'>Poder de Voto</td>
                <td class='body_ub' width='80' align='center'>Campos Representados</td>
            </tr>";

    $inscritos = poderVoto($ev_id, $tipo);
    foreach($inscritos as $a => $b) {
        $poder = 0;
        if ($b["ins"] > 0) $poder = $b["qde"] / $b["ins"];
        echo "<tr>
			<td class='body_u' align='right' width='30'>$a-</td>
			<td class='body_u'>{$b["nome"]}</td>
			<td class='body_u' align='right'>".number_format($b["qde"],0,",",".")."&nbsp;&nbsp;</td>
			<td class='body_u' align='right'>".number_format($b["ins"],0,",",".")."&nbsp;&nbsp;</td>
			<td class='body_u' align='right'>".number_format($poder,3,",",".")."&nbsp;&nbsp;</td>
			<td class='body_u' align='right'>".number_format($b["cmp"],0,",",".")."&nbsp;&nbsp;</td>
			</tr>";
        $total["qde"] += $b["qde"];
        $total["ins"] += $b["ins"];
        $total["cmp"] += $b["cmp"];
        $total["poder"] += $poder;
    }
    if (count($inscritos) > 0){
        echo "<tr>
			<td class='body' colspan='2' align='right'><strong>Totais&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
			<td class='body_u' align='right'><strong>".number_format($total["qde"],0,",",".")."&nbsp;&nbsp;</strong></td>
			<td class='body_u' align='right'><strong>".number_format($total["ins"],0,",",".")."&nbsp;&nbsp;</strong></td>
			<td class='body_u' align='right'><strong>&nbsp;&nbsp;</strong></td>
			<td class='body_u' align='right'><strong>".number_format($total["cmp"],0,",",".")."&nbsp;&nbsp;</strong></td>
			</tr>";
    }
    else {
        echo "<tr><td class=\"body\" valign='top' colspan='5'><b>N&atilde;o foi possivel localizar INSCRI&Ccedil;&Otilde;ES com essa condi&ccedil;&atilde;o !!</b></td></tr>";
    }
echo "</table></div></div></div></div>";

?>          <hr>
            <span align='center'>
				<button class='btn btn-primary' onclick='printDiv("printableArea");'>Imprimir  <span class="glyphicon glyphicon-print"></span></button>
			</span>

<?php } // fecha if ?>


</div> <!--- fecha poder de voto-------->



</div> <!-- Tab panes content-->

</div> <!-- tab panel fecha -->


</div>

              

							
