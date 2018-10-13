<?php
	/**
	 * fun��o que devolve em formato JSON os dados do cliente
	 */
	header('Content-Type:' . 'text/plain');
	$host		= "localhost";
	$user		= "postgres";
	$pswd		= "deybacsac4";
	$dbname		= "gideoes";
	$con 		= null;


	$con = pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));

	$new_as_cod = filter_input(INPUT_GET, "new_as_cod", FILTER_SANITIZE_STRING);

	if(!$con) {
		echo '[{"erro": "nao foi possivel conectar ao banco"';
		echo '}]';
	}
	else
	{
		
		$sql	= "select a.new_as_cod,as_nome,regexp_replace(a.as_cpf, '[^0-9]+', '','g')::bigint as as_cpf, 
                        a.as_email,trim(replace(to_char(regexp_replace(nullif(a.as_cep,''), '[^0-9]+', '','g')::bigint,'00000000'),':','.')) as as_cep,
                        case when a.as_tipo = 'G' then 'M' else 'F' end as genero,
                        ig.igr_nome, 
                        case when p.id > 0 then p.id else pp.id end as id, 
                        case when p.valor > 0 then p.valor else pp.valor end as valor, 
                        case when length(p.pg_tipo_id) > 0 then p.pg_tipo_id else pp.pg_tipo_id end as pg_tipo_id, 
                        case when length(ps.status) > 0 then ps.status else pps.status end as status,
                        case when ps.id > 0 then ps.id else pps.id end as idstatus 
                        --p.valor::int,p.pg_tipo_id,ps.id as status_desc,ps.status,p.idterceiro,pp.id,pp.valor,pp.pg_tipo_id,pps.id as status_desc2,pps.status 
                        from associado a 
                        inner join ig_igreja ig on ig.igr_id = a.igr_cod 
                        left join fi_plante p on a.new_as_cod = p.membroid --and p.idstatus = 9 
                        left join fi_plante_status ps on p.idstatus  = ps.id 
                        left join terceiros t on regexp_replace(a.as_cpf, '[^0-9]+', '','g') = regexp_replace(t.ter_cpf, '[^0-9]+', '','g') 
                        left join fi_plante pp on t.ter_id = pp.idterceiro   --and pp.idstatus = 9
                        left join fi_plante_status pps on pp.idstatus  = pps.id 
                        where mot_cod in (1,6,7,8) 
                        and new_as_cod = '$new_as_cod' 
                        order by id desc 
                        limit 1";
                        
                
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