<?php
	
	header('Content-Type:' . 'text/plain');
	$host		= "localhost";
	$user		= "postgres";
	$pswd		= "deybacsac4";
	$dbname		= "gideoes";
	$con 		= null;


	$con = pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));

	$new_as_cod = filter_input(INPUT_GET, "new_as_cod", FILTER_SANITIZE_STRING);
	$new_as_cod = sprintf("%07d",$new_as_cod);

	if(!$con) {
		echo '[{"erro": "nao foi possivel conectar ao banco"';
		echo '}]';
	}
	else
	{
		
		$sql	= "select a.new_as_cod,a.as_nome,a.as_email,aa.new_as_cod as new_as_cod2,aa.as_nome as as_nome2,aa.as_email as as_email2,a.as_tipo,aa.as_tipo as as_tipo2  
                        from associado a 
                        left join associado aa on a.as_conjuge = aa.as_cod and a.as_tipo <> aa.as_tipo and aa.mot_cod in (1,6,7,8) 
                        where a.mot_cod in (1,6,7,8) 
                        and a.new_as_cod = '$new_as_cod' 
                        limit 1 ";
                        
                
		$result	= pg_query($sql);
		$n 		= pg_num_rows($result);

		if (!$result)
		{
			echo '[{"erro": "H� algum erro com a busca, N�o retorna resultados"';
			echo '}]';
		}
		else if ($n<1) 
				{
					$dados[0] = 2;
                                        echo json_encode($dados);
				}
				else
				{
					for($i = 0; $i<$n; $i++)
					{
						$dados[] = pg_fetch_assoc($result, $i);
					}

				echo json_encode($dados);
				
				}

	}

?>