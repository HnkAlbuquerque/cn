<?php
/*===========================================================================

 Nome Módulo: inscrições Estaduais


*29/09/2016 - Henrique - encontra valor de inscrição de criança por evento
 
===========================================================================*/
/*require_once('header.php');

$ev_id = $_POST['ev_id'];
$idade = $_POST['idadeChild'];

if (isset($idade)) {

	$result = "select valor::int,idade,aplicacao from ev_evento_options where ev_id = $ev_id and aplicacao = 5 and idade >= $idade order by idade limit 1";
	$sql = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	$sql = $db->Execute($result);
	$temp = $sql -> fields;
		
		echo $temp["valor"];
}
else
{
		echo "0";
}*/

	
	header('Content-Type:' . 'text/plain');
	$host		= "localhost";
	$user		= "postgres";
	$pswd		= "deybacsac4";
	$dbname		= "gideoes";
	$con 		= null;


	$con = pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));

	$idade = filter_input(INPUT_GET, "idadeChild", FILTER_SANITIZE_STRING);
	$ev_id = filter_input(INPUT_GET, "evento_id", FILTER_SANITIZE_STRING);

	if(!$con) {
		echo '[{"erro": "nao foi possivel conectar ao banco"';
		echo '}]';
	}
	else
	{
		
		$sql	= "select valor::int,idade,aplicacao,id as idopt from ev_evento_options where ev_id = $ev_id and aplicacao = 5 and idade >= $idade order by idade limit 1";
                        
                
		$result	= pg_query($sql);
		$n 		= pg_num_rows($result);

		if (!$result)
		{
			echo '[{"erro": "H� algum erro com a busca, N�o retorna resultados"';
			echo '}]';
		}
		else if ($n<1) 
				{
					$dados[0] = 0;
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