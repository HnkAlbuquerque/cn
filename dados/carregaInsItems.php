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
		
		$sql	= "select at.descricao,at.quantidade,at.valor 
						from (		 
                            select eeo.descricao,eio.quantidade,eio.quantidade * eio.vr_unitario as valor 
                            from ev_inscricao_options eio 
                            inner join ev_evento_options eeo on eio.opt_id = eeo.id 
                            where ins_id = $ins_id 
                            union all 
                            select at2.total,at2.nada,sum(at2.total_vr) as total
							from (
								    select 'Total' as total,0 as nada,sum(eio.quantidade * eio.vr_unitario) as total_vr 
								    from ev_inscricao_options eio 
								    inner join ev_evento_options eeo on eio.opt_id = eeo.id 
								    where ins_id = $ins_id 
								    group by total, nada 
								    union all
								    select 'Total' as total,0 as nada,sum(eio.quantidade * eio.vr_unitario)*-1 as total_vr 
								    from ev_inscricao_options eio 
								    inner join ev_evento_options eeo on eio.opt_id = eeo.id 
								    where ins_id = $ins_id and eeo.aplicacao in (7,8)
								    group by total, nada ) as at2
								    group by at2.total,at2.nada 
								) as at  ";
                        
                
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