<?php
        
        $j = returnQdeIns($_POST['ins_id']);
        //echo $_POST['ins_id'];
        
?>        

                <div id="printableArea" class="col-md-6" style="overflow: scroll; z-index:5; height: 400px;">
                    <?php

                    for ($i=1; $i <= $j  ; $i++) { 

                       // echo "<br>for ok";
                        if($_POST["cracha_$i"] == true)
                        {
                            //echo "<br>if ok";
                            $pieces = explode("?", $_POST["info_$i"]);
                            //echo $pieces[0].$pieces[1].$pieces[2];
                            switch ($pieces[1]) {
                                case 'G':
                                case 'A':
                               // echo "<br> case A or G ok";
                                    $info = getInscricaoGeneric($pieces[2],$pieces[1],$pieces[0]);

                                    echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['transporte'],$info['as_apelido'],$info['campo'],$info['ref'],$info['as_nome']);
                                
                                    updateCracha($pieces[2],$pieces[1],$pieces[0]);
                                    

                                    break;

                                case 'C':
                                    $info = getInscricaoGeneric($pieces[2],$pieces[1],$pieces[0]);

                                    echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['transporte'],$info['vis_apelido'],$info['resp'],$info['ref'],$info['vis_nome']);

                                    updateCracha($pieces[2],$pieces[1],$pieces[0]);

                                    break;

                                case 'V':
                                    $info = getInscricaoGeneric($pieces[2],$pieces[1],$pieces[0]);

                                    echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['transporte'],$info['vis_apelido'],$info['vis'],$info['ref'],$info['vis_nome']);

                                    updateCracha($pieces[2],$pieces[1],$pieces[0]);

                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }

                        }
                    }

                    ?>
                </div>

                

                <div id="non-printable" class="table-responsive col-md-12">
                <hr>

                    <div id="non-printable" class="table-responsive col-md-6" align="center">
                                <button class="btn btn-primary" onclick="printDiv('printableArea');"> - Imprimir Crachá - </button>
                    </div>

                    <div id="non-printable" class="table-responsive col-md-6" align="center">
                            <a href="index.php?page=inscricao"> 
                                <button type="button" class="btn btn-primary"> - Voltar - </button>
                            </a>
                                
                    </div>

                </div>