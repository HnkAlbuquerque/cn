<?php


    $infoEvento = getInfoEvento($_SESSION['gsr']['ev_id'],$_SESSION['gsr']['usr']);
    $ev_id = $_SESSION['gsr']['ev_id'];

    //echo "aaa";

    $eventoInfo = getEventoInfo($ev_id);

    $numSession = $_SESSION['gsr']['usr'];

    $ip = $_SESSION['ip'];

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

    $resultadoEventoOptions = getEventoOptions($ev_id);
   

    if (!isset($numSession))
    {

             echo "<script>window.location.replace('/cn/index.php');</script>";

    }
    else
    {


        //echo $_POST['lines'].$_POST['repeat'];
        
        if ($_POST['lines'] > 0)
        {

            for ($i = 1; $i <= $_POST['repeat']; $i++ )
            { 
                if(isset($_POST["insNum_$i"]))
                {
 
                    $tpLogin = substr($_POST["insNum_$i"], 0, 2);
                    $firstOwner = substr($_POST["insNum_$i"], -5);
                    break;
                    
                }
                
            }

            
            switch($tpLogin)
            {
                case '00': $tpLogin2 = 'G';
                break;

                case '01': $tpLogin2 = 'A';
                break;

            }

            $vrTotal = $_POST["totalPG"];

            //echo $firstOwner.$tpLogin2.$ev_id.$numSession.$vrTotal;

            //frag aqui

             $insId = getInsId($firstOwner,$tpLogin2,$ev_id,$numSession);

           // echo "<br>".$insId;
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
                                       
                                        break; 
                                }
                        }
                    } // FECHA FOR

                    
                   

                    if (isset($_POST['valorHospIdOptions']) && $_POST['valorHospIdOptions'] > 0 )
                        {
                            $qdeHotel = 1;
                        }


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



        ///// LISTA INSCRIÇÃO

                ?>
                <div id="non-printable">
                    <h3>Inscrição: <?php echo $insId ?></h3>
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
                                        $infoInsc = getInscricaoGenericByInsid($insId);
                                    
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
                        <h4><?="Valor total: ".$_POST['valorTotal'].",00"?></h4>
                    
                </div> 
                <div style="overflow: scroll; z-index:5; height: 280px;">
                    <div id="printableArea" class="col-md-6">
                    <?php
                    $infoInsc2 = getInscricaoGenericByInsid($insId);
                    foreach ($infoInsc2 as $row) 
                        {

                        $tempIns2 = $infoInsc2 -> fields;
                    
                        echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$tempIns2['ins_transporte'],$tempIns2['as_apelido'],$tempIns2['campo'],$tempIns2['ref'],$tempIns2['as_nome']);

                        }
                    ?>
                    </div>
                </div>

                <div id="non-printable" class="col-md-12">
                                <hr>
                                <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" onclick="printDiv('printableArea');"> - Imprimir Crachá - </button>
                                            </div>
                                            <div class="col-md-4">
                                                     <a href="index.php?page=nova-inscricao">
                                                        <button type="button" class="btn btn-primary"> - Nova Inscrição - </button>
                                                    </a> 
                                            </div>
                                            <div class="col-md-4">
                                                <a href="index.php?page=inscricao"> 
                                                    <button type="button" class="btn btn-primary"> - Voltar - </button>
                                                </a> 
                                            </div>
                                          </div>     
                                </div>
                </div>

<?php              
        } //FECHA IF
        else
        {
            
        }

    } // FECHA ELSE
?>
