<?php
	
///////////////////////////////////////
require_once('../header.php');

header("Content-Type: application/json", true);

	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	$columns = array(
		0 => 'ins_id',
		1 => 'owner_id', 
		2 => 'nome',
		3 => 'cracha',
		4 => 'campo',
		5 => 'ins_status',
		6 => 'ins_credencial',
		7 => 'ins_almoco',
		8 => 'ins_jantar',
		9 => 'ins_transporte'
	);
	
	$where_condition = $sqlTot = $sqlRec = "";

	if( !empty($params['search']['value']) ) {
		$where_condition .=	" AND ";

		if (intval($params['search']['value']) >0) {
			$where_condition .= " d.ins_id = ".$params['search']['value'];    

		}else{

		$where_condition .= " ( a.as_nome ILIKE '%".$params['search']['value']."%' ";    
		$where_condition .= " OR v.vis_nome ILIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR c.cmp_nome ILIKE '%".$params['search']['value']."%' )";  

		}
	}

	$sql_query = " SELECT DISTINCT d.ins_id, d.owner_id,
			CASE d.owner_tipo
				WHEN 'G' THEN a.as_nome
				WHEN 'A' THEN a.as_nome
				WHEN 'C' then v.vis_nome
				WHEN 'V' then v.vis_nome
			END as nome,
			CASE 
				WHEN d.owner_tipo='G' OR d.owner_tipo='A' THEN a.as_apelido
				WHEN d.owner_tipo='C' OR d.owner_tipo='V' then v.vis_apelido
			END as cracha, trim(c.cmp_nome)||' / '||c.cmp_estado as campo, i.ins_status,
			ins_credencial,ins_almoco,ins_jantar,ins_transporte
						
			FROM ev_inscricao i

		
			left JOIN ev_inscricao_detail d ON i.ins_id  = d.ins_id
			left join ev_inscricao_options eio on i.ins_id  = eio.ins_id 
			left join ev_evento_options eeo on eeo.id = eio.opt_id 
			LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
			LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo
			LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod
		    LEFT JOIN ev_inscricao_options io ON i.ins_id = io.ins_id
			WHERE i.ev_id=177 AND i.ins_status <> '9' ";

	$sqlTot .= $sql_query;
	$sqlRec .= $sql_query;



	if(isset($where_condition) && $where_condition != '') {

		$sqlTot .= $where_condition;
		$sqlRec .= $where_condition;
	}
	
 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['length']." OFFSET ".$params['start']." ";


	$queryTot = pg_query($sqlTot) or die("Database Error:");



	$totalRecords = pg_num_rows($queryTot);

	$queryRecords = pg_query($sqlRec) or die("Error to Get the Post details.");
	
	while( $row = pg_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => intval( $totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data
	);

	echo json_encode($json_data);
?>
	