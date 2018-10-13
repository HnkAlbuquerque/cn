<?php
/*
	Plugin Name: Plugin EFETUA INSCRIÇÃO - HOTEL
	Description: REALIZA OS INSERTS NA BASE DE DADOS - HOTEL
	autor: Henrique Albuquerque

*/
    

	function finalizar_form(){

    require_once('header.php');
    $ev_id = $_GET['ev_id'];
    $idEventoOption = $_POST['idEventoOption'];

    $sqlEventoInfo = "select ev_nome,ev_dt_ini,ev_dt_fim,to_date(to_char(ev_dt_ini,'YYYY-MM-DD'),'YYYY-MM-DD') - integer '3' AS data_venc_limite,
                        to_char(ev_dt_ini,'DD')||' a '||to_char(ev_dt_FIM,'DD/MM/YYYY') as ev_data  
                        from ev_evento  
                        where ev_id = $ev_id";
      $evInf = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $evInf = $db->Execute($sqlEventoInfo);
            $eventoInfo = $evInf -> fields; 

    $numSession = $_SESSION['gsr']['usr'];
   //numSession = '00001';
    $ip = $_SESSION['ip'];

    if (!isset($numSession))
    {
             echo "<script>window.location.replace('http://www.gideoes.org.br/estaduais/');</script>";

    }
    else
    {
        if ($_POST['lines'] > 0)
        {

            $tpLogin = substr($numSession, 0, 2);

            switch($tpLogin)
            {
                case '00': $tpLogin2 = 'G';
                break;

                case '01': $tpLogin2 = 'A';
                break;

                case '90': $tpLogin2 = 'F';
                break;
            }

            $vrTotal = $_POST["valorTotal"];
            
            if ($_POST["flag"] == 1)
            {
                $flag = "CC";
            }
            else
            {
                $flag = "BB";
            }

            //echo $ip.'------';
             

            $sqlInsert = "INSERT INTO ev_inscricao(owner_id,owner_tipo,ev_id,pg_tipo_id,owner_login) 
            				VALUES (".substr($numSession, -5).",'$tpLogin2',$ev_id,'$flag','$numSession');select CurrVal('public.ev_inscricao_ins_id_seq') as id;"; 

            //echo $sqlInsert."<br><br>";             
            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sqlInsert);
            $temp = $result -> fields; 

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

                                if ($_POST["insJanta_$i"] != null)
                                {
                                    $janta = "false";
                                }
                                else
                                {
                                    $janta = "true";
                                }


                                //$insNum = substr($_POST["insNum_$i"], -5);
                                $sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_seq) 
                                                VALUES ({$temp['id']},$gNum,'G',$janta,$i)";

                                // echo $sqlInsert; 
                               // echo $sqlInsert."<br><br>";                 
                                $result = $db->Execute($sqlInsert);


                                if ($flag == 'BB')
                                {
                                    $rowsBB = $rowsBB."<tr><td style=border-bottom:1px dotted #CCC;>$gFullNum - $gNome</td><td align=right></td></tr>";
                                }


                    			break;

                    		case "A":
                    			
                                //////////////AUX 


                                $aNum = substr($_POST["insNum_$i"],-5);
                                $aNome = $_POST["insNome_$i"];
                                $aFullNum = $_POST["insNum_$i"];

                                if ($_POST["insJanta_$i"] != null)
                                {
                                    $janta = "false";
                                }
                                else
                                {
                                    $janta = "true";
                                }

                                


                                //$insNum = substr($_POST["insNum_$i"], -5);
                                $sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_seq) 
                                                VALUES ({$temp['id']},$aNum,'A',$janta,$i)";

//echo $sqlInsert."<br><br>";   
                                $result = $db->Execute($sqlInsert); 


                               if ($flag == 'BB')
                                {
                                    $rowsBB = $rowsBB."<tr><td style=border-bottom:1px dotted #CCC;>$aFullNum - $aNome</td><td align=right></td></tr>";
                                }      

                    			break;
                                //////////////AUX 

                    		case "V":

                                //////////////VIS
                                $vNome = addslashes($_POST["insNome_$i"]);
                                $vAlias = addslashes($_POST["insAlias_$i"]);
                                $vPas = addslashes($_POST["insPast_$i"]);

                                if ($_POST["insPast_$i"] == 1)
                                {
                                    $vPas2 = 'true';
                                }else
                                {
                                    $vPas2 = 'false';
                                }

                                
                                        $sqlInsert = "INSERT INTO visitante(vis_tipo,ins_id,vis_nome,vis_pastor,vis_apelido)
                                                        VALUES ('V',{$temp['id']},'$vNome','$vPas','$vAlias'); select CurrVal('public.visitante_vis_id_seq') as vis_id;";
                                        //echo $sqlInsert."<br>";

                                                       // echo $sqlInsert."<br><br>";   
                                        $result2 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                                        $result2 = $db->Execute($sqlInsert);
                                        $tempV = $result2 -> fields; 



                                                if ($_POST["insJanta_$i"] != null)
                                                {
                                                    $janta = "false";
                                                }
                                                else
                                                {
                                                    $janta = "true";
                                                }

                                        
                                                //$insNum = substr($_POST["insNum_$i"], -5);
                                                $sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_pastor,ins_seq) 
                                                               VALUES ({$temp['id']},{$tempV['vis_id']},'V',$janta,$vPas2,$i)";
                                                //echo $sqlInsert."<br>";
