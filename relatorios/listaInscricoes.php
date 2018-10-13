<?php

require_once('../header.php');

//$mes = 

$insTipo = $_POST['insTipo'];
$insOrder = $_POST['insOrder'];
$insStatus = $_POST['insStatus'];
$ev_id = $_SESSION['gsr']['ev_id'];
$ev_ano = $_SESSION['gsr']['ev_data']-1;

  switch ($insTipo) 
  {
  
    default:

              $sql_grid = "select e.ins_id as inscricao,to_char(e.ins_data, 'DD/MM/YYYY') as data,evd.owner_tipo,case when evd.owner_tipo in ('A','G') then a.new_as_cod else trim(to_char(v.vis_id,'9900000')) end as numero, 
                            case when evd.owner_tipo in ('A','G') then a.as_nome else v.vis_nome end as nome, g.idcampo||' - '||g.nm_campo||' / '||g.nm_setor as secmp,
                            case when evd.ins_jantar = true then 'SIM' else null end as jantar, v.vis_idade,  
                            CASE evd.owner_tipo 
                                  WHEN 'G' THEN 
                                        case when length(a.as_apelido) > 0 
                                        then trim(a.as_apelido) 
                                        else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
                                        end
                                  WHEN 'A' THEN 
                                        case when length(a.as_apelido) > 0 
                                        then trim(a.as_apelido) 
                                        else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
                                        end      
                                  WHEN 'V' THEN 
                                        case when length(v.vis_apelido) > 0 
                                        then trim(v.vis_apelido) 
                                        else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
                                        end
                                  WHEN 'C' THEN 
                                        case when length(v.vis_apelido) > 0 
                                        then trim(v.vis_apelido) 
                                        else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
                                        end 
                            END as apelido
                            from ev_inscricao e 
                            inner join ev_inscricao_detail evd on e.ins_id = evd.ins_id 
                            left join associado a on evd.owner_id = a.as_cod and a.as_tipo = evd.owner_tipo 
                            left join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $ev_ano 
                            left join visitante v on evd.owner_id = v.vis_id and v.vis_tipo = evd.owner_tipo 
                            where e.ev_id = $ev_id and e.ins_status in ('$insStatus') and evd.owner_tipo in ('$insTipo')
                            order by $insOrder";

                                            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                                            $result = $db->Execute($sql_grid);

                                           // ECHO $sql_grid;

                // Incluimos a classe PHPExcel
                include  '../PHPExcel.php';

                // Instanciamos a classe
                $objPHPExcel = new PHPExcel();

                // Definimos o estilo da fonte
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);


                // Criamos as colunas
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', 'Inscrição' )
                            ->setCellValue('B1', "Data" )
                            ->setCellValue("C1", "Tipo" )
                            ->setCellValue("D1", "Número" )
                            ->setCellValue("E1", "Nome" )
                            ->setCellValue("F1", "Campo" )
                            ->setCellValue("G1", "Jantar" )
                            ->setCellValue("H1", "Criança Idade" )
                            ->setCellValue("I1", "Crachá" );

                 // Podemos configurar diferentes larguras paras as colunas como padrão
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);


                        $i = 2;

                           foreach ($result as $row)
                            { 

                              $temp = $result -> fields;
                              $ins = $temp["inscricao"];
                              $data = $temp["data"];
                              $tp = $temp["owner_tipo"];
                              $num = $temp["numero"];
                              $nome = $temp["nome"];
                              $cmp = $temp["secmp"];
                              $jantar = $temp["jantar"];
                              $idade = $temp["vis_idade"];
                              $primeiroNome = $temp["apelido"];


                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, "$ins");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, "$data");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, "$tp");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, "$num");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, "$nome");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, "$cmp");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, "$jantar");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, "$idade");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, "$primeiroNome");

                        $i++;

                       
                            } //fecha 

                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="ListaInscritos.xls"');
                            header('Cache-Control: max-age=0');

                            // Acessamos o 'Writer' para poder salvar o arquivo
                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

                            // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
                            $objWriter->save('php://output'); 

                            exit;
                      
      break;
  }


   ?>