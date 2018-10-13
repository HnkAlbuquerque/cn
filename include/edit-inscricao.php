<?php

  global $db;
  
  $infoEvento = getInfoEvento($_SESSION['gsr']['ev_id'],$_SESSION['gsr']['usr']);
  $ev_id = $_SESSION['gsr']['ev_id'];
  echo "<input type='hidden' value='{$_SESSION['gsr']['ev_id']}' id='evento_id' name='evento_id' readonly><br>";

  if(!isset($_POST['ins_id']))
  {
  	echo "<script>window.location.replace('index.php?page=inscricao');</script>";
  }

?>
  <div class="form-group">
     <div class="row">
        <div class="col-sm-6">
        	<h4>Inscrições Realizadas</h4>
          
        </div>
        <div class="col-sm-4">
          	<h4>Edição de inscrição Nr. <?=$_POST['ins_id']?></h4>
        </div>                                     
      </div>     
  </div>



<style type="text/css">

		.divclass {
		    border: 2px solid #a1a1a1;
		    padding: 10px 40px; 
		   
		    border-radius: 15px;
		}

		.but-success {
		color: #fff;
		background-color: #009835;
		border-radius: 5px;
		box-shadow: 1px 1px 1px #999;

		}

		.disp {
		  display: none;

		}

		.input{
		  background:#ffffff;
		  border:none;

		}

		.is-disabled {
		    background:#ffffff;
		    pointer-events: none;
		    border:none;
		}

		td {
		  padding:0 15px 0 15px;
		  height: 30px;
		}

		.fontval {
		  font-size: 190%;
		  color: red;
		}

		.fontval2 {
		  font-size: 110%;
		  color: red;
		}



</style>
<script>


  $(document).ready(function(){
    
            $("input[name='new_as_cod']").blur(function(){
                                var as_nome = $("input[name='as_nome']");
                                var as_nome2 = $("input[name='as_nome2']");
                                var as_email = $("input[name='as_email']");
                                var as_email2 = $("input[name='as_email2']");
                                var new_as_cod2 = $("input[name='new_as_cod2']");
                                var as_tipo = $("input[name='as_tipo']");
                                var as_tipo2 = $("input[name='as_tipo2']");
                                var new_as_cod = $("input[name='new_as_cod']");
                                var globalJ;

                                $( as_nome ).val('Carregando...');

                                $.getJSON(
                                  'dados/carregaDadosEdit.php',
                                  { new_as_cod: $( this ).val() },
                                  function( json )
                                  {
                                                                        
                                                                        globalJ = json;
                                                                        as_nome.val( globalJ[0].as_nome );
                                                                        new_as_cod.val( globalJ[0].new_as_cod );
                                  }
                                                            
                                ).always(function(){
                                                                    if (globalJ[0] != 2)
                                                                    {   

                                                                        as_email.val( globalJ[0].as_email );
                                                                        as_email2.val( globalJ[0].as_email2 );
                                                                        as_nome2.val( globalJ[0].as_nome2 );
                                                                        new_as_cod2.val( globalJ[0].new_as_cod2 );
                                                                        as_tipo.val( globalJ[0].as_tipo );
                                                                        as_tipo2.val( globalJ[0].as_tipo2 );

                                                                    }
                                                                    else
                                                                    {
                                                                      as_email.val( globalJ[0].as_email );
                                                                        as_email2.val( globalJ[0].as_email2 );
                                                                        as_nome2.val( globalJ[0].as_nome2 );
                                                                        new_as_cod2.val( globalJ[0].new_as_cod2 );
                                                                        as_tipo.val( globalJ[0].as_tipo );
                                                                        as_tipo2.val( globalJ[0].as_tipo2 );
                                                                        
                                                                        alert("Numero de membro não encontrado");
                                                                    }
                           
                                                    });
                                   
                                    });

            $("input[name='idadeChild']").keyup(function(){
                                var valorInscricaoC = $("input[name='valorInscricaoC']");
                                var idCriancaEvOpt = $("input[name='idCriancaEvOpt']");
                                var idade = $("input[name='idadeChild']");
                                var globalJ;
                                var insHotel = $("input[name='idEventoOption']");


                                $.getJSON(
                                  'dados/findchildvalue.php',
                                  { idadeChild: $( this ).val(), evento_id: $( "#evento_id" ).val() },
                                  function( json )
                                  {
                                                                        
                                                                        globalJ = json;
                                  }
                                            
                                ).always(function(){
                                                    if (globalJ[0] != 0)
                                                    {   

                                                        valorInscricaoC.val( globalJ[0].valor );
                                                        idCriancaEvOpt.val( globalJ[0].idopt );

                                                    }
                                                    else
                                                    {

                                                      if (insHotel.val() != 'null')
                                                      {
                                                          
                                                      }
                                                      else
                                                      {
                                                        alert("Essa idade não é permitida para os eventos infanto juvenis desta Convenção.");
                                                        valorInscricaoC.val( 0 );
                                                        idade.val(null);
                                                      }                                               
                                                    }
           
                                    });
                                  });

            $("button[name='botaoBuscaMembro']").on('click',function(){
              

              var buscaMembro = $("input[name='buscaMembro']");

                      $.getJSON( // inicia carregamento da primeira lista (lista de inscritos)
                      'dados/carregaMembrosBusca.php',
                      { buscaMembro: $( buscaMembro ).val() },
                      function( json )
                      {

                                                            globalJ = json;
                                                            
                      }).always(function(){
                                                        if (globalJ[0] != 2)
                                                        {   

                                                          //as_nome.val( globalJ[0].as_nome );
                                                          tableLinhas = globalJ.length;
                                                          var table = document.getElementById("buscaMembroTable");

                                                          for (var i = 0; i < tableLinhas; i++)
                                                          {

                                                              var row = table.insertRow(table.length);
                                                              var cell1 = row.insertCell(0);
                                                              var cell2 = row.insertCell(1);
                                                              var cell3 = row.insertCell(2);
                                                              

                                                              cell1.innerHTML = globalJ[i].new_as_cod;
                                                              cell2.innerHTML = globalJ[i].as_nome;
                                                              cell3.innerHTML = globalJ[i].campo;

                                                              
                                                          }

                                                          $('table tbody tr').on('click',function(){

                                                          var a = $(this).closest('tr').find('td').eq(0).text();
                                                          document.getElementById('new_as_cod').value = a;
                                                          document.getElementById('new_as_cod').focus();
                                                          $("#modalSearch").modal('toggle');


                                                          });

                                                        }
                                                        else
                                                        {
                                                            
                                                            alert("Membro não encontrado");
                                                        }
               
                                        }); // finaliza preenchimento da lista de inscritos

                      
                                    });

     });

