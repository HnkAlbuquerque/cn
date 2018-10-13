<?php
	
	header('Content-Type:' . 'text/plain');
	$host		= "localhost";
	$user		= "postgres";
	$pswd		= "deybacsac4";
	$dbname		= "gideoes";
	$con 		= null;

	$ano = date('Y');
	$testeMes = date('m');

	if ($testeMes < 6)
	{
		$geoperiodo = $ano -1;
		$ano = $ano-1;
	}
	else
	{
		$geoperiodo = $ano;
		$ano = $ano;
	}



	$con = pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));

	$parametro = filter_input(INPUT_GET, "buscaMembro", FILTER_SANITIZE_STRING);

	if(!$con) {
		echo '[{"erro": "nao foi possivel conectar ao banco"';
		echo '}]';
	}
	else
	{

		if( $parametro > 0 )
		{
				$sql = "select a.new_as_cod, a.as_nome, a.cmp_cod||' - '||g.nm_campo as campo, a.as_cpf 
						from associado a 
						inner join geo.geografia g on g.idcampo = a.cmp_cod and g.periodo = $geoperiodo 
						where a.mot_cod in (1,6,7,8) and (a.cmp_cod::bigint = '$parametro') or (a.as_cpf = '$parametro') or (a.as_nome ilike '%$parametro%') or (a.new_as_cod = '$parametro') 
						order by a.as_nome"; 
		}
		else
		{
				$sql = "select a.new_as_cod, a.as_nome, a.cmp_cod||' - '||g.nm_campo as campo
				from associado a
				inner join geo.geografia g on g.idcampo = a.cmp_cod and g.periodo = $geoperiodo 
				where a.mot_cod in (1,6,7,8) and (a.as_cpf = '$parametro') or (a.as_nome ilike '%$parametro%') or (a.new_as_cod ilike '%$parametro%') 
				order by a.as_nome";
		}
		
		

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