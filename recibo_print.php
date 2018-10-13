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

//var_dump($info);
// TEMPLATES
$cracha_base = file_get_contents("./include/cracha.xhtml");
$cracha_recibo = file_get_contents("./include/cracha_recibo.xhtml");
$titulo = "RECIBO";

//var_dump($cracha_base);
//echo $cracha_recibo;
//die();
// busca as fichas de inscricoes que solicitaram emissao de recibo

$_sql = "SELECT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_seq, d.ins_valor, i.ins_guiche,
        i.ev_id, i.owner_id||i.owner_tipo as responsavel, i.owner_id as resp_id, i.owner_tipo as resp_tipo, i.desc_vr_casal as desconto,
        trim(c.cmp_nome) as campo, c.cmp_estado as uf, v.vis_idade, v.vis_ts, v.vis_rh, v.vis_febre, d.valor_almoco,
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
                WHEN 'V' THEN trim(vr.vis_apelido) WHEN 'C' THEN trim(vr.vis_apelido) END as apelido_responsavel,
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
        WHERE i.ev_id={$_GET["eid"]} AND i.ins_status='1' AND d.ins_tmp='0' and i.ins_recibo='1' and i.ins_guiche ilike '{$_GET["guiche"]}%' 
        ORDER BY d.ins_id, d.ins_seq";


        $result = $db->sql_query($_sql);


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
$ins_ctrl = 0;
$ins_options = array();
while ($row = $db->sql_fetchrow($result)) {
    // verifica os opcionais
    $qry = "SELECT io.*, eo.descricao FROM ev_inscricao_options io "
            . "INNER JOIN ev_evento_options eo ON io.opt_id = eo.id "
            . "WHERE io.ins_id = {$row["ins_id"]} ORDER BY io.opt_id";
    $rsOpt = $db->sql_query($qry);
    while ($ropt = $db->sql_fetchrow($rsOpt)) {
        $ins_options[$ropt["ins_id"]][$ropt["opt_id"]]["nome"] = $ropt["descricao"];
        $ins_options[$ropt["ins_id"]][$ropt["opt_id"]]["qde"] = $ropt["quantidade"];
        $ins_options[$ropt["ins_id"]][$ropt["opt_id"]]["valor"] = $ropt["vr_unitario"];
    }
    if ($ins_ctrl != $row["ins_id"]) {
        $seq = 0;
        $ins_ctrl = $row["ins_id"];
    }
    $ins_inscricao[$row["ins_id"]]["desconto"] = $row["desconto"];
    $ins_inscricao[$row["ins_id"]]["referencia"] = $row["ins_guiche"];
    $ins_inscricao[$row["ins_id"]][$seq]["tipo"] = $row["owner_tipo"];
    $ins_inscricao[$row["ins_id"]][$seq]["nome"] = $row["nome"];
    $ins_inscricao[$row["ins_id"]][$seq]["apelido"] = $row["apelido"];
    $ins_inscricao[$row["ins_id"]][$seq]["valor"] = $row["ins_valor"];
    $ins_inscricao[$row["ins_id"]][$seq]["numero"] = $row["tipo_id"].trim(sprintf("%05d",$row["owner_id"]));
    $ins_inscricao[$row["ins_id"]][$seq]["owner"] = trim($row["owner_id"]).trim($row["owner_tipo"]);
    $ins_inscricao[$row["ins_id"]][$seq]["jantar"] = ($row["ins_jantar"] == "t" ? 1 : 0);
    if ($row["owner_tipo"] == "C") {
        if ($row["vis_idade"] <= $param["inscri_fx1"]) $valor = $params["vr_inscricao_crianca1"];
        elseif ($row["vis_idade"] <= $param["inscri_fx2"]) $valor = $params["vr_inscricao_crianca2"];
        else $valor = $params["vr_inscricao_crianca3"];
        $ins_recibo[$row["ins_id"]]["crianca"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                              "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"]." ({$row["vis_idade"]} anos)",
                                                                              "valor"=>$ins_inscricao[$row["ins_id"]][$seq]["valor"]);
    } else {
        $ins_recibo[$row["ins_id"]]["inscricao"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                                                     "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                                                     "valor"=>$params["vr_inscricao_membro"]);
        if ($row["ins_jantar"] == "t") {
            $ins_recibo[$row["ins_id"]]["jantar"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                                                      "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                                                     "valor"=>$params["vr_jantar_membro"]);
        }
        if ($row["valor_almoco"] > 0) {
            $ins_recibo[$row["ins_id"]]["almoco"][] = array("numero"=>$ins_inscricao[$row["ins_id"]][$seq]["numero"],
                                                                                                      "nome"=>$ins_inscricao[$row["ins_id"]][$seq]["nome"],
                                                                                                     "valor"=>$params["vr_almoco_auxiliar"]);
        }
    }
    $seq++;
}

if (count($ins_inscricao) > 0 OR count($ins_crianca) > 0) {
    // INSCRICOES CONVENCAO
    foreach($ins_inscricao as $inscricao => $cvalue) {
        $subtotal_recibo = 0;
        $total_recibo = 0;
        $dados = array_values($cvalue);
        $responsavel = "&nbsp;";
        $impressao = $cracha_prn;
        $impressao = str_replace("#recibo#", $cracha_recibo, $impressao);
        $recibo_inscricao = "";
        $recibo_jantar = "";
        $recibo_crianca = "";
        $recibo_transporte = "";
        $qdeCri = 0;
        $valorCri = 0;
        $desconto_recibo = 0;
        // RECIBO - INSCRICAO
        if (count($ins_recibo[$inscricao]["inscricao"]) > 0) {
            $recibo_inscricao = "<tr><td colspan='3' class='cracha_body_title'>Inscri&ccedil;&atilde;o para a Conven&ccedil;&atilde;o</td></tr>\n";
            foreach ($ins_recibo[$inscricao]["inscricao"] as $tmp) {
                $recibo_inscricao .= "<tr><td class=\"cracha_body\">{$tmp["numero"]} - {$tmp["nome"]}</td>".
                            "<td class=\"cracha_body_moeda\">

                            </td>".
                            "<td class=\"cracha_body_valor\">".
                                    //.number_format($tmp["valor"],2,",",".").
                            "</td></tr>";

                $subtotal_recibo += $tmp["valor"];
            }
        }
        // RECIBO - JANTAR
        if (count($ins_recibo[$inscricao]["jantar"]) > 0) {
            $recibo_jantar = "<tr><td colspan='3' class='cracha_body_title'>Jantar com os Pastores</td></tr>";
            foreach ($ins_recibo[$inscricao]["jantar"] as $tmp) {
                $recibo_jantar .= "<tr><td class=\"cracha_body\">{$tmp["numero"]} - {$tmp["nome"]}</td>".
                            "<td class=\"cracha_body_moeda\"></td>".
                            "<td class=\"cracha_body_valor\">".
                            //.number_format($tmp["valor"],2,",",".").
                            "</td></tr>";
                $subtotal_recibo += $tmp["valor"];
            }
        }
        // RECIBO - ALMOCO
        if (count($ins_recibo[$inscricao]["almoco"]) > 0) {
            $recibo_almoco = "<tr><td colspan='3' class='cracha_body_title'>Almoço das Auxiliares</td></tr>\n";
            foreach ($ins_recibo[$inscricao]["almoco"] as $tmp) {
                $recibo_almoco .= "<tr><td class=\"cracha_body\">{$tmp["numero"]} - {$tmp["nome"]}</td>".
                            "<td class=\"cracha_body_moeda\"></td>".
                            "<td class=\"cracha_body_valor\">".
                            //.number_format($tmp["valor"],2,",",".").
                            "</td></tr>";
                $subtotal_recibo += $tmp["valor"];
            }
        }
        // RECIBO - CRIANCA
        if (count($ins_recibo[$inscricao]["crianca"]) > 0) {
            $recibo_crianca = "<tr><td colspan='3' class='cracha_body_title'>Inscri&ccedil;&atilde;o de Crian&ccedil;a/Adolecente</td></tr>";
            foreach ($ins_recibo[$inscricao]["crianca"] as $tmp) {
                $recibo_crianca .= "<tr><td class=\"cracha_body\">{$tmp["numero"]} - {$tmp["nome"]}</td>".
                            "<td class=\"cracha_body_moeda\"></td>".
                            "<td class=\"cracha_body_valor\">".

                           // number_format($tmp["valor"],2,",",".").

                            "</td></tr>";
                $subtotal_recibo += $tmp["valor"];
                $qdeCri++;
                $valorCri += $tmp["valor"];
            }
        }
        // RECIBO - TRANSPORTE
        if (count($ins_options[$inscricao]) > 0) {
            foreach ($ins_options[$inscricao] as $tmpOpt) {
                $recibo_transporte .= "<tr><td class=\"cracha_body\">{$tmpOpt["nome"]} - {$tmpOpt["qde"]} x {$tmpOpt["valor"]} = </td>".
                            "<td class=\"cracha_body_moeda\">R$</td>\n".
                            "<td class=\"cracha_body_valor\">".number_format(($tmpOpt["qde"] * $tmpOpt["valor"]),2,",",".")."</td></tr>";
                $total_recibo += ($tmpOpt["qde"] * $tmpOpt["valor"]);
            }
        }
        if ($qdeCri > 1) {
            $desconto_recibo = $valorCri * 0.1;
        }
        $desconto_recibo += $ins_inscricao[$inscricao]["desconto"];

       

        $impressao = str_replace("#recibo_inscricao#", $recibo_inscricao, $impressao);
        $impressao = str_replace("#recibo_jantar#", $recibo_jantar, $impressao);
        $impressao = str_replace("#recibo_almoco#", $recibo_almoco, $impressao);
        $impressao = str_replace("#recibo_crianca#", $recibo_crianca, $impressao);
        $impressao = str_replace("#recibo_subtotal#", number_format($subtotal_recibo,2,",","."), $impressao);
        $impressao = str_replace("#recibo_transporte#", $recibo_transporte, $impressao);
        $impressao = str_replace("#recibo_desconto#", number_format($desconto_recibo,2,",","."), $impressao);
        $impressao = str_replace("#recibo_total#", number_format($subtotal_recibo + $total_recibo - $desconto_recibo,2,",","."), $impressao);
        $impressao = str_replace("#inscricao_id#", $inscricao, $impressao);
        $impressao = str_replace("#referencia#", substr(md5("39a$inscricao Recife/PE"),0,15)." [ {$cvalue["referencia"]} ]", $impressao);

        echo $impressao;
        
        $qry = "UPDATE ev_inscricao SET ins_recibo = '0' WHERE ins_id = $inscricao";
        $db->sql_query($qry);
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
    <body>
    </body>
</html>

<?php
}
?>