</script>

<?php

    $sql = "select evo.aplicacao ,(select evo.aplicacao 
            from ev_evento_options evo 
            where ev_id = $ev_id and evo.aplicacao > 0 
            order by evo.aplicacao limit 1) as aplicacao2 
            from ev_evento_options evo 
            where ev_id = $ev_id  
            order by evo.aplicacao limit 1";

        $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $db->Execute($sql);
        $temp = $result -> fields;
        
            $sqlvalor = "select coalesce((select evo.valor::int 
              from ev_evento_options evo 
              where ev_id = $ev_id and evo.aplicacao = 1 
              order by evo.aplicacao limit 1),0) as jantar,
              coalesce((select evo.valor::int 
              from ev_evento_options evo  
              where ev_id = $ev_id and evo.aplicacao = 2 
              order by evo.aplicacao limit 1),0) as inscricaog, 
              coalesce((select evo.valor::int 
              from ev_evento_options evo 
              where ev_id = $ev_id and evo.aplicacao = 3 
              order by evo.aplicacao limit 1),0) as inscricaoa, 
              coalesce((select evo.valor::int 
              from ev_evento_options evo 
              where ev_id = $ev_id and evo.aplicacao = 4 
              order by evo.aplicacao limit 1),0) as almoco, 
              coalesce((select evo.valor::int  
              from ev_evento_options evo  
              where ev_id = $ev_id and evo.aplicacao = 6 
              order by evo.aplicacao limit 1),0) as inscricaov,
              coalesce((select evo.valor::int  
              from ev_evento_options evo  
              where ev_id = $ev_id and evo.aplicacao = 10 
              order by evo.aplicacao limit 1),0) as transporte,
              coalesce((select evo.valor::int  
              from ev_evento_options evo  
              where ev_id = $ev_id and evo.aplicacao = 7 and evo.option_valid = true 
              order by evo.aplicacao limit 1),0) as descontoi,
              coalesce((select evo.valor::int  
              from ev_evento_options evo  
              where ev_id = $ev_id and evo.aplicacao = 8 and evo.option_valid = true 
              order by evo.aplicacao limit 1),0) as descontoj";
            
              $result2 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
              $result2 = $db->Execute($sqlvalor);
              $valores = $result2 -> fields;

              echo "<input type='hidden' name='valorJantar' id='valorJantar' value='{$valores['jantar']}' readonly>";
              echo "<input type='hidden' name='valorAlmoco' id='valorAlmoco' value='{$valores['almoco']}' readonly>";
              echo "<input type='hidden' name='valorTransporte' id='valorTransporte' value='{$valores['transporte']}' readonly>";
              echo "<input type='hidden' name='valorInscricaoG' id='valorInscricaoG' value='{$valores['inscricaog']}' readonly>";
              echo "<input type='hidden' name='valorInscricaoA' id='valorInscricaoA' value='{$valores['inscricaoa']}' readonly>";
              echo "<input type='hidden' name='valorInscricaoV' id='valorInscricaoV' value='{$valores['inscricaov']}' readonly>";
              echo "<input type='hidden' name='descontoInscricao' id='descontoInscricao' value='{$valores['descontoi']}' readonly>";
              echo "<input type='hidden' name='descontoJantar' id='descontoJantar' value='{$valores['descontoj']}' readonly>";
              echo "<input type='hidden' name='valorInscricaoC' id='valorInscricaoC' value=''>";
              echo "<input type='hidden' name='idCriancaEvOpt' id='idCriancaEvOpt' value=''>";
              echo "<script type='text/javascript' src='js/insc-normal.js'></script>";
        


//INICIO DIV
?>
<div id="non-printable"> 

  <form method="post">
  <input type="hidden" name="ins_id" value="<?=$_POST['ins_id']?>">

  <div class="row">
	    <div class="col-md-12">
	    		<table id="tabelaEdit" class="table table-striped">
			          <tr>
			            <th width="10%">Número</th>
			            <th>Nome</th>
			            <th>Jantar</th>
                  <th>Almoço</th>
                  <th>Transporte</th>
			            <th>Apagar</th>
			          </tr>
			          <?php

			          		$insc = getInsIndividual($_POST['ins_id']);
			          		$i = 1;
			          		foreach ($insc as $row) 
			          		{
			          			$temp = $insc -> fields;

			          			echo "<tr>
				          				<td>
				          					{$temp['new_as_cod']}
				          				</td>
				          				<td>
				          					{$temp['nome']}
				          				</td>
				          				<td>
				          					{$temp['jantartexto']}
				          				</td>
                          <td>
                            {$temp['almocotexto']}
                          </td>
                          <td>
                            {$temp['transportetexto']}
                          </td>
				          				<td>
				          					<button type='button' onclick='deleteRow(this.parentNode.parentNode.rowIndex);'>Apagar</button>
				          					<input type='hidden' name='inscDetailInfo_$i' value='{$temp['owner_id']}?{$temp['owner_tipo']}?{$temp['ins_jantar']}?{$temp['vis_idade']}?{$temp['ins_pastor']}?{$temp['ins_almoco']}?{$temp['ins_transporte']}?{$temp['ins_preletor']}'>
				          				</td>
				          			</tr>
			          			";	

			          			$i++;
			          		}

                    $i = $i-1;

                    echo "<input type='hidden' name='qdeLinhas' value='$i'>";

	          			?>
	          	</table>


	          	
	          			
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
		        <table id="ficha" class="table table-striped">
		          <tr>
		            <th width="10%">Número</th>
		            <th>Nome</th>
		            <th>Jantar</th>
                <th>Almoço</th>
                <th>Transporte</th>
                <th>Mensageiro</th>
		            <th></th>
		          </tr>
		        </table>
		    </div>
		    </br>
	        </table>
		</div>
	</div>

	<hr>
	<div class="row">	
	    <div class="table-responsive col-md-3" align="center"> 
	          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMembro">Adicionar Membro</button>
	    </div>
	    <div class="table-responsive col-md-3" align="center"> 
	          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVis">Adicionar Visitante</button>
	    </div>
	    <div class="table-responsive col-md-3" align="center"> 
	          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTeen">Adicionar Crianças/Jovens </button>
	    </div>

	</div>

	              
 
 
  <hr>
          	 <div style='display:none'>
                <div class="table-responsive col-md-4">
                <table class="table table-striped">
                    <tr>
                      <th>Valor total</th>
                    </tr>
                    <tr>
                      <td>
                        <?php
                            if (isset($_POST["idEvOpt"]))
                            {
                              echo "<p class='fontval2' align='right'>R$ <input type='text' name='valorTotal' id='valorTotal' value='{$tempEvOpt['valorint']}' size='3' style='text-align:right;' class='is-disabled fontval'>,00</p>";
                            }
                            else
                            {
                              echo "<p class='fontval2' align='right'>R$ <input type='text' name='valorTotal' id='valorTotal' value='0' size='2' style='text-align:right;' class='is-disabled fontval'>,00</p>";
                            }
                        ?>
                      </td>
                    </tr>
                </table> 
                </div>
              
                <div class="table-responsive col-md-4">
                <table class="table table-striped">
                    <tr>
                      <th>Desconto</th>
                    </tr>
                    <tr>
                      <td>
                       <p class='fontval2' align='right'>R$ <input type='text' name='desconto' id='desconto' value='0' size='2' style='text-align:right;' class='is-disabled fontval'>,00</p>
                      </td>
                    </tr>
                </table> 
                </div>
             

              
                <div class="table-responsive col-md-4">
                <table class="table table-striped">
                    <tr>
                      <th>Total a pagar</th>
                    </tr>
                    <tr>
                      <td>
                       <p class='fontval2' align='right'>R$ <input type='text' name='totalPG' id='totalPG' value='0' size='2' style='text-align:right;' class='is-disabled fontval'>,00</p>
                      </td>
                    </tr>
                </table> 
                </div>
          		</br>
          	</div>
        

        <div class="row">

        	<div class="col-md-3">
        		 
        	</div>
        	<div class="table-responsive col-md-3" align="center">
        		<button type='submit' class='btn btn-primary' formaction='index.php?page=inscricao'> Voltar </button> 
        	</div>

        	<div class="table-responsive col-md-3" align="center">
        		 <input type='hidden' name='idEventoOption' id='idEventoOption' value='null' readonly>
                 <button type='submit' class='btn btn-primary' formaction='index.php?page=finalizar-edicao'> - CONCLUIR EDIÇÃO - </button> 
        	</div>
        	<div class="col-md-3">
        		 
        	</div>
        	
        </div>
        

        <hr> 

        <input type="hidden" value="0" id="lines" name="lines">
        <input type="hidden" value="1" id="repeat" name="repeat">
        <input type="hidden" value="0" id="linesPG" name="linesPG">

        </form>
</div>


        


  
            <!-- Modal Membro -->
                <div class="modal fade" id="modalMembro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Nova Inscrição de Membro</h4>
                                  </div>
                                  <div class="modal-body">

                                        <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-4">
                                                Número de Membro
                                              </div>
                                              <div class="col-sm-4">
                                                <input type="text" name="new_as_cod" id="new_as_cod" maxlength="7" class="form-control" size="7" placeholder="7 Dígitos" onkeypress="return isNumber(event)">
                                                  <input type="hidden" name="as_tipo" id="as_tipo" maxlength="1" class="form-control" size="1">
                                              </div>
                                              <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSearch"><span class="glyphicon glyphicon-search"></span> </button>
                                              </div> 
                                            </div>     
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-4">
                                                Nome
                                              </div>
                                              <div class="col-sm-8">
                                                <input type="text" name="as_nome" id="as_nome" maxlength="60" class="form-control" size="45" disabled>
                                              </div>
                                            </div>     
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-4">
                                                Email
                                              </div>
                                              <div class="col-sm-8">
                                                <input type="text" name="as_email" id="as_email" maxlength="60" class="form-control" size="38" disabled>
                                              </div>
                                            </div>     
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-6">
                                                Como quer ser chamado(a)?
                                              </div>
                                              <div class="col-sm-6">
                                                <input type="text" id="aliasMem1" maxlength="30" class="form-control" size="20">
                                              </div>
                                            </div>     
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-6">
                                                O conjuge estará presente?
                                              </div>
                                              <div class="col-sm-6">
                                                <input type="radio" id="conjS" name="conj" value="1" onclick="exibe('conjuge');exibe('jantCas');"> Sim <br>
                                                <input type="radio" id="conjN" name="conj" value="2" onclick="disexibe('conjuge');disexibe('jantCas');" checked> Não
                                              </div>
                                            </div>     
                                        </div>
    
                                      <hr>
                                      <div id="conjuge" style='display:none'>

                                              <div class="form-group">
                                                  <div class="row">
                                                    <div class="col-sm-4">
                                                      Número de Membro
                                                    </div>
                                                    <div class="col-sm-4">
                                                      <input type="text" name="new_as_cod2" id="new_as_cod2" maxlength="7" class="form-control" size="7" disabled>
                                                        <input type="hidden" name="as_tipo2" id="as_tipo2" maxlength="1" class="form-control" size="1">
                                                    </div>
                                                  </div>     
                                              </div>

                                              <div class="form-group">
                                                  <div class="row">
                                                    <div class="col-sm-4">
                                                      Nome
                                                    </div>
                                                    <div class="col-sm-8">
                                                      <input type="text" name="as_nome2" id="as_nome2" maxlength="60" class="form-control" size="45" disabled>
                                                    </div>
                                                  </div>     
                                              </div>

                                              <div class="form-group">
                                                  <div class="row">
                                                    <div class="col-sm-4">
                                                      Email
                                                    </div>
                                                    <div class="col-sm-8">
                                                      <input type="text" name="as_email2" id="as_email2" maxlength="60" class="form-control" size="38" disabled>
                                                    </div>
                                                  </div>     
                                              </div>

                                              <div class="form-group">
                                                  <div class="row">
                                                    <div class="col-sm-6">
                                                      Como quer ser chamado(a)?
                                                    </div>
                                                    <div class="col-sm-6">
                                                      <input type="text" id="aliasMem2" maxlength="30" class="form-control" size="20">
                                                    </div>
                                                  </div>     
                                              </div>

                                              

                                              <div style='display:none' class="form-group">
                                                <div class="row">
                                                  <div class="col-sm-6">
                                                    Opções para o Jantar com pastores: 
                                                  </div>
                                                  <div class="col-sm-6">
                                                    <input type='radio' id='jantInd' name='jant' value='1' checked> Jantar Individual <br>
                                                    <input type='radio' id='jantCas' name='jant'  value='2'> Jantar Casal
                                                  </div>
                                                </div>     
                                              </div>
      
                                      </div>          
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="adicionaLinha()">Incluir na Ficha</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <!-- Fecha modal -->

                <!-- Modal Visitante -->
                <div class="modal fade" id="modalVis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Nova Inscrição de Visitante</h4>
                                  </div>

                                  <div class="modal-body">

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-4">
                                              Nome
                                            </div>
                                            <div class="col-sm-8">
                                              <input type="text" id="nomeVis" maxlength="60" class="form-control" size="45">
                                            </div>
                                          </div>     
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-6">
                                              Como quer ser chamado(a)?
                                            </div>
                                            <div class="col-sm-6">
                                              <input type="text" id="aliasVis" maxlength="60" class="form-control" size="38">
                                            </div>
                                          </div>     
                                      </div>

                                      <hr>

                                          <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-6">
                                                Informe o sexo: 
                                              </div>
                                              <div class="col-sm-6">
                                                <input type="radio" id="genderM" name="gender" value="M" checked> Masculino <br>
                                              <input type="radio" id="genderF" name="gender" value="F"> Feminino
                                              </div>
                                            </div>     
                                          </div>

                                      <hr>

                                          <div class="form-group">
                                            <div class="row">
                                              <div class="col-sm-6">
                                                É Pastor(a)? 
                                              </div>
                                              <div class="col-sm-6">
                                                <input type="radio" id="pastS" name="past" value="1"> Sim <br>
                                                <input type="radio" id="pastN" name="past" value="0" checked> Não
                                              </div>
                                            </div>     
                                        </div>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="adicionaVis();">Incluir na Ficha</button>
                                  </div>
                                </div>
                              </div>
                </div>
                        <!-- Fecha modal -->

                        <!-- Modal Teen -->
                <div class="modal fade" id="modalTeen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Nova Inscrição de Criança / Adolescente</h4>
                                  </div>
                                  <div class="modal-body">

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-2">
                                              Nome
                                            </div>
                                            <div class="col-sm-7">
                                              <input type="text" id="nomeChild" maxlength="60" class="form-control" size="45">
                                            </div>
                                          </div>     
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-2">
                                              Idade
                                            </div>
                                            <div class="col-sm-3">
                                              <input type="text" id="idadeChild" name="idadeChild" maxlength="2" class="form-control" size="3" onkeypress='validate(event)'>
                                            </div>
                                          </div>     
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-5">
                                              Como quer ser chamado(a)?
                                            </div>
                                            <div class="col-sm-5">
                                              <input type="text" id="aliasChild" maxlength="30" class="form-control" size="30">
                                            </div>
                                          </div>     
                                      </div>
                                      <hr>
                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              Em caso de FEBRE, pode tomar medicamentos ?
                                            </div>
                                          </div>     
                                      </div>
                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-2">   
                                              <input type="radio" id="febreN" name="febre" aria-label="..." checked>Não
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="radio" id="febreS" name="febre" aria-label="...">Sim
                                            </div>
                                            <div class="col-sm-8">
                                              <input type="text" id="febreDesc" class="form-control" aria-label="..." placeholder="Se SIM, Descreva qual(is).">
                                            </div>    
                                          </div><!-- /.col-lg-6 -->
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              Possui algum tipo de ALERGIA ?
                                            </div>
                                          </div>     
                                      </div>
                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-2">   
                                              <input type="radio" id="alergiaN" name="alergia" aria-label="..." checked>Não
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="radio" id="alergiaS" name="alergia" aria-label="...">Sim
                                            </div>
                                            <div class="col-sm-8">
                                              <input type="text" id="alergiaDesc" class="form-control" aria-label="..." placeholder="Se SIM, Descreva a que.">
                                            </div>    
                                          </div><!-- /.col-lg-6 -->
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              Possui alguma RESTRIÇÃO ALIMENTAR ?
                                            </div>
                                          </div>     
                                      </div>
                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-2">   
                                              <input type="radio" id="restricaoN" name="restricao" aria-label="..." checked>Não
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="radio" id="restricaoS" name="restricao" aria-label="...">Sim
                                            </div>
                                            <div class="col-sm-8">
                                              <input type="text" id="restricaoDesc" class="form-control" aria-label="..." placeholder="Se SIM, Descreva qual(is).">
                                            </div>    
                                          </div><!-- /.col-lg-6 -->
                                      </div>


                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" onclick="adicionaChild();" data-dismiss="modal">Incluir na Ficha</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <!-- Fecha modal -->

                        <!-- Modal Visitante -->
                <div class="modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteRowModal('buscaMembroTable');"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Busca de Membros</h4>
                                  </div>

                                  <div class="modal-body">

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              A busca pode ser feita por <b>Nome, Campo, Número de Membro e CPF</b>.
                                            </div>
                                          </div>     
                                      </div>

                                      <div class="form-group">
                                          <div class="row">
                                            <div class="col-sm-4">
                                              <input type="text" id="aliasVis" maxlength="60" class="form-control" size="38" name="buscaMembro" id="buscaMembro">
                                            </div>
                                            <div class="col-sm-4">
                                              <button type="button" class="btn btn-primary" name="botaoBuscaMembro" id="botaoBuscaMembro" onclick="deleteRowModal('buscaMembroTable');"> Buscar </button>
                                            </div>
                                          </div>     
                                      </div>

                                      <div style="overflow: scroll; z-index:5; height: 200px;">
                                        <table class="table table-hover" name="buscaMembroTable" id="buscaMembroTable" style="font-size: 12px">
                                          <th>Número</th>
                                          <th>Nome</th>
                                          <th>Campo</th>
                                        </table>
                                      </div>

                                          
                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteRowModal('buscaMembroTable');">
                                      Já encontrei
                                    </button>
                                  </div>
                                </div>
                              </div>
                </div>