//echo $sqlInsert."<br><br>";   
                                                $result = $db->Execute($sqlInsert);


                                                if ($flag == 'BB')
                                                {
                                                    $rowsBB = $rowsBB."<tr><td style=border-bottom:1px dotted #CCC;>{$tempV['vis_id']} - $vNome</td><td align=right></td></tr>";
                                                }
                           
                    			
                    			break;

                    		case "C":
                                ///////////// CRIANÇA
                                $cNome = addslashes($_POST["insNome_$i"]);
                                $vAlias = addslashes($_POST["insAlias_$i"]);
                                $vIdade = $_POST["insIdade_$i"];

                                //echo $cNome;

                                if ($vIdade <= 3)
                                {
                                    $valIns = 40;
                                }
                                else
                                {
                                    $valIns = 120;
                                }

                                $vFebre = $_POST["insFebre_$i"];
                                $vFebreDesc = addslashes($_POST["insFebreDesc_$i"]);
                                $vRestricao = $_POST["insRestricao_$i"];
                                $vRestricaoDesc = addslashes($_POST["insRestricaoDesc_$i"]);
                                $vAlergia = $_POST["insAlergia_$i"];
                                $vAlergiaDesc = addslashes($_POST["insAlergiaDesc_$i"]);
                                
                                        $sqlInsert = "INSERT INTO visitante(vis_tipo,ins_id,vis_nome,vis_idade,vis_febre,vis_febre_med,vis_rest_alim,vis_rest_alim_qual,
                                                    vis_apelido,vis_alergia,vis_alergia_qual) 
                                                    VALUES ('C',{$temp['id']},'$cNome',$vIdade,'$vFebre','$vFebreDesc','$vRestricao','$vRestricaoDesc','$vAlias','$vAlergia',
                                                    '$vAlergiaDesc'); select CurrVal('public.visitante_vis_id_seq') as vis_id;";
                                        //echo "<br>".$sqlInsert."<br>";
                                        $result3 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                                        $result3 = $db->Execute($sqlInsert);
                                        $tempC = $result3 -> fields; 
                                        
                               // echo $sqlInsert."<br><br>";   
                                        //$insNum = substr($_POST["insNum_$i"], -5);
                                        $sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_seq) 
                                                       VALUES ({$temp['id']},{$tempC['vis_id']},'C',$i)";

                                       // echo $sqlInsert."<br><br>";   

                                        $result = $db->Execute($sqlInsert);

                                        if ($flag == 'BB')
                                        {
                                            $rowsBB = $rowsBB."<tr><td style=border-bottom:1px dotted #CCC;>{$tempC['vis_id']} - $cNome</td><td align=right></td></tr>";
                                        }
                                 			
                    			break; 

                    		default:
                    			echo "nothing";
                    			break;
                    	}
                }
            } // FECHA FOR

            $rowsBB = $rowsBB."<tr><td style=border-bottom:1px dotted #CCC;>Hospedagem</td>".$vrTotal.",00<td align=right></td></tr>";


            if ($flag == 'CC')
            {

                $cckey = md5("Gideoes".intval(substr($numSession, -5))."{$tpLogin2}Anui");
                $ccnum = base64_encode($_POST['pay_ccnum']);
                $cccod = base64_encode($_POST['pay_ccverso']);

                $vr = $vrTotal / $_POST['pay_ccparc'];
                $vrParc = round($vr,2);
                $vrTotalParc = $vrParc * $_POST['pay_ccparc'];
                


                $diahoje  = date("d");
                $anoAtual = date("Y");
                $mesAtual = date("m"); 

                        if($diahoje == 31 || $diahoje == 30)  
                        {
                          if ($mesAtual == 2)
                          {
                            $diahoje = 28;
                          }
                          else
                          {
                            $diahoje = 30;
                          }
                        }


                 for ($i = 1; $i <= $_POST['pay_ccparc']; $i++)
                    {

                        if ($i == $_POST['pay_ccparc'])
                        {
                                if ($vrTotalParc > $vrTotal)
                                {
                                    $dif = $vrTotalParc - $vrTotal;
                                    $vrParc = $vrParc - $dif;
                                }
                                else
                                {
                                    if ($vrTotalParc < $vrTotal)
                                    {
                                        $dif = $vrTotal - $vrTotalParc;
                                        $vrParc = $vrParc + $dif;
                                    }

                                }
                        }

                        $dia2 = $dia;

                       $sqlInsertCC = "INSERT INTO cartao(ip,as_cod,as_tipo,as_login,cc_refer,cc_number,cc_value,cc_status,cc_nome,cc_vencto) 
                                VALUES ('$ip',".substr($numSession, -5).",'$tpLogin2','$numSession','EV_$ev_id','0',$vrParc,'0','{$_POST['pay_ccnome']}','$anoAtual-$mesAtual-$diahoje'); 
                                select CurrVal('public.cartao_cc_id_seq') as cc_id;";
                       // echo $sqlInsertCC."<br><br>";   

                        //ECHO $sqlInsertCC.'------';
                        $resultCC = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                        $resultCC = $db->Execute($sqlInsertCC);
                        $tempCC = $resultCC -> fields;
                       // echo $tempCC['cc_id']."  /   ";

                          $sqlInsertCC = "INSERT INTO cartao_process(cc_id,cc_field1,cc_field2,cc_field3,cc_field4) 
                                VALUES ({$tempCC['cc_id']},'$ccnum','{$_POST['pay_ccvencto']}','$cckey','$cccod');
                                insert into ev_ins_pg(ins_id,pg_id,pg_tipo) values ({$temp['id']},{$tempCC['cc_id']},'CC');";
                            //ECHO $sqlInsertCC.'------';

                       // echo $sqlInsertCC."<br><br>";  
                            $resultCC = $db->Execute($sqlInsertCC);            
                      
                        if($mesAtual == 12 ) 
                        {
                          $mesAtual = 0;
                          $anoAtual = $anoAtual+1;
                        }

                        $mesAtual += 1; 

                    }              
                
            }
            else
            {

             //   $vencBol = 
                //$vencBol = date('Y-m-d', strtotime("+15 days"));

                if (strtotime('+15 day') > strtotime($eventoInfo["data_venc_limite"]))
                {
                    $vencBol = date('Y-m-d', strtotime($eventoInfo["data_venc_limite"]));
                    //echo "entrou no if";
                }
                else
                {
                    $vencBol = date('Y-m-d', strtotime("+15 days"));
                    //echo "entrou no else";
                }

               $ini = "<center><b>Inscrição para a Convenção Estadual ".$eventoInfo["ev_nome"]."<br>
                        De ".$eventoInfo["ev_data"]."</b><br><br>Inscri&ccedil;&atilde;o No. ".$temp['id']."<br>
                        <table width=100% border=0 cellpadding=0 cellspacing=2>";

                $fim = "<tr><td align=right>Total</td><td align=right>".$vrTotal.",00</td></tr>
                                    </table></center>";
                $sqlInsertBB = "INSERT INTO boleto_reg(idcliente,tipo_cliente,tipo_boleto,dt_vencto,valor,st_instrucao,st_descricao,idtipo) 
                                VALUES (".substr($numSession, -5).",'$tpLogin2','E','$vencBol','$vrTotal','APÓS O VENCIMENTO, acesse WWW.ITAU.COM.BR/BOLETOS para 
                                    emitir um boleto atualizado.','$ini"."$rowsBB"."$fim'
                                    ,7);select CurrVal('public.boleto_reg_id_seq') as id_bol;";
                    
                   // echo "<pre>";print_r($sqlInsertBB);echo "</pre>";

              // echo $sqlInsertCC."<br><br>"; 
                    
                    $resultBB = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                    $resultBB = $db->Execute($sqlInsertBB);
                  //  print_r($resultBB);
                    //print_r($db);
                    $tempBB = $resultBB-> fields;

                 $sqlInsertBB = "UPDATE ev_inscricao set pg_id = '{$tempBB['id_bol']}' where ins_id = {$temp['id']} ";
                // echo $sqlInsertBB.'--------';
                //ECHO $sqlInsertCC.'------';
                $resultBB = $db->Execute($sqlInsertBB);

            }

            $sqlInscricaoOptions = "insert into ev_inscricao_options (ins_id,opt_id,quantidade,vr_unitario)
                                    values ({$temp['id']},$idEventoOption,1,$vrTotal);";

            $resultInscricaoOptions = $db->Execute($sqlInscricaoOptions);

           // echo $sqlInscricaoOptions."<br><br>";  

        ///// LISTA INSCRIÇÃO
            $sqlSelIns = "select a.as_nome,eid.ins_valor 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            where ei.ins_id = {$temp['id']}  
                            union all 
                            select v.vis_nome,eid.ins_valor 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = {$temp['id']} ";
                $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultIns = $db->Execute($sqlSelIns);
              //  $tempIns = $resultIns -> fields; 

            $sqlSelJan = "select a.as_nome,eid.valor_jantar 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.ins_jantar = true
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            where ei.ins_id = {$temp['id']} 
                            union all 
                            select v.vis_nome,eid.valor_jantar 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.ins_jantar = true
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = {$temp['id']} ";
                $resultJan = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultJan = $db->Execute($sqlSelJan);
               $tempJan = $resultIns -> fields; 

      /*      $sqlSelAlm = "select a.as_nome,eid.valor_almoco 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.valor_almoco > 0 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            where ei.ins_id = {$temp['id']}  
                            union all 
                            select v.vis_nome,eid.valor_almoco 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.valor_almoco > 0 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = {$temp['id']} ";

                $resultAlm = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultAlm = $db->Execute($sqlSelAlm);
               // $tempAlm = $resultAlm -> fields; */

          /*  $sqlSelTrans = "select a.as_nome,eid.valor_transporte 
                        from ev_inscricao ei 
                        inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.valor_transporte > 0 
                        inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                        where ei.ins_id = {$temp['id']}  
                        union all 
                        select v.vis_nome,eid.valor_transporte 
                        from ev_inscricao ei 
                        inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id and eid.valor_transporte  > 0 
                        inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                        where ei.ins_id = {$temp['id']} ";

                        //echo $sqlSelTrans;

            $resultTrans = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $resultTrans = $db->Execute($sqlSelTrans); */

        ?>
        	<h3>Inscrição: <?php echo $temp['id']; ?></h3>
            <hr>
            <h2>Inscrições</h2>
            <div class="table-responsive"> 
                <table>
                    <tr>
                        <th>
                            Nome
                        </th>
                        
                    </tr>
                            <?php
                                //echo $result;
                                foreach ($resultIns as $row) {
                                    
                                    $tempIns = $resultIns -> fields;
                            ?>
                            <tr align="right">
                                <td><?php echo $tempIns['as_nome']; ?></td>

                            </tr>
                            <?php
                            }
                            ?>

                </table>
                
                <hr>
                <h2>Jantar com Pastores</h2>
                <table>
                    <tr>
                        <th>
                            Nome
                        </th>
                        
                    </tr>
                            <?php
                                //echo $result;
                                foreach ($resultJan as $row) {
                                    
                                    $tempJan = $resultJan -> fields;
                            ?>
                            <tr align="right">
                                <td><?php echo $tempJan['as_nome']; ?></td>

                            </tr>
                            <?php
                            }
                            ?>
                </table>

                <hr>
                </table>
                <?php

                    if($flag == "BB" )
                    {
                ?>

                    <hr>
                    <table align="center">
                        <tr>
                            <td>
                                <p> O boleto está sendo processado, pedimos que aguarde até <strong>2 dias</strong> úteis.</p>
                                <p> Será enviado por <strong>e-mail</strong> e também estará disponível na página <strong>Listar Inscrições</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form>
                                    <button type="submit" formaction="http://www.gideoes.org.br/estaduais/index.php/convencoes-estaduais-online/login/listar-incricoes/?ev_id=<?=$ev_id?>">Voltar para Listar Inscrições</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                    
                

                <?php        
                    }
                    else
                    {
                ?>

                <hr>
                    <table align="center">
                        <tr>
                            <td>
                                <p> Recebemos os seus dados, seu pagamento será atualizado em breve.</p>
                            </td>
                        </tr>
                        <tr align="center">
                            <td>
                                <form>
                                    <button type="submit" formaction="http://www.gideoes.org.br/estaduais/index.php/convencoes-estaduais-online/login/listar-incricoes/?ev_id=<?=$ev_id?>">Voltar para Listar Inscrições</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                    

                <?php
                    }
                ?>


            </div>
        	
        <?php
        } //FECHA IF
        else
        {
             ?>
            Para acessar essa página é preciso adicionar pessoas à <strong>ficha de inscrição</strong>.<br>
            Você pode adicionar <a href="http://convencao.gideoes.org.br/2016/index.php/inscricao/listar-inscricoes/nova-inscricao/">Clicando Aqui</a>.

            <?php
        }

    } // FECHA ELSE

        } // FECHA FUNCTION SHORTCODE

		add_shortcode('finalizar-hotel','finalizar_form');

?>
