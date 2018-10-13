<?php
	
	header('Content-Type:' . 'text/plain');
	$host		= "localhost";
	$user		= "postgres";
	$pswd		= "deybacsac4";
	$dbname		= "gideoes";
	$con 		= null;


	$con = pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));

	$ins_id = filter_input(INPUT_GET, "ins_id", FILTER_SANITIZE_STRING);

	if(!$con) {
		echo '[{"erro": "nao foi possivel conectar ao banco"';
		echo '}]';
	}
	else
	{
		
		$sql = "select at.as_nome,at.info_cracha,at.ins_seq
			from(
			    select a.as_nome,eid.owner_id||'?'||eid.owner_tipo||'?'||eid.ins_id as info_cracha,eid.ins_seq
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            where ei.ins_id = $ins_id  
                            union all 
                            select v.vis_nome,eid.owner_id||'?'||eid.owner_tipo||'?'||eid.ins_id as info_cracha,eid.ins_seq 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id  
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo  
                            where ei.ins_id = $ins_id) as at 
                            order by ins_seq ";

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
				die();
				}

	}

?>