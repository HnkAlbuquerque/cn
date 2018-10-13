<?php

	function getInfoEvento($evento,$usuario=null)
	{
		global $db;

		if ($usuario == 'sedenacional')
		{

		}
		else
		{

			$qry = "select 'De '||to_char(ev_dt_ini,'DD/MM/YYYY') || ' a '|| to_char(ev_dt_fim,'DD/MM/YYYY') as ev_dt, ev_nome, 'N' as tp, to_char(ev_dt_ini,'DD/MM/YYYY') as dtini, to_char(ev_dt_fim,'DD/MM/YYYY') as dtfim,to_char(ev_dt_ini,'DD') as evdiaini, to_char(now(),'DD/MM/YYYY') as dthoje,  to_char(ev_dt_fim,'DD') as evdiafim , to_char(ev_dt_fim,'MM')::int as evmesfim, to_char(ev_dt_fim,'YYYY') as evano 
					from ev_evento 
					where ev_id = $evento";
			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	       	$result = $db->Execute($qry);
	        $temp = $result -> fields;
	        return $temp;
	    }
	}

	function getStringMes($mes)
	{
		switch ($mes) {
			case '1':
				$mesNome = "Janeiro";
				break;
			case '2':
				$mesNome = "Fevereiro";
				break;
			case '3':
				$mesNome = "Março";
				break;
			case '4':
				$mesNome = "Abril";
				break;
			case '5':
				$mesNome = "Maio";
				break;
			case '6':
				$mesNome = "Junho";
				break;
			case '7':
				$mesNome = "Julho";
				break;
			case '8':
				$mesNome = "Agosto";
				break;
			case '9':
				$mesNome = "Setembro";
				break;
			case '10':
				$mesNome = "Outubro";
				break;
			case '11':
				$mesNome = "Novembro";
				break;
			case '12':
				$mesNome = "Dezembro";
				break;
			
		}

		return $mesNome;
	}

	function getInscricaoList($evento)
	{
		global $db;

		$qry = "SELECT DISTINCT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_credencial, i.ins_status,
			trim(c.cmp_nome)||' / '||c.cmp_estado as campo, d.ins_preletor, d.ins_pastor, a.mot_cod, i.pg_tipo_id,
		    v.vis_idade_tp as idade_tp, v.vis_idade as idade, d.valor_transporte as transporte, 
			CASE d.owner_tipo
				WHEN 'G' THEN a.as_nome
				WHEN 'A' THEN a.as_nome
				WHEN 'C' then v.vis_nome
				WHEN 'V' then v.vis_nome
			END as nome,
			CASE 
				WHEN d.owner_tipo='G' OR d.owner_tipo='A' THEN a.as_apelido
				WHEN d.owner_tipo='C' OR d.owner_tipo='V' then v.vis_apelido
			END as cracha,
		        CASE WHEN d.valor_almoco > 0 THEN 1 ELSE 0 END as ins_almoco,
		        case when i.owner_login ilike '00%' or i.owner_login ilike '01%' then 1 else 0 end as ins_web, 
		        case when eeo.aplicacao = 0 then 0 else null end as aplicacao  
		        /*CASE WHEN io.opt_id > 0 THEN 1 ELSE 0 END as transporte*/
			FROM ev_inscricao_detail d
			INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id 
			inner join ev_inscricao_options eio on eio.ins_id = i.ins_id 
			inner join ev_evento_options eeo on eeo.id = eio.opt_id 
			LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
			LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo
			LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod
		        LEFT JOIN ev_inscricao_options io ON i.ins_id = io.ins_id
			WHERE i.ev_id=$evento AND i.ins_status <> '9'
			ORDER BY nome";
			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	       	$result = $db->Execute($qry);
	        return $result;
	}

	function getInscricoesList($evento)
	{
		global $db;
		
		$gid = 0;
		$aux = 0;
		$vis = 0;
		$child = 0;

		$gidEf = 0;
		$auxEf = 0;
		$visEf = 0;
		$childEf = 0;

		$janGid = 0;
		$janAux = 0;
		$janVis = 0;
		$janPas = 0;

		$janGidEf = 0;
		$janAuxEf = 0;
		$janVisEf = 0;
		$janPasEf = 0;

		$transGid = 0;
		$transAux = 0;
		$transVis = 0;

		$transGidEf = 0;
		$transAuxEf = 0;
		$transVisEf = 0;

		$almAux = 0;
		$almVis = 0;
		$almAuxEf = 0;
		$almVisEf = 0;


		$qry = "SELECT DISTINCT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_credencial, i.ins_status,
			trim(c.cmp_nome)||' / '||c.cmp_estado as campo, d.ins_preletor, d.ins_pastor, a.mot_cod, i.pg_tipo_id,
		    v.vis_idade_tp as idade_tp, v.vis_idade as idade, d.valor_transporte as transporte, 
			CASE d.owner_tipo 
				WHEN 'G' THEN a.as_nome 
				WHEN 'A' THEN a.as_nome 
				WHEN 'C' then v.vis_nome 
				WHEN 'V' then v.vis_nome 
			END as nome, 
			CASE  
				WHEN d.owner_tipo='G' OR d.owner_tipo='A' THEN a.as_apelido 
				WHEN d.owner_tipo='C' OR d.owner_tipo='V' then v.vis_apelido 
			END as cracha, 
			ins_almoco,ins_transporte, 

		        case when i.owner_login ilike '00%' or i.owner_login ilike '01%' then 1 else 0 end as ins_web 
			FROM ev_inscricao_detail d 
			INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id 
			LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo 
			LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo 
			LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod 
		        LEFT JOIN ev_inscricao_options io ON i.ins_id = io.ins_id 
			WHERE i.ev_id=$evento AND i.ins_status <> '9' 
			ORDER BY d.ins_id";
			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	       	$result = $db->Execute($qry);

	       	foreach ($result as $row) {

	       		$temp = $result -> fields;
	       		switch ($temp['owner_tipo']) {
	       			case 'G':
	       				$gid++;
	       				if ($temp['ins_status'] == 1) { $gidEf++; }
	       				if ($temp['ins_jantar'] == 't') 
	       					{ 
	       						$janGid++; 
	       						if ($temp['ins_status'] == 1) { $janGidEf++; }
	       					}

	       				if ($temp['ins_transporte'] == 't') 
	       					{ 
	       						$transGid++; 
	       						if ($temp['ins_status'] == 1) { $transGidEf++; }
	       					}

	       				break;
	       			case 'A':
	       				$aux++;
	       				if ($temp['ins_status'] == 1) { $auxEf++; }
	       				if ($temp['ins_jantar'] == 't') 
	       					{ 
	       						$janAux++; 
	       						if ($temp['ins_status'] == 1) { $janAuxEf++; }
	       					}
	       				if ($temp['ins_transporte'] == 't') 
	       					{ 
	       						$transAux++; 
	       						if ($temp['ins_status'] == 1) { $transAuxEf++; }
	       					}

	       				if ($temp['ins_almoco'] == 't') 
	       					{ 
	       						$almAux++; 
	       						if ($temp['ins_status'] == 1) { $almAuxEf++; }
	       					}


	       				break;
	       			case 'C':
	       				$child++;
	       				if ($temp['ins_status'] == 1) { $childEf++; }
	       				break;
	       			case 'V':
	       				$vis++;
	       				if ($temp['ins_status'] == 1) { $visEf++; }
	       				if ($temp['ins_jantar'] == 't') 
	       					{ 
	       						if ($temp['ins_pastor'] == 't')
	       						{
	       							$janPas++;
	       							if ($temp['ins_status'] == 1) { $janPasEf++; }
	       						}
	       						else
	       						{
	       							$janVis++; 
	       							if ($temp['ins_status'] == 1) { $janVisEf++; }
	       						}
	       					}

		       				if ($temp['ins_transporte'] == 't') 
		       					{ 
		       						$transVis++; 
		       						if ($temp['ins_status'] == 1) { $transVisEf++; }
		       					}

		       				if ($temp['ins_almoco'] == 't') 
		       					{ 
		       						$almVis++; 
		       						if ($temp['ins_status'] == 1) { $almVisEf++; }
		       					}

	       				break;
	       			
	       			default:
	       				# code...
	       				break;
	       		}
	       		
	       	}
	       	$total 			= $gid+$aux+$vis+$child;
	       	$totalEf 		= $gidEf+$auxEf+$childEf+$visEf;

	       	$totalJan 		= $janGid+$janAux+$janVis+$janPas;
	       	$totalJanEf 	= $janGidEf+$janAuxEf+$janVisEf+$janPasEf;

	       	$totalTrans		= $transGid+$transAux+$transVis;
	       	$totalTransEf   = $transGidEf+$transAuxEf+$transVisEf;

	       	$totalAlm 		= $almAux+$almVis;
	       	$totalAlmEf 	= $almAuxEf+$almVisEf;

	       	//return $qry;

	        return array($gid,$aux,$vis,$child,$gidEf,$auxEf,$childEf,$visEf,$total,$totalEf,
	        			$janGid,$janAux,$janVis,$janPas,$janGidEf,$janAuxEf,$janVisEf,$janPasEf,$totalJan,$totalJanEf,
	        			$transGid,$transAux,$transVis,$transGidEf,$transAuxEf,$transVisEf,$totalTrans,$totalTransEf,
	        			$almAux,$almVis,$almAuxEf,$almVisEf,$totalAlm,$totalAlmEf
	        			);
	}

	function getJantarList($evento)
	{
		global $db;

		$qry = "SELECT DISTINCT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_credencial, i.ins_status,
			trim(c.cmp_nome)||' / '||c.cmp_estado as campo, d.ins_preletor, d.ins_pastor, a.mot_cod, i.pg_tipo_id,
		    v.vis_idade_tp as idade_tp, v.vis_idade as idade, d.valor_transporte as transporte, 
			CASE d.owner_tipo
				WHEN 'G' THEN a.as_nome
				WHEN 'A' THEN a.as_nome
				WHEN 'C' then v.vis_nome
				WHEN 'V' then v.vis_nome
			END as nome,
			CASE 
				WHEN d.owner_tipo='G' OR d.owner_tipo='A' THEN a.as_apelido
				WHEN d.owner_tipo='C' OR d.owner_tipo='V' then v.vis_apelido
			END as cracha,
		        CASE WHEN d.valor_almoco > 0 THEN 1 ELSE 0 END as ins_almoco,
		        case when i.owner_login ilike '00%' or i.owner_login ilike '01%' then 1 else 0 end as ins_web 
		        /*CASE WHEN io.opt_id > 0 THEN 1 ELSE 0 END as transporte*/
			FROM ev_inscricao_detail d
			INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
			LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
			LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo
			LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod
		        LEFT JOIN ev_inscricao_options io ON i.ins_id = io.ins_id
			WHERE i.ev_id=$evento AND i.ins_status <> '9'
			ORDER BY d.ins_id";
			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	       	$result = $db->Execute($qry);
	        return $result;
	}

	function getEventoInfo($evento)
	{
		global $db;

		$sqlEventoInfo = "select ev_nome,ev_dt_ini,ev_dt_fim,to_date(to_char(ev_dt_ini,'YYYY-MM-DD'),'YYYY-MM-DD') - integer '3' AS data_venc_limite,
                        to_char(ev_dt_ini,'DD')||' a '||to_char(ev_dt_FIM,'DD/MM/YYYY') as ev_data  
                        from ev_evento  
                        where ev_id = $ev_id";

               
            $evInf = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $evInf = $db->Execute($sqlEventoInfo);
            return $evInf;
	}

	function getEventoOptions($evento)
	{
		global $db;

		$sqlSelectEventoOptions = "select id,aplicacao,valor from ev_evento_options where ev_id = $evento";
	    $resultadoEventoOptions = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	    $resultadoEventoOptions = $db->Execute($sqlSelectEventoOptions);

	    return $resultadoEventoOptions;
	}

	function getInsId($owner_id, $owner_tipo,$ev_id,$ins_guiche)
	{
			global $db;

			$sqlInsert = "INSERT INTO ev_inscricao(owner_id,owner_tipo,ev_id,ins_status,ins_guiche) 
                            VALUES ($owner_id,'$owner_tipo',$ev_id,'1','$ins_guiche');select CurrVal('public.ev_inscricao_ins_id_seq') as id;"; 
           
            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sqlInsert);
            $temp = $result -> fields; 

            return $temp['id'];

	}

	function insertInscDetail($ins_id,$owner_id,$owner_tipo,$janta,$mensageiro,$valCont=0,$ins_pastor='false',$almoco,$transp)
	{
		global $db;

		switch ($owner_tipo) {
			case 'G':
				$sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_preletor,ins_seq,ins_transporte) 
                                                VALUES ($ins_id,$owner_id,'$owner_tipo',$janta,$mensageiro,$valCont,$transp)";
        		$result = $db->Execute($sqlInsert);
				break;

			case 'A':
				$sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_seq,ins_almoco,ins_transporte) 
                                                VALUES ($ins_id,$owner_id,'$owner_tipo',$janta,$valCont,$almoco,$transp)";
        		$result = $db->Execute($sqlInsert);
				break;

			case 'V':
				$sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_jantar,ins_pastor,ins_seq,ins_almoco,ins_transporte) 
                                                VALUES ($ins_id,$owner_id,'$owner_tipo',$janta,$ins_pastor,$valCont,$almoco,$transp)";
        		$result = $db->Execute($sqlInsert);
				break;
			case 'C':
				$sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_seq) 
                                                VALUES ($ins_id,$owner_id,'$owner_tipo',$valCont)";
        		$result = $db->Execute($sqlInsert);
				break;

		}

		return $sqlInsert;		
	}

	function insertVis($vis_tipo,$ins_id,$vNome,$vPas,$vAlias)
	{
		global $db;

			$sqlInsert = "INSERT INTO visitante(vis_tipo,ins_id,vis_nome,vis_pastor,vis_apelido)
                      VALUES ('$vis_tipo',$ins_id,'$vNome','$vPas','$vAlias'); select CurrVal('public.visitante_vis_id_seq') as vis_id;"; 
                                        
	        $result2 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	        $result2 = $db->Execute($sqlInsert);
	        $tempV = $result2 -> fields; 

	        return $tempV['vis_id'];
			
	}

	function insertChild($vis_tipo,$ins_id,$vNome,$vIdade,$vFebre,$vFebreDesc,$vRestricao,$vRestricaoDesc,$vAlias,$vAlergia,$vAlergiaDesc)
	{
		global $db;

		$sqlInsert = "INSERT INTO visitante(vis_tipo,ins_id,vis_nome,vis_idade,vis_febre,vis_febre_med,vis_rest_alim,vis_rest_alim_qual,
              			vis_apelido,vis_alergia,vis_alergia_qual) 
                        VALUES ('$vis_tipo',$ins_id,'$vNome',$vIdade,'$vFebre','$vFebreDesc','$vRestricao','$vRestricaoDesc','$vAlias','$vAlergia',
                                                    '$vAlergiaDesc'); select CurrVal('public.visitante_vis_id_seq') as vis_id;";

        $result3 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result3 = $db->Execute($sqlInsert);
        $tempC = $result3 -> fields; 

        return $tempC['vis_id'];

	}

	function inscricaoOptionsCrianca($ins_id,$idOptCrianca,$valOptCrianca)
	{
		global $db;

		$sqlInscricaoOptions = "insert into ev_inscricao_options (ins_id,opt_id,quantidade,vr_unitario) 
                                        values ($ins_id,$idOptCrianca,1,$valOptCrianca);";

        $resultInscricaoOptions = $db->Execute($sqlInscricaoOptions);

        return $sqlInscricaoOptions;
	}

	function insertInscricaoOptions($ins_id,$opt_id,$qdeOpt,$vr_unitario)
	{
		global $db;

		$sqlInscricaoOptions = "insert into ev_inscricao_options (ins_id,opt_id,quantidade,vr_unitario)
                                        values ($ins_id,$opt_id,$qdeOpt,$vr_unitario);";
        $resultInscricaoOptions = $db->Execute($sqlInscricaoOptions);
	}

	function getInscricaoMembroInfo($ins_id)
	{
		global $db;

		$ano = date('Y');
		$testeMes = date('m');

		if ($testeMes < 6)
		{
			$geoperiodo = $ano -1;
		}
		else
		{
			$geoperiodo = $ano;

		}

		$sqlSelIns = "select a.new_as_cod::int,a.as_nome,case when length(a.as_apelido) > 0 
				then a.as_apelido 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
				end as as_apelido,eid.ins_valor, g.idcampo||'/'||g.nm_campo as campo, a.new_as_cod||'.'||ei.ins_id||'.'||a.as_tipo as ref 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            inner join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $geoperiodo 
                            where ei.ins_id = $ins_id ";
                $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultIns = $db->Execute($sqlSelIns);

                return $resultIns;
	}

	function getInscricaoVisInfo($ins_id)
	{
		global $db;

		$sql = "select v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, 'VISITANTE' AS vis, v.vis_id||'.'||ei.ins_id||'.'||'V' as ref 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = $ins_id and v.vis_tipo = 'V'";

        $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $resultIns = $db->Execute($sql);

        return $resultIns;
	}

	function getInscricaoCriancaInfo($ins_id)
	{
		global $db;

		$sql = "select v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, case when v.vis_tipo = 'C' then 
					case when length(v.vis_resp) > 0 then v.vis_resp 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome))||'/'||a.as_fone_cel end else v.vis_nome end as resp,
				v.vis_id||'.'||ei.ins_id||'.'||'C' as ref   
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            inner join associado a on a.as_cod = ei.owner_id and a.as_tipo = ei.owner_tipo 
                            where ei.ins_id = $ins_id and v.vis_tipo = 'C'";

        $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $resultIns = $db->Execute($sql);

        return $resultIns;
	}

	function getInscricaoListTela($ev_id,$ev_ano,$insStatus,$insOrder,$insTipo)
	{
		global $db;

		$sql_grid = "select e.ins_id as inscricao,to_char(e.ins_data, 'DD/MM/YYYY') as data,evd.owner_tipo,case when evd.owner_tipo in ('A','G') then a.new_as_cod when evd.owner_tipo = 'C' then '98' || trim(to_char(v.vis_id,'9900000')) 
				else '99' || trim(to_char(v.vis_id,'9900000')) end as numero, 
                            case when evd.owner_tipo in ('A','G') then a.as_nome else v.vis_nome end as nome, g.idcampo||' - '||g.nm_campo||' / '||g.nm_setor as secmp,
                            case when evd.ins_jantar = true then 'SIM' else null end as jantar 
                            from ev_inscricao e 
                            inner join ev_inscricao_detail evd on e.ins_id = evd.ins_id 
                            left join associado a on evd.owner_id = a.as_cod and a.as_tipo = evd.owner_tipo 
                            left join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $ev_ano 
                            left join visitante v on evd.owner_id = v.vis_id and v.vis_tipo = evd.owner_tipo 
                            where e.ev_id = $ev_id and e.ins_status in ('$insStatus') and evd.owner_tipo in ('$insTipo')  
                            order by $insOrder";

                $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $result = $db->Execute($sql_grid);

                return $result;
	}

	function getInscricaoListTelaEleicao($ev_id,$ev_ano,$insTipo)
	{
		global $db;

		$sql_grid = "select e.ins_id as inscricao,to_char(e.ins_data, 'DD/MM/YYYY') as data,evd.owner_tipo,case when evd.owner_tipo in ('A','G') then a.new_as_cod when evd.owner_tipo = 'C' then '98' || trim(to_char(v.vis_id,'9900000')) 
				else '99' || trim(to_char(v.vis_id,'9900000')) end as numero, 
                            case when evd.owner_tipo in ('A','G') then a.as_nome else v.vis_nome end as nome,g.nm_estadual, g.idcampo||' - '||g.nm_campo||' / '||g.nm_setor as secmp,
                            case when evd.ins_jantar = true then 'SIM' else null end as jantar 
                            from ev_inscricao e 
                            inner join ev_inscricao_detail evd on e.ins_id = evd.ins_id 
                            left join associado a on evd.owner_id = a.as_cod and a.as_tipo = evd.owner_tipo 
                            left join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $ev_ano 
                            left join visitante v on evd.owner_id = v.vis_id and v.vis_tipo = evd.owner_tipo 
                            where e.ev_id = $ev_id and e.ins_status in ('1') and evd.owner_tipo in ('$insTipo')
                            order by g.nm_estadual, nome";

                $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $result = $db->Execute($sql_grid);

                return $result;
	}

	function getItensInsc($ins_id)
	{
		global $db;

		$sql_grid = "select eeo.descricao,eio.quantidade, eio.quantidade * eio.vr_unitario as valor
						from ev_inscricao_options eio
						inner join ev_evento_options eeo on eeo.id = eio.opt_id
						where eio.ins_id = $ins_id";

                $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $result = $db->Execute($sql_grid);

                return $result;
	}

	function getTotaisReais($ins_id)
	{
		global $db;

				$sql_grid = "select sum(eio.quantidade * eio.vr_unitario)::int as valor
						from ev_inscricao_options eio
						inner join ev_evento_options eeo on eeo.id = eio.opt_id
						where eio.ins_id = $ins_id and eeo.descricao not ilike 'Desconto%'";

                $subtotal = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $subtotal = $db->Execute($sql_grid);
                $temp = $subtotal -> fields;
                $subtotal = $temp['valor'];

                $sql_grid = "select sum(eio.quantidade * eio.vr_unitario)::int as valor
						from ev_inscricao_options eio
						inner join ev_evento_options eeo on eeo.id = eio.opt_id
						where eio.ins_id = $ins_id and eeo.descricao ilike 'Desconto%'";

                $descontos = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $descontos = $db->Execute($sql_grid);
                $temp = $descontos -> fields;
                $descontos = $temp['valor'];

                $total = $subtotal - $descontos;

                return array($subtotal,$descontos,$total);
	}

	function getInsIndividual($ins_id)
	{
		global $db;

		$qry = "SELECT DISTINCT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_credencial, i.ins_status,
			trim(c.cmp_nome)||' / '||c.cmp_estado as campo, d.ins_preletor, d.ins_pastor, a.mot_cod, i.pg_tipo_id,
		    v.vis_idade_tp as idade_tp, v.vis_idade as idade, d.valor_transporte as transporte, 
			CASE d.owner_tipo 
				WHEN 'G' THEN a.as_nome 
				WHEN 'A' THEN a.as_nome 
				WHEN 'C' then v.vis_nome 
				WHEN 'V' then v.vis_nome 
			END as nome,
			CASE d.owner_tipo 
				WHEN 'G' THEN a.new_as_cod 
				WHEN 'A' THEN a.new_as_cod 
				WHEN 'C' then to_char(v.vis_id,'9990000') 
				WHEN 'V' then to_char(v.vis_id,'9990000') 
			END as new_as_cod,
			CASE 
				WHEN d.owner_tipo='G' OR d.owner_tipo='A' THEN a.as_apelido 
				WHEN d.owner_tipo='C' OR d.owner_tipo='V' then v.vis_apelido 
			END as cracha,
		        d.ins_almoco, d.ins_transporte,
		        case when i.owner_login ilike '00%' or i.owner_login ilike '01%' then 1 else 0 end as ins_web,
		        CASE WHEN d.ins_jantar = true then 'SIM' ELSE 'NÃO' end as jantartexto,
		        CASE WHEN d.ins_almoco = true then 'SIM' ELSE 'NÃO' end as almocotexto,
		        CASE WHEN d.ins_transporte = true then 'SIM' ELSE 'NÃO' end as transportetexto,

		        v.vis_idade 
		        /*CASE WHEN io.opt_id > 0 THEN 1 ELSE 0 END as transporte*/
			FROM ev_inscricao_detail d 
			INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
			LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo 
			LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo 
			LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod 
		        LEFT JOIN ev_inscricao_options io ON i.ins_id = io.ins_id 
			WHERE i.ins_id = $ins_id AND i.ins_status <> '9' 
			ORDER BY d.ins_id";
			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	       	$result = $db->Execute($qry);


                return $result;	
	}

	function returnQdeIns($ins_id)
	{
		global $db;
		$sql = "select count(*) as qde from ev_inscricao_detail where ins_id = $ins_id";
		$result3 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result3 = $db->Execute($sql);
        $temp = $result3 -> fields; 
        return $temp['qde'];

	}

	function getInscricaoGeneric($ins_id,$tipo,$idpessoa)
	{
		global $db;

		$ano = date('Y');
		$testeMes = date('m');

		if ($testeMes < 6)
		{
			$geoperiodo = $ano -1;
		}
		else
		{
			$geoperiodo = $ano;

		}


		switch ($tipo) {
			case 'G':
			case 'A':

				$sql = "select ei.ins_id,a.new_as_cod::int,a.as_nome,case when length(a.as_apelido) > 0 
				then a.as_apelido 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
				end as as_apelido,eid.ins_valor, g.idcampo||'/'||g.nm_campo as campo, a.new_as_cod||'.'||ei.ins_id||'.'||a.as_tipo as ref 
                ,eid.ins_transporte as transporte,eid.ins_transporte
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            inner join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $geoperiodo 
                            where ei.ins_id = $ins_id and eid.owner_id = $idpessoa and eid.owner_tipo = '$tipo'";
				break;
			case 'V':
				$sql = "select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, 'VISITANTE' AS vis, v.vis_id||'.'||ei.ins_id||'.'||'V' as ref 
                ,eid.ins_transporte as transporte,eid.ins_transporte
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = $ins_id and eid.owner_id = $idpessoa and eid.owner_tipo = '$tipo'";
				break;
			
			case 'C':
				$sql = "select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, case when v.vis_tipo = 'C' then 
					case when length(v.vis_resp) > 0 then v.vis_resp 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome))||'/'||a.as_fone_cel end else v.vis_nome end as resp,
				v.vis_id||'.'||ei.ins_id||'.'||'C' as ref   
                ,eid.ins_transporte as transporte,eid.ins_transporte
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            inner join associado a on a.as_cod = ei.owner_id and a.as_tipo = ei.owner_tipo 
                            where ei.ins_id = $ins_id and eid.owner_id = $idpessoa and eid.owner_tipo = '$tipo'";
				break;

			default:
				# code...
				break;
		}

                $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultIns = $db->Execute($sql);
                $temp = $resultIns -> fields; 

                return $temp;
	}

	function getInscricaoGenericByInsid($ins_id)
	{
		global $db;

		$ano = date('Y');
		$testeMes = date('m');

		if ($testeMes < 6)
		{
			$geoperiodo = $ano -1;
		}
		else
		{
			$geoperiodo = $ano;

		}

		$sql = "select ei.ins_id,a.new_as_cod::int,a.as_nome,case when length(a.as_apelido) > 0 
				then a.as_apelido 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
				end as as_apelido,eid.ins_valor, g.idcampo||'/'||g.nm_campo as campo, a.new_as_cod||'.'||ei.ins_id||'.'||a.as_tipo as ref,eid.ins_transporte
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo 
                            inner join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $geoperiodo
                            where ei.ins_id = $ins_id 
                            UNION ALL
                            select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, 'VISITANTE' AS vis, v.vis_id||'.'||ei.ins_id||'.'||'V' as ref,eid.ins_transporte 
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            where ei.ins_id = $ins_id and v.vis_tipo = 'V'
                            union all
                            select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
				then v.vis_apelido 
				else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
				end as vis_apelido,eid.ins_valor, case when v.vis_tipo = 'C' then 
					case when length(v.vis_resp) > 0 then v.vis_resp 
				else substring(a.as_nome from 1 for position(' ' in a.as_nome))||'/'||a.as_fone_cel end else v.vis_nome end as resp,
				v.vis_id||'.'||ei.ins_id||'.'||'C' as ref,eid.ins_transporte   
                            from ev_inscricao ei 
                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
                            inner join associado a on a.as_cod = ei.owner_id and a.as_tipo = ei.owner_tipo 
                            where ei.ins_id = $ins_id and v.vis_tipo = 'C'";


		 $resultIns = $db->SetFetchMode(ADODB_FETCH_ASSOC);
                $resultIns = $db->Execute($sql);
                $temp = $resultIns -> fields; 

                return $resultIns;

	}

	function updateCracha($ins_id,$tipo,$idpessoa)
	{

		global $db;

		$sql = "update ev_inscricao_detail set ins_credencial = true 
				where 
				ins_id = $ins_id and owner_id = $idpessoa and owner_tipo = '$tipo'";

		$result = $db->Execute($sql);

	}

	function updateCrachaNome($tipo,$idpessoa,$cracha)
	{
		global $db;

		$cracha = str_replace("'", "''", $cracha);

		switch ($tipo) {
			case 'G':
			case 'A':
				$sql = "update associado set as_apelido = '$cracha'  
				where 
				as_cod = $idpessoa and as_tipo = '$tipo'";
					$message = "Crachá atualizado para <b>$cracha<b>.";
				
				break;

			case 'V':
			case 'C':
				$sql = "update visitante set vis_apelido  = '$cracha' 
				where 
				vis_id = $idpessoa and vis_tipo = '$tipo'";
					$message = "Crachá atualizado para <b>$cracha<b>.";
				break;	

		}
		
		$result = $db->Execute($sql);
		
		return $message;

	}

	function getAllCracha($ev_id)
	{
		global $db;

		$ano = date('Y');
		$testeMes = date('m');

		if ($testeMes < 6)
		{
			$geoperiodo = $ano -1;
		}
		else
		{
			$geoperiodo = $ano;

		}

		$sql = "select at.*
				from (
				select ei.ins_id,a.new_as_cod::int,a.as_nome,case when length(a.as_apelido) > 0 
								then a.as_apelido 
								else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
								end as as_apelido,eid.ins_valor, g.idcampo||'/'||g.nm_campo as campo, a.new_as_cod||'.'||ei.ins_id||'.'||a.as_tipo as ref 
				                            from ev_inscricao ei 
				                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
				                            inner join associado a on eid.owner_id = a.as_cod and eid.owner_tipo = a.as_tipo  
				                            inner join geo.geografia g on a.cmp_cod = g.idcampo and g.periodo = $geoperiodo 
				                            where ei.ev_id = $ev_id
							    UNION ALL 
				select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
								then v.vis_apelido 
								else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
								end as vis_apelido,eid.ins_valor, 'VISITANTE' AS vis, v.vis_id||'.'||ei.ins_id||'.'||v.vis_tipo as ref 
				                            from ev_inscricao ei 
				                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
				                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
				                            where ei.ev_id = $ev_id and v.vis_tipo = 'V' 
							UNION ALL 
				select ei.ins_id,v.vis_id,v.vis_nome,case when length(v.vis_apelido) > 0 
								then v.vis_apelido 
								else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
								end as vis_apelido,eid.ins_valor, case when v.vis_tipo = 'C' then 
									case when length(v.vis_resp) > 0 then v.vis_resp 
								else substring(a.as_nome from 1 for position(' ' in a.as_nome))||'/'||a.as_fone_cel end else v.vis_nome end as resp,
								v.vis_id||'.'||ei.ins_id||'.'||'C' as ref   
				                            from ev_inscricao ei 
				                            inner join ev_inscricao_detail eid on ei.ins_id = eid.ins_id 
				                            inner join visitante v on eid.owner_id = v.vis_id and eid.owner_tipo = v.vis_tipo 
				                            inner join associado a on a.as_cod = ei.owner_id and a.as_tipo = ei.owner_tipo 
				                            where ei.ev_id = $ev_id and v.vis_tipo = 'C') as at 
				                            order by at.as_nome";

		$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
		$result = $db->Execute($sql);

		return $result;
	}

	function imprimeCracha($tipoCracha,$transporte,$apelido,$campo,$referencia,$nome)
	{
		switch ($tipoCracha) {
			case 'N':
				$cracha = "<div class='divCracha' style='margin-left:41px; margin-top:23px; width: 95mm; background-color: #FFF; border: 2px solid;'>
								<span style='float: center;'>
								{$_SESSION['gsr']['ev_nome']}
								</span>

							  <img src='imgs/logo_gid.gif' style='margin-left:5px; float: left; height='60' width='60'><br/><br/>
							  <br/>
							  <br/>
							  <br/>
							  <span class='title' style='text-align: center;' >$apelido</span>
							  <br/>$nome
							  <br/>$campo
							  <br/>
							  <br/>
							  <br/>
							  <br/>
							  <div style='text-align: right; font-size: 10px;margin-top: 8px; padding-right:2mm;'>
							  <br/>$referencia</div>
							</div>";
				break;

			case 'B':
			   // echo "entrou";
				$cracha = "<div class='pag divCracha' style='border-bottom-color:black; border:111px;  width: 60mm; background-color: #EEE;' >".
                                "<span class='title'>$apelido</span><br/>";
			        $cracha .=  "<span style='font-size:10px; '>$campo</span>";
                    $cracha .= "<div style='text-align: right; font-size: 8px;margin-top: 8px; padding-right:2mm;'><br/> $referencia";

                    if($transporte == 't'){$cracha .= "<img src='imgs/transporte.png' width='45px' align='left' style='margin-top:-15px; '><br/><br/> ";}

                    $cracha .= "</div>";
                $cracha .= "</div>";

				break;	

		}

		return $cracha;

	}

	function updateInsStatus($ins_id,$int)
	{
		global $db;

		$sqlInscricaoOptions = "update ev_inscricao set ins_status = '$int' where ins_id = $ins_id";
        $resultInscricaoOptions = $db->Execute($sqlInscricaoOptions);
	}

	function deleteInsc($ins_id)
	{
		global $db;

		$sql = "delete from ev_inscricao_detail where ins_id = $ins_id;
				delete from ev_inscricao_options where ins_id = $ins_id;";

		$result = $db->Execute($sql);
	}

	function insertEditChild($ev_id,$ins_id,$owner_id,$owner_tipo,$idade)
	{
		global $db;

		$sql = "select valor::int,idade,aplicacao,id as idopt 
				from ev_evento_options 
				where ev_id = $ev_id and aplicacao = 5 and idade >= $idade order by idade limit 1";
		$resultIdade = $db->SetFetchMode(ADODB_FETCH_ASSOC);
		$resultIdade = $db->Execute($sql);
		$temp = $resultIdade -> fields;

		$sqlInsert = "INSERT INTO ev_inscricao_detail(ins_id,owner_id,owner_tipo,ins_seq) 
                      VALUES ($ins_id,$owner_id,'$owner_tipo',0)";
        $result = $db->Execute($sqlInsert);

       	$teste = inscricaoOptionsCrianca($ins_id,$temp['idopt'],$temp['valor']);

        return $sql."<br>".$sqlInsert."<br>".$teste;
	}

    function reportPresence($ev_id, $rep_tipo)
    {

        global $db;

        $ano = date('Y');
        $testeMes = date('m');

        if ($testeMes < 6)
        {
            $geoperiodo = $ano -1;
        }
        else
        {
            $geoperiodo = $ano;

        }

        if ($rep_tipo == "cpo") {

            $sql = "SELECT count(d.*) as num, a.as_tipo, a.cmp_cod, g.idestadual, g.idsetor, "
                ." trim(c.cmp_nome)||' / '||c.cmp_estado as campo"
                ." FROM ev_inscricao_detail d"
                ." INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id"
                ." INNER JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo"
                ." INNER JOIN campo c ON a.cmp_cod=c.cmp_cod"
                ." INNER JOIN geo.geografia g ON c.cmp_cod=g.idcampo AND g.periodo=$geoperiodo"
                ." WHERE i.ev_id=$ev_id AND i.ins_status = '1' AND (d.owner_tipo='G' OR d.owner_tipo='A')"
                ." GROUP BY g.idestadual, g.idsetor, a.cmp_cod, c.cmp_nome, c.cmp_estado, a.as_tipo"
                ." ORDER BY c.cmp_nome, a.as_tipo";
            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sql);

            foreach($result as $row){
                $inscritos[$row["cmp_cod"]]["est"] = $row["idestadual"];
                $inscritos[$row["cmp_cod"]]["set"] = $row["idsetor"];
                $inscritos[$row["cmp_cod"]]["nome"] = $row["campo"];
                $inscritos[$row["cmp_cod"]]["ins_{$row["as_tipo"]}"] = $row["num"];
            }

            $sql = "SELECT a.cmp_cod, a.as_tipo, count(a.*) as num FROM associado a
                     WHERE a.mot_cod in (1,6,7,8) GROUP BY a.cmp_cod, a.as_tipo";
            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sql);


            foreach($result as $row) {
                $inscritos[$row["cmp_cod"]]["qde_{$row["as_tipo"]}"] = $row["num"];
            }

            return $inscritos;
        }


        elseif ($rep_tipo == "se") {

            $inscritos = array();
            $sql = "SELECT g.idestadual, g.nm_estadual, g.idsetor, g.nm_setor, a.as_tipo, count(a.*) as num 
                    FROM associado a 
                    INNER JOIN geo.geografia g ON a.cmp_cod=g.idcampo AND g.periodo=$geoperiodo
                    WHERE a.mot_cod in (1,6,7,8)
                    GROUP BY g.idestadual, g.nm_estadual, g.idsetor, g.nm_setor, a.as_tipo 
                    ORDER BY g.idestadual, g.nm_setor ";

            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sql);

            foreach($result as $row) {
                $inscritos[$row["idestadual"]]["nome"] = $row["nm_estadual"];
                $inscritos[$row["idestadual"]][$row["idsetor"]]["nome"] = $row["nm_setor"];
                $inscritos[$row["idestadual"]][$row["idsetor"]]["qde_{$row["as_tipo"]}"] = $row["num"];
            }

            $sql = "SELECT DISTINCT count(d.owner_id) as num, a.as_tipo, g.idcampo, g.idsetor, g.idestadual		
                    FROM ev_inscricao_detail d
                    INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id 
                    left JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
                    left join geo.geografia g on g.idcampo = a.cmp_cod and g.periodo = $geoperiodo
                    WHERE i.ev_id=$ev_id AND i.ins_status = '1'  AND (d.owner_tipo='G' OR d.owner_tipo='A')
                    group by a.as_tipo, g.idcampo, g.idsetor, g.idestadual ";

            $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $db->Execute($sql);

            foreach($result as $row){
                $inscritos[$row["idestadual"]][$row["idsetor"]]["ins_{$row["as_tipo"]}"] += $row["num"];
                $inscritos[$row["idestadual"]][$row["idsetor"]]["cmp_{$row["as_tipo"]}"]++;
            }

            return $inscritos;
        }
    }

    function reportInfantoJuvenil($ev_id, $idadeMin, $idadeMax)
    {
		global $db;

		if($idadeMin == null) { $idadeMin = 0;}
		if($idadeMax == null) { $idadeMax = 99;}	


    	$sql = "SELECT d.ins_id, d.owner_id, d.owner_tipo, v.vis_nome as nome, v.vis_idade as idade, 
			    vis_idade_tp as idade_tipo, v.vis_febre as febre, v.vis_febre_med as medica, v.vis_rest_alim as restricao, 
			    v.vis_rest_alim_qual as alimento, v.vis_alergia as alergia, v.vis_alergia_qual as alergico, 
			    v.vis_ts||v.vis_rh as tipo_sanguineo, v.vis_resp, v.vis_fone, 
			    CASE i.owner_tipo WHEN 'G' THEN 	case when length(a.as_apelido) > 0 
								then a.as_apelido 
								else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
								end 
					      WHEN 'A' THEN 	case when length(a.as_apelido) > 0 
								then a.as_apelido 
								else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
								end 
					      WHEN 'V' then 	case when length(v.vis_apelido) > 0 
								then v.vis_apelido
								else substring(a.as_nome from 1 for position(' ' in v.vis_apelido)) 
								end 
			    END as responsavel, 
			    CASE i.owner_tipo WHEN 'G' THEN a.as_fone_cel WHEN 'A' THEN a.as_fone_cel WHEN 'V' then v.vis_fone 
			    END as fone 
			    FROM ev_inscricao_detail d 
			    INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id AND i.ins_status <> '9' 

			    LEFT JOIN associado a ON i.owner_id=a.as_cod AND i.owner_tipo=a.as_tipo 
			    LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo  
			    
			    WHERE i.ev_id=$ev_id AND d.owner_tipo='C' 

			    AND v.vis_idade >= $idadeMin 
			    AND v.vis_idade <= $idadeMax 
			    
			    order by nome";

		$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $db->Execute($sql);

        return $result;
    }

    function reportMensageiros($ev_id)
    {

    	global $db;

    	$ano = date('Y');
        $testeMes = date('m');

        if ($testeMes < 6)
        {
            $geoperiodo = $ano -1;
        }
        else
        {
            $geoperiodo = $ano;

        }

	    $sql =	"SELECT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_seq, i.ev_id,
			g.idcampo as geo_cod, dn.deno_descr, a.new_as_cod as idmembro,
			trim(c.cmp_nome)||' / '||c.cmp_estado as campo, trim(a.as_nome) as nome 
			FROM ev_inscricao_detail d 
			INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id 
			INNER JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo 
			INNER JOIN campo c ON a.cmp_cod=c.cmp_cod 
			INNER JOIN geo.geografia g ON a.cmp_cod=g.idcampo AND g.periodo = $geoperiodo  
			INNER JOIN denominacao dn ON a.deno_cod=dn.deno_cod 
			WHERE i.ev_id=$ev_id AND i.ins_status='1' AND d.ins_preletor 
			AND d.owner_tipo='G' 
			ORDER BY nome" ;

			$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	        $result = $db->Execute($sql);

	        return $result;

    }
    function poderVoto($ev_id, $tipo){
        global $db;

        $ano = date('Y');
        $testeMes = date('m');

        if ($testeMes < 6)
        {
            $geoperiodo = $ano -1;
        }
        else
        {
            $geoperiodo = $ano;

        }


        $inscritos = array();
        $sql = "SELECT g.idestadual, g.nm_estadual, a.as_tipo, count(a.*) as num FROM associado a
                 INNER JOIN geo.geografia g ON a.cmp_cod=g.idcampo AND g.periodo=$geoperiodo
                 WHERE a.mot_cod in (1,6,7,8) AND a.as_tipo= '$tipo'
                 GROUP BY g.idestadual, g.nm_estadual, a.as_tipo
                 ORDER BY g.idestadual ";
        $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $db->Execute($sql);

        foreach ($result as $row) {
            $inscritos[$row["idestadual"]]["nome"] = $row["nm_estadual"];
            $inscritos[$row["idestadual"]]["qde"] = $row["num"];
        }

        $sql = "SELECT count(d.*) as num, a.as_tipo, g.idcampo, g.idestadual
               FROM ev_inscricao_detail d
               INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
               INNER JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
               INNER JOIN geo.geografia g ON a.cmp_cod=g.idcampo AND g.periodo=$geoperiodo
               WHERE i.ev_id=$ev_id AND i.ins_status='1' AND d.owner_tipo='$tipo'
               GROUP BY g.idcampo, g.idestadual, a.as_tipo
               ORDER BY g.idestadual, a.as_tipo";
        $result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $db->Execute($sql);

        foreach ($result as $row) {
            $inscritos[$row["idestadual"]]["ins"] += $row["num"];
            $inscritos[$row["idestadual"]]["cmp"]++;
        }

        return $inscritos;
    }

    function updateRecibo($ins_id,$guiche)
    {

    	global $db;

    	$sql = "UPDATE ev_inscricao SET ins_recibo = '1', ins_guiche = '$guiche' where ins_id = $ins_id";

    	$result = $db->Execute($sql);

    	return $sql;

    }

    function updateFicha($ins_id,$guiche)
    {

    	global $db;

    	$sql1 = "UPDATE ev_inscricao SET ins_guiche = '$guiche' WHERE ins_id = $ins_id;";

    	$result = $db->Execute($sql1);

    	$sql = "UPDATE ev_inscricao_detail SET ins_ficha = '0', ins_guiche = '$guiche' where ins_id = $ins_id and owner_tipo = 'C'";
    	
    	$result = $db->Execute($sql);

    	return $sql1;

    }







?>