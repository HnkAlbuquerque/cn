<?php

	deleteInsc($_POST['ins_id']);

	$qdeJanta = 0;
    $qdeAlmoco = 0;
    $qdeTrasporte = 0;
    $qdeInsGid = 0;
    $qdeInsAux = 0;
    $qdeInsVis = 0;
    $qdeDescIns = 0;
    $qdeDescJan = 0;
    $qdeHotel = 0;
    $i = 0;

	$resultadoEventoOptions = getEventoOptions($_SESSION['gsr']['ev_id']);

	for ($i=1; $i <= $_POST['qdeLinhas']; $i++) 
	{ 
		if (isset($_POST["inscDetailInfo_$i"]))
		{

				$pieces = explode("?", $_POST["inscDetailInfo_$i"]);
                
                /* PIECES
                piece 0 = owner id
                piece 1 = owner tipo
                piece 2 = jantar
                piece 3 = idade vis e crianças
                piece 4 = pastor
                piece 5 = almoço
                piece 6 = transporte
                piece 7 = mensageiro
                */
////////////
				if($pieces[2] == "t")
				{
					$qdeJanta++;
					$pieces[2] = "true";
				}
				else
					{
					$pieces[2] = "false";
					}

				if($pieces[4] == "t")
				{
					$pieces[4] = "true";
				}
				else
					{
					$pieces[4] = "false";
					}

                if($pieces[5] == "t")
                {
                    $pieces[5] = "true";
                }
                else
                    {
                    $pieces[5] = "false";
                    }

                if($pieces[6] == "t")
                {
                    $pieces[6] = "true";
                }
                else
                    {
                    $pieces[6] = "false";
                    }

                if($pieces[7] == "t")
                {
                    $pieces[7] = "true";
                }
                else
                    {
                    $pieces[7] = "false";
                    }
///////////

				switch ($pieces[1]) {
					case 'G':
						$qdeInsGid++;
						break;
					
					case 'A':
						$qdeInsAux++;
						break;

					case 'V':
						$qdeInsVis++;
						break;

					default:
						insertEditChild($_SESSION['gsr']['ev_id'],$_POST['ins_id'],$pieces[0],$pieces[1],$pieces[3]);
						break;
				}

				if ($pieces[1] != 'C')
				{
					insertInscDetail($_POST['ins_id'],$pieces[0],$pieces[1],$pieces[2],$pieces[7],0,$pieces[4],$pieces[5],$pieces[6]);	
                    
				}
		}	
	}

	if ($_POST['lines'] > 0)
    {

           
            $insId = $_POST['ins_id'];
            if(isset($insId))
            {
                
                    for ($i = 1; $i <= $_POST['repeat']; $i++ )
                    {
                        if (isset($_POST["insTipo_$i"]))
                        {
                                switch($_POST["insTipo_$i"])
                                {
                                    case "G":


                                        $gNum = substr($_POST["insNum_$i"],-5);
                                        $gNome = $_POST["insNome_$i"];
                                        $gFullNum = $_POST["insNum_$i"];

                                        // ATRIBUIÇÕES DE JANTAR E TRANSPORTE PARA GIDEÃO
                                        if ($_POST["insJanta_$i"] == null)
                                        {    
                                            $janta = "false";  

                                        }
                                        else
                                        {
                                            $janta = "true";
                                            $qdeJanta++;

                                        }

                                        if ($_POST["insTrans_$i"] != null)
                                        {    
                                            $qdeTrasporte++;
                                            $transp = "true"; 

                                        }
                                        else
                                        {
                                            $transp = "false"; 
                                        }

                                        if ($_POST["insMsg_$i"] != null)
                                        {    
                                            $mensageiro = "true"; 
                                        }
                                        else
                                        {
                                            $mensageiro = "false"; 
                                        }
                                        //////////////////////////////////////////////////

                                        if ($_POST["valDescIns_$i"] > 0) { $qdeDescIns++;};
                                        if ($_POST["valDescJan_$i"] > 0) { $qdeDescJan++;};

                                        
                                        insertInscDetail($insId,$gNum,'G',$janta,$mensageiro,$i,'false','false',$transp);

                                       // $ins_id,$owner_id,$owner_tipo,$janta,$mensageiro,$valCont=0,$ins_pastor='false',$almoco,$transporte
                                        
                                        $qdeInsGid++;
                                    break;
                                
                                    case "A":
                                        
                                         //////////////AUX 
                                         $aNum = substr($_POST["insNum_$i"],-5);
                                        $aNome = $_POST["insNome_$i"];
                                        $aFullNum = $_POST["insNum_$i"];

                                        // ATRIBUIÇÕES DE JANTAR E TRANSPORTE PARA AUXILIAR
                                        if ($_POST["insJanta_$i"] == null)
                                        {    
                                            $janta = "false";  

                                        }
                                        else
                                        {
                                            $janta = "true";
                                            $qdeJanta++;

                                        }

                                        if ($_POST["insAlmoco_$i"] == null)
                                        {    
                                            $almoco = "false";  
                                        }
                                        else
                                        {
                                            $almoco = "true";
                                            $qdeAlmoco++;
                                        }

                                        if ($_POST["insTrans_$i"] != null)
                                        {    
                                            $qdeTrasporte++;
                                            $transp = "true"; 

                                        }
                                        else
                                        {
                                            $transp = "false"; 
                                        }
                                            //////////////////////////////////////////////////

                        
                                        if ($_POST["valDescIns_$i"] > 0) { $qdeDescIns++;};
                                        if ($_POST["valDescJan_$i"] > 0) { $qdeDescJan++;};

                                       // insertInscDetail($insId,$aNum,'A',$janta,$i);
                                        insertInscDetail($insId,$aNum,'A',$janta,'false',$i,'false',$almoco,$transp);

                                        $qdeInsAux++;
                                    break;
                                        
                                          
                                    case "V":


                                        //////////////VIS
                                            $vNome = addslashes($_POST["insNome_$i"]);
                                            $vAlias = addslashes($_POST["insAlias_$i"]);
                                            $vPas = addslashes($_POST["insPast_$i"]);

                                            if ($_POST["insPast_$i"] == 1)
                                            {
                                                $vPas2 = 'true';
                                            }
                                            else
                                            {
                                                $vPas2 = 'false';
                                            }
                                        
                                            $vis_id = insertVis('V',$insId,$vNome,$_POST["insPast_$i"],$vAlias);


                                                //// OPÇÕES DO VISITANTE
                                                if ($_POST["insJanta_$i"] == null)
                                                {
                                                    $janta = "false";
                                                }
                                                else
                                                {
                                                    $janta = "true";
                                                    $qdeJanta++;
                                                }

                                                if ($_POST["insGen_"] == "F" && $_POST["insAlmoco_$i"] != null)
                                                {
                                                    $almoco = "true";
                                                    $qdeAlmoco++;
                                                }
                                                else
                                                {
                                                    $almoco = "false";
                                                }

                                                if ($_POST["insTrans_$i"] != null)
                                                {    
                                                    $qdeTrasporte++;
                                                    $transp = "true"; 

                                                }
                                                else
                                                {
                                                    $transp = "false"; 
                                                }
                                            ///////////////////////////////

                                                   // insertInscDetail($insId,$vis_id,'V',$janta,$i,$vPas2,$almoco,$transp);

                                                    insertInscDetail($insId,$vis_id,'V',$janta,'false',$i,$vPas2,$almoco,$transp);

                                                    $qdeInsVis++;                     
                                    break;
                                
                                    case "C":
                                         ///////////// CRIANÇA
                                        $cNome          = addslashes($_POST["insNome_$i"]);
                                        $vAlias         = addslashes($_POST["insAlias_$i"]);
                                        $vIdade         = $_POST["insIdade_$i"];

                                        $idOptCrianca   = $_POST["val_idopt_$i"];
                                        $valOptCrianca  = $_POST["val_$i"];

                                        $vFebre         = $_POST["insFebre_$i"];
                                        $vFebreDesc     = addslashes($_POST["insFebreDesc_$i"]);
                                        $vRestricao     = $_POST["insRestricao_$i"];
                                        $vRestricaoDesc = addslashes($_POST["insRestricaoDesc_$i"]);
                                        $vAlergia       = $_POST["insAlergia_$i"];
                                        $vAlergiaDesc   = addslashes($_POST["insAlergiaDesc_$i"]);
                                        

                                        $vis_id = insertChild('C',$insId,$cNome,$vIdade,$vFebre,$vFebreDesc,$vRestricao,$vRestricaoDesc,$vAlias,$vAlergia,$vAlergiaDesc);

                                       // insertInscDetail($insId,$vis_id,'C',$i);
                                        insertInscDetail($insId,$vis_id,'C','false','false',$i,'false','false','false');

                                        inscricaoOptionsCrianca($insId,$idOptCrianca,$valOptCrianca);
                                                    
                                        break; 

                                    default:
                                       // echo "nothing";
                                        break; 
                                }
                        }
                    } // FECHA FOR

                   

                    foreach ($resultadoEventoOptions as $row) 
                    {

                        $eventoOptions = $resultadoEventoOptions -> fields;
                        switch ($eventoOptions['aplicacao']) {
                            case '0':
                                if ($qdeHotel > 0) {

                                    insertInscricaoOptions($insId,$_POST['valorHospIdOptions'],$qdeHotel,$_POST['valorHosp']);
                                  //  echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '1':
                                if ($qdeJanta > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeJanta,$eventoOptions['valor']);

                                  //  echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '2':
                                if ($qdeInsGid > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeInsGid,$eventoOptions['valor']);

                                  //  echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '3':
                                if ($qdeInsAux > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeInsAux,$eventoOptions['valor']);
                                  //  echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '4':
                                if ($qdeAlmoco > 0) {
                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeAlmoco,$eventoOptions['valor']);
                                }
                                break;
                            case '6':
                                if ($qdeInsVis > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeInsVis,$eventoOptions['valor']);
                                   // echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '7':
                                if ($qdeDescIns > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeDescIns,$eventoOptions['valor']);
                                   // echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '8':
                                if ($qdeDescJan > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeDescJan,$eventoOptions['valor']);
                                   // echo $sqlInscricaoOptions."<br><br>";
                                }
                                break;
                            case '10':
                                if ($qdeTrasporte > 0) {

                                    insertInscricaoOptions($insId,$eventoOptions['id'],$qdeTrasporte,$eventoOptions['valor']);
                                   
                                  
                                }
                                break;
                            default:
                                break;
                        }
                    }           
            }
            else
            {

            }
	}

?>

<div id="non-printable">
                    <h3>Inscrição: <?php echo $_POST['ins_id'] ?></h3>
                <hr>

                </div>
                
               <div id="non-printable" class="col-md-6">
                    
                    <h4>Inscrições</h4>
                    
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Nome
                                </th>
                                
                            </tr>
                                    <?php
                                        $infoInsc = getInscricaoGenericByInsid($_POST['ins_id']);
                                    
                                        foreach ($infoInsc as $row) 
                                        {
                                            
                                            $tempIns = $infoInsc -> fields;
                                            $numId = $tempIns['new_as_cod'];
                                            if($numId > 0)
                                            {
                                                echo 
                                                "<tr>
                                                    <td> {$tempIns['as_nome']} </td>
                                                </tr>";
                                            }

                                        }

                                    ?>

                        </table>
                        
                        <hr>

                    
                </div> 
                <div style="overflow: scroll; z-index:5; height: 280px;">
                    <div id="printableArea" class="col-md-6">
                    <?php
                    $infoInsc2 = getInscricaoGenericByInsid($_POST['ins_id']);
                    foreach ($infoInsc2 as $row) 
                        {

                        $tempIns2 = $infoInsc2 -> fields;

                    echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$tempIns2['ins_transporte'],$tempIns2['as_apelido'],$tempIns2['campo'],$tempIns2['ref'],$tempIns2['as_nome']);

                        }
                    ?>
                    </div>
                </div>

                <div id="non-printable" class="table-responsive col-md-12" align="center">
                    <hr>
                    <span align="center">
                            <button class="btn btn-primary" onclick="printDiv('printableArea');"> - Imprimir Crachá - </button>
                    </span>
                    

                </div>