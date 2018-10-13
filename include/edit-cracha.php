<?php
        
        $j = returnQdeIns($_POST['ins_id']);
        //echo $_POST['ins_id'];
        
?>      
    <h3>Editar Crachá</h3>
    <hr>  



    <?php
    if(isset($_POST['editAction']) and $_POST['editAction'] == 1)
    {

        for ($i=1; $i <= $j  ; $i++) {

            
            if (isset($_POST["editCrachaId_$i"]) and $_POST["editCrachaId_$i"] > 0 ) 
            {
                
                $message = updateCrachaNome($_POST["editCrachaTipo_$i"],$_POST["editCrachaId_$i"],$_POST["editCracha_$i"]);
                ?>
                <div class="col-md-6">   
                    <div class="form-group">
                        <div class="row">               
                            <div class="col-md-6">
                                <h5><?=$message?></h5>
                            </div>            
                        </div>     
                    </div>
                </div>
                <?php

            }
            

        }
        ?>
        <div class="col-md-12">   
                <hr>
                 <div id="printableArea" class="col-md-6" style="overflow: scroll; z-index:5; height: 250px;">
                                <?php
                                for ($i=1; $i <= $j  ; $i++) 
                                { 
                                        
                                    switch ($_POST["editCrachaTipo_$i"]) 
                                    {
                                        case 'G':
                                        case 'A':
                                       // echo "<br> case A or G ok";
                                            $info = getInscricaoGeneric($_POST['ins_id'],$_POST["editCrachaTipo_$i"],$_POST["editCrachaId_$i"]);

                                        echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['ins_transporte'],$info['as_apelido'],$info['campo'],$info['ref'],$info['as_nome']);
                                        
                                           // updateCracha($pieces[2],$pieces[1],$pieces[0]);
                                            

                                            break;

                                        case 'C':
                                            $info = getInscricaoGeneric($_POST['ins_id'],$_POST["editCrachaTipo_$i"],$_POST["editCrachaId_$i"]);

                                        echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['ins_transporte'],$info['vis_apelido'],$info['resp'],$info['ref'],$info['vis_nome']);

                                          //  updateCracha($pieces[2],$pieces[1],$pieces[0]);

                                            break;

                                        case 'V':
                                            $info = getInscricaoGeneric($_POST['ins_id'],$_POST["editCrachaTipo_$i"],$_POST["editCrachaId_$i"]);

                                        echo imprimeCracha($_SESSION['gsr']['ev_cracha'],$info['ins_transporte'],$info['vis_apelido'],$info['vis'],$info['ref'],$info['vis_nome']);

                                           // updateCracha($pieces[2],$pieces[1],$pieces[0]);

                                            break;
                                        
                                        default:
                                            # code...
                                            break;
                                    }
                                }

                                ?>
                        </div>                
        </div>
                <div class="table-responsive col-md-6" align="center">
                    <hr>
                    <span align="center">
                            <button class="btn btn-primary" onclick="printDiv('printableArea');"> - Imprimir Crachá - </button>
                    </span>
                    
                </div>
                <div class="table-responsive col-md-6" align="center">
                    <hr>
                    <span align="center">
                        <a href="index.php?page=inscricao">
                            <button class="btn btn-primary"> Voltar </button>
                        </a>
                            
                    </span>
                </div>



                


        <?php

    }
    else
    {
    ?>    

    <form method="post">
    <input type="hidden" name="ins_id" value="<?=$_POST['ins_id']?>">

                                    <div id="printableArea" class="col-md-10">
                                        <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-2">
                                                <h5>Inscrição</h5>
                                              
                                            </div>
                                            <div class="col-md-6">
                                            <h5>Nome</h5>
                                              
                                            </div>
                                            <div class="col-md-4">
                                            <h5>Nome no Crachá</h5>
                                              
                                            </div>
                                          </div>     
                                      </div>
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

                                    ?>

                                     <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-2">
                                              <?=$info['ins_id']?>
                                            </div>
                                            <div class="col-md-6">
                                              <?=$info['as_nome']?>
                                            </div>
                                            <div class="col-md-4">
                                              <input type="text" id="editCracha_<?=$i?>" name="editCracha_<?=$i?>" class="form-control" value="<?=$info['as_apelido']?>">
                                              <input type="hidden" id="editCrachaTipo_<?=$i?>" name="editCrachaTipo_<?=$i?>" class="form-control" value="<?=$pieces[1]?>">
                                              <input type="hidden" id="editCrachaId_<?=$i?>" name="editCrachaId_<?=$i?>" class="form-control" value="<?=$pieces[0]?>">
                                            </div>
                                          </div>     
                                      </div>

                                    <?php

                                    break;

                                case 'C':
                                case 'V':

                                    $info = getInscricaoGeneric($pieces[2],$pieces[1],$pieces[0]);

                                    ?>

                                     <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-2">
                                              <?=$info['ins_id']?>
                                            </div>
                                            <div class="col-md-6">
                                              <?=$info['vis_nome']?>
                                            </div>
                                            <div class="col-md-4">
                                              <input type="text" id="editCracha_<?=$i?>" name="editCracha_<?=$i?>" class="form-control" value="<?=$info['vis_apelido']?>">
                                              <input type="hidden" id="editCrachaTipo_<?=$i?>" name="editCrachaTipo_<?=$i?>" class="form-control" value="<?=$pieces[1]?>">
                                              <input type="hidden" id="editCrachaId_<?=$i?>" name="editCrachaId_<?=$i?>" class="form-control" value="<?=$pieces[0]?>">
                                            </div>
                                          </div>     
                                      </div>

                                    <?php

                                    break;

                            } // fecha switch

                        } // fecha if
                    } // fecha for

                    ?>
                </div>

                

                
                <div id="non-printable" class="table-responsive col-md-12">
                <hr>   
                
                
                <input type="hidden" name="editAction" value="1">
                    <div class="table-responsive col-md-6" align="center">
                            <a href="index.php?page=inscricao"> 
                                <button type="button" class="btn btn-primary"> - Voltar - </button>
                            </a>          
                    </div>

                    <div class="table-responsive col-md-6" align="center">
                                <button type="submit" formaction="index.php?page=edit-cracha" class="btn btn-primary"> - Salvar Alterações - </button>
                    </div>
                

                    
                </div>
    </form>

    <?php
    } // fecha else
    ?>
                