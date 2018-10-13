<?php
/*===========================================================================
 Gerenciamento dos Dados do Gabinete estadual

 Nome Módulo: Gabinete


*13/04/2015 - Henrique - Tela de Insert cargos no esquema geo
 
===========================================================================*/
require_once('../header.php');


$numIns = preg_replace("/[^0-9]/", "", $_POST['numIns2']);

if ($numIns > 0) {
	$result = "SELECT DISTINCT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_credencial, i.ins_status,
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
			WHERE i.ins_id = $numIns AND i.ins_status <> '9'
			ORDER BY d.ins_id";
	$sql = $db->SetFetchMode(ADODB_FETCH_ASSOC);
	$sql = $db->Execute($result);

	echo '<option value="0">Selecionar Convencional</option>';

	foreach ($sql as $row3)
	{	
		$temp = $sql -> fields;
		$ins_id = $temp["ins_id"];
		$owner_id = $temp["owner_id"];
		$owner_tipo = $temp["owner_tipo"];
		$nome = $temp["nome"];
		echo "<option value='$ins_id?$owner_id?$owner_tipo?$nome'>$nome</option>";
	}
}
else
{
	echo '<option value="0">--</option>';
}
?>
