<?php
require_once('config.php');
require_once('mainfile2.php');

include_once('functions/functions.php');

$sql_info = "select 'De '||to_char(ev_dt_ini,'DD/MM/YYYY') || ' a '|| to_char(ev_dt_fim,'DD/MM/YYYY') as ev_dt, ev_nome, 'N' as tp, 
        to_char(ev_dt_ini,'DD/MM/YYYY') as dtini, to_char(ev_dt_fim,'DD/MM/YYYY') as dtfim,to_char(ev_dt_ini,'DD') as evdiaini, 
        to_char(now(),'DD/MM/YYYY') as dthoje,  to_char(ev_dt_fim,'DD') as evdiafim , to_char(ev_dt_fim,'MM')::int as evmesfim, to_char(ev_dt_fim,'YYYY') as evano 
            from ev_evento 
            where ev_id = {$_GET["eid"]}";

$info = $db->sql_query($sql_info);
$info = $db->sql_fetchrow($info);

// TEMPLATES
$cracha_base = file_get_contents("./include/cracha.xhtml");
$cracha_cracha = file_get_contents("./include/cracha_cracha.xhtml");
$cracha_ficha = file_get_contents("./include/cracha_ficha.xhtml");

$titulo = "FICHA INFANTO-JUVENIL";

// busca as fichas de inscricoes nao emitidas
$_sql = "SELECT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_seq, i.ins_guiche, 
        i.ev_id, i.owner_id||i.owner_tipo as responsavel, i.owner_id as resp_id, i.owner_tipo as resp_tipo,
        trim(c.cmp_nome) as campo, c.cmp_estado as uf, v.vis_idade, v.vis_ts, v.vis_rh, v.vis_febre,
        v.vis_febre_med, v.vis_rest_alim, v.vis_rest_alim_qual, v.vis_alergia, v.vis_alergia_qual,
        l.reg_cod||'.'||l.aest_cod||'.'||l.lider||'.'||l.cmp_cod as geo_id, ct.tipo_id,
        CASE d.owner_tipo WHEN 'G' THEN trim(a.as_nome) WHEN 'A' THEN trim(a.as_nome)
                WHEN 'V' THEN trim(v.vis_nome) WHEN 'C' THEN trim(v.vis_nome) END as nome,
        CASE d.owner_tipo WHEN 'G' THEN trim(a.as_apelido) WHEN 'A' THEN trim(a.as_apelido)
                WHEN 'V' THEN trim(v.vis_apelido) WHEN 'C' THEN trim(v.vis_apelido) END as apelido,
        CASE i.owner_tipo
                WHEN 'G' THEN trim(ar.as_nome) WHEN 'A' THEN trim(ar.as_nome)
                WHEN 'V' THEN trim(vr.vis_nome) WHEN 'C' THEN trim(vr.vis_nome) END as nome_reponsavel,
        CASE i.owner_tipo
                WHEN 'G' THEN trim(ar.as_apelido) WHEN 'A' THEN trim(ar.as_apelido)
                WHEN 'V' THEN trim(vr.vis_apelido) WHEN 'C' THEN trim(vr.vis_resp) END as apelido_responsavel,
        CASE i.owner_tipo
                WHEN 'G' THEN trim(ar.as_fone_cel) WHEN 'A' THEN trim(ar.as_fone_cel)
                WHEN 'V' THEN trim(vr.vis_fone) WHEN 'C' THEN trim(vr.vis_fone) END as fone
        FROM ev_inscricao_detail d
        INNER JOIN ca_tipo ct ON d.owner_tipo = ct.as_tipo
        INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
        LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
        LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo
        LEFT JOIN campo c ON a.cmp_cod=c.cmp_cod
        LEFT JOIN lico l ON a.cmp_cod=l.cmp_cod
        LEFT JOIN associado ar ON i.owner_id=ar.as_cod AND i.owner_tipo=ar.as_tipo
        LEFT JOIN visitante vr ON i.owner_id=vr.vis_id AND i.owner_tipo=vr.vis_tipo
        WHERE (i.ev_id={$_GET["eid"]} AND d.ins_ficha = '0' AND i.ins_status='1' AND d.ins_tmp='0' and d.owner_tipo = 'C' and i.ins_guiche ilike '{$_GET["guiche"]}%')";

$_sql .= " ORDER BY d.ins_id, d.ins_seq";


$result = $db->sql_query($_sql); 


echo "<!--\n$_sql\n-->";

	 $logo = "imgs/logo_gid.gif";
	 $logo20 = "imgs/logo_gid_20porcento.gif";
	 $logo20_cracha = "imgs/logo_gid_20porcento_cracha.gif";



$cracha_prn = str_replace("#titulo#", $titulo, $cracha_base);
$cracha_prn = str_replace("#cracha#", $cracha_cracha, $cracha_prn);
$cracha_prn = str_replace("#titulo_evento#", $info["ev_nome"], $cracha_prn);
$cracha_prn = str_replace("#logo#", $logo, $cracha_prn);

$cols = array();
$insID=0; $nVis=0; $nChl=0; $insCod="";
$membro=false;
$mem_inscr=""; $mem_jantar = ""; $vis_inscr=array(); $cracha=array();
$vis_jantar=""; $crianca=array(); $crianca_rec=array(); $tot_recibo=array();
$regs = 0;
$ins_membro = array();
$ins_visitante = array();
$ins_crianca = array();
$ins_ctrl = 0;

while ($row = $db->sql_fetchrow($result)) {
    if ($ins_ctrl != $row["ins_id"]) {
        $seq = 0;
        $ins_ctrl = $row["ins_id"];
    }
    $ins_inscricao[$row["ins_id"]][$seq]["tipo"] = $row["owner_tipo"];
    $ins_inscricao[$row["ins_id"]][$seq]["nome"] = $row["nome"];
    $ins_inscricao[$row["ins_id"]][$seq]["apelido"] = $row["apelido"];
    $ins_inscricao[$row["ins_id"]][$seq]["numero"] = $row["tipo_id"].trim(sprintf("%05d",$row["owner_id"]));
    $ins_inscricao[$row["ins_id"]][$seq]["owner"] = trim($row["owner_id"]).trim($row["owner_tipo"]);
    $ins_inscricao[$row["ins_id"]][$seq]["jantar"] = ($row["ins_jantar"] == "t" ? 1 : 0);
    if ($row["owner_tipo"] == "C") {
        $ins_crianca[$row["ins_id"]]["referencia"] = $row["ins_guiche"];
        if (trim($row["apelido_responsavel"]) == "") {
            $mem_apelido = explode(" ",trim($row["nome_reponsavel"]));
            $ins_crianca[$row["ins_id"]][$seq]["responsavel"] = $mem_apelido[0];
        } else {
            $ins_crianca[$row["ins_id"]][$seq]["responsavel"] = trim($row["apelido_responsavel"]);
        }
        $ins_crianca[$row["ins_id"]][$seq]["fone"] = trim($row["fone"]);
        $ins_crianca[$row["ins_id"]][$seq]["idade"] = trim($row["vis_idade"]);
        $ins_crianca[$row["ins_id"]][$seq]["tipo_sanguineo"] = "{$row["vis_ts"]}{$row["vis_rh"]}";
        $ins_crianca[$row["ins_id"]][$seq]["febre_nao"] = $row["vis_febre"] == 0 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["febre_sim"] = $row["vis_febre"] == 1 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["febre"] = $row["vis_febre_med"];
        $ins_crianca[$row["ins_id"]][$seq]["alergia_nao"] = $row["vis_alergia"] == 0 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["alergia_sim"] = $row["vis_alergia"] == 1 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["alergia"] = $row["vis_alergia_qual"];
        $ins_crianca[$row["ins_id"]][$seq]["restricao_nao"] = $row["vis_rest_alim"] == 0 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["restricao_sim"] = $row["vis_rest_alim"] == 1 ? "X" : "&nbsp;&nbsp;";
        $ins_crianca[$row["ins_id"]][$seq]["restricao"] = $row["vis_rest_alim_qual"];
        if ($row["vis_idade"] <= $param["inscri_fx1"]) $valor = $params["vr_inscricao_crianca1"];
        elseif ($row["vis_idade"] <= $param["inscri_fx2"]) $valor = $params["vr_inscricao_crianca2"];
        else $valor = $params["vr_inscricao_crianca3"];
        $ins_recibo[$row["ins_id"]][$row["responsavel"]]["crianca"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                              "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                              "valor"=>$valor);
    } else {
        $ins_recibo[$row["ins_id"]]["{$row["owner_id"]}{$row["owner_tipo"]}"]["inscricao"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                                                     "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                                                     "valor"=>$params["vr_inscricao_membro"]);
        if ($row["ins_jantar"] == "t") {
            $ins_recibo[$row["ins_id"]]["{$row["owner_id"]}{$row["owner_tipo"]}"]["jantar"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                                                      "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                                                     "valor"=>$params["vr_jantar_membro"]);
        }
    }
    $seq++;
}

//echo count($ins_crianca).count(ins_inscricao);


if (count($ins_inscricao) > 0 OR count($ins_crianca) > 0) {
    // INSCRICOES CONVENCAO
    foreach($ins_inscricao as $inscricao => $cvalue) {
        $total_recibo = 0;
        foreach ($cvalue as $seq => $dados) {
            $responsavel = "&nbsp;";
            $impressao = $cracha_prn;

            if ($dados["tipo"] == "C") {
                $impressao = str_replace("#recibo#", $cracha_ficha, $impressao);
                $responsavel = $ins_crianca[$inscricao][$seq]["responsavel"]." / Fone: ".$ins_crianca[$inscricao][$seq]["fone"];
                $impressao = str_replace("#idade#", $ins_crianca[$inscricao][$seq]["idade"], $impressao);
                $impressao = str_replace("#tipo_sanguineo#", $ins_crianca[$inscricao][$seq]["tipo_sanguineo"], $impressao);
                $impressao = str_replace("#febre_nao#", $ins_crianca[$inscricao][$seq]["febre_nao"], $impressao);
                $impressao = str_replace("#febre_sim#", $ins_crianca[$inscricao][$seq]["febre_sim"], $impressao);
                $impressao = str_replace("#febre#", mb_convert_case($ins_crianca[$inscricao][$seq]["febre"],MB_CASE_UPPER)."&nbsp;", $impressao);
                $impressao = str_replace("#alergia_nao#", $ins_crianca[$inscricao][$seq]["alergia_nao"], $impressao);
                $impressao = str_replace("#alergia_sim#", $ins_crianca[$inscricao][$seq]["alergia_sim"], $impressao);
                $impressao = str_replace("#alergia#", mb_convert_case($ins_crianca[$inscricao][$seq]["alergia"],MB_CASE_UPPER)."&nbsp;", $impressao);
                $impressao = str_replace("#restricao_nao#", $ins_crianca[$inscricao][$seq]["restricao_nao"], $impressao);
                $impressao = str_replace("#restricao_sim#", $ins_crianca[$inscricao][$seq]["restricao_sim"], $impressao);
                $impressao = str_replace("#restricao#", mb_convert_case($ins_crianca[$inscricao][$seq]["restricao"],MB_CASE_UPPER)."&nbsp;", $impressao);
            } 


            $impressao = str_replace("#inscricao_id#", $inscricao, $impressao);
            $impressao = str_replace("#nome#", mb_convert_case($dados["nome"],MB_CASE_UPPER), $impressao);
            $impressao = str_replace("#apelido#", $dados["apelido"], $impressao);
            $impressao = str_replace("#numero#", $dados["numero"], $impressao);
            $impressao = str_replace("#responsavel#", $responsavel, $impressao);
            $impressao = str_replace("#referencia#", substr(md5("41a$inscricao Cuiaba/MT"),0,15)." [ {$ins_crianca[$inscricao]["referencia"]} ]", $impressao);
            echo $impressao;
            $qry = "UPDATE ev_inscricao_detail SET ins_ficha = '1' WHERE ins_id = $inscricao";
            $db->sql_query($qry);
        }
    }
} else {
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="Expires" content="0"/>
        <meta http-equiv="Refresh" content="5" />
        <meta name="Resource-Type" content="document"/>
        <meta name="Distribution" content="global"/>
        <meta name="Author" content="Os Gideoes Internacionais no Brasil"/>
        <meta name="Copyright" content="Copyright (c) by Os Gideoes Internacionais no Brasil"/>
        <link rel="shortcut icon" type="image/x-icon" href="gideoes.ico" />
        <title>:: <?=$titulo?> ::</title>
    </head>
    <body>***
    </body>
</html>

<?php
}
?>
