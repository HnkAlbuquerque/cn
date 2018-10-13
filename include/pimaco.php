<?php
$ev_id = $_SESSION['gsr']['ev_id'];
echo "<input type='hidden' id='ev_id' name='ev_id' value='$ev_id'>";
?>
<script type="text/javascript" src='js/updateInscCracha.js'></script>						
						<h3>Emissão de Etiquetas Pimaco</h3>
						<hr>

						<form method="post">
						<input type='hidden' id='evento' name='evento' value="<?=$ev_id?>">
						<div class="col-md-12">
		              			<div class="col-md-4">
				                    <div class="row">	
				                        <div class="form-group">
								            <label for="exampleInputEmail">Tamanho de etiqueta</label>
								            <div class="form-check">
								              <label class="form-check-label">
								                <input type="radio" class="form-check-input" name="tam_eti" id="tam_eti" value="6281" checked>
								                6281 (25,4 x 101,6)
								              </label>
								            </div>
								            <div class="form-check">
								              <label class="form-check-label">
								                <input type="radio" class="form-check-input" name="tam_eti" id="tam_eti" value="6282">
								                6282 (33,9 x 101,6)
								              </label>
								            </div>
								            <div class="form-check">
								              <label class="form-check-label">
								                <input type="radio" class="form-check-input" name="tam_eti" id="tam_eti" value="A4262">
								                A4262 (33,9 x 99,0)
								              </label>
								            </div>
								            <div class="form-check">
								              <label class="form-check-label">
								                <input type="radio" class="form-check-input" name="tam_eti" id="tam_eti" value="8936">
								                8936 (36,0 x 89,5)
								              </label>
								            </div>
								          </div>                    
				                        </div>
				                    </div> <!-- Fexa row-->

				                <div class="col-md-4">
				                    		<div class="form-group">
								            <div class="row">
								              <div class="col-md-8">
                                                <h6>Margem em milímetros</h6>
                                              </div>
                                             
                                              </div>
								            </div>
								            
								            <div class="form-group">
								            <div class="row">
								              <div class="col-sm-4">
                                                Superior
                                              </div>
                                              <div class="col-sm-4">
                                                <input type='text' name='margin_top' id='margin_top' class="form-control" value='0' />
                                              </div> 
                                              </div>
								            </div>

								            <div class="form-group">
								            <div class="row">
								              <div class="col-sm-4">
                                                Inferior 
                                              </div>
                                              <div class="col-sm-4">
                                                <input type='text' name='margin_bottom' id='margin_bottom' class="form-control" value='0' />
                                              </div> 
                                              </div>
								            </div>

								            <div class="form-group">
								            <div class="row">
								              <div class="col-sm-4">
                                                Direita
                                              </div>
                                              <div class="col-sm-4">
                                                <input type='text' name='margin_right' id='margin_right' class="form-control" value='0' />
                                              </div> 
								            </div>
								            </div>		

								            <div class="form-group">
								            <div class="row">
								              <div class="col-sm-4">
                                                Esquerda
                                              </div>
                                              <div class="col-sm-4">
                                                <input type='text' name='margin_left' id='margin_left' class="form-control" value='0' />
                                              </div> 
								            </div>
								            </div>         
				                </div> 

				                 <div class="col-md-4">
				                    		<div class="form-group">
								            <div class="row">
								              <div class="col-md-8">
                                                <h6>Filtrar por</h6>
                                              </div>
                                             
                                              </div>
								            </div>
								            
								            <div class="form-group">
								            <div class="row">
								            	<div class="col-sm-4">
                                                Tipo 
                                              </div>
								              <div class="col-sm-6">
                                                <select name='f_owner_tipo' id='f_owner_tipo' class="form-control">
														<option value='-' selected='selected'>--Todos--</option>
														<option value='G'>Gide&atilde;o</option>
														<option value='A'>Auxiliar</option>
														<option value='C'>Crian&ccedil;a</option>
														<option value='V'>Visitante</option>
												</select>
                                              </div> 
                                              </div>
								            </div>

								            <div class="form-group">
								            <div class="row">
								              <div class="col-sm-4">
                                                Status 
                                              </div>
                                              <div class="col-sm-6">
                                                <select name='f_ins_status' id='f_ins_status' class="form-control">
															<option value='-' selected='selected'>--Todos--</option>
															<option value='1'>Efetivados</option>
															<option value='0'>N&atilde;o Efetivados</option>
												
												</select>
                                              </div> 
                                              </div>
								            </div>

								            <div class="form-group">
								            	<div class="row">
								              		<div class="col-sm-4">
                                                		Jantar
                                              		</div>
                                              		<div class="col-sm-6">
	                                                <select name='f_ins_jantar' id='f_ins_jantar' class="form-control">
															<option value='-' selected='selected'>--Todos--</option>
															<option value='1'>Com Jantar</option>
															<option value='0'>Sem Jantar</option>
													
													</select>
	                                            	</div> 
								            	</div>
								            </div>

								            <div class="form-group">
								            	<div class="row">
								              		<div class="col-sm-4">
                                                		<b>Ordenar</b>	
                                              		</div>
                                              		<div class="col-sm-6">
	                                                <select name='order' id='order' class="form-control">
														<option value='nome' selected='selected'>nome</option>
														<option value='id.ins_id'>No.Inscrição</option>
													</select>
	                                            	</div> 
								            	</div>
								            </div>			

								                   
				                </div>

				            <hr>


		                  </div>
		                  	<div class="col-md-12">	
		                  		<hr>

			                    <div class="col-md-3">
			                    	<button type="submit" formaction="http://www.gideoes.org.br:8088/ce_new/include/etiqueta_pdf.php" class="btn btn-primary" > Gerar </button>
			                    </div>  

		                    </div>  
						</form>



</div>