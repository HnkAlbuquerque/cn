<?php
require_once("adodb/adodb.inc.php");


class Gideoes {

    var $conn = NULL;

    function Gideoes() {
        $this->conn =& GidConn();
    }

    function getBanco()
    {
        $qry = "SELECT * FROM bancos WHERE nome = 'ITAU'";
        $rs = $this->conn->Execute($qry);
        return $rs -> fields;
    }

    function getBoletoCarne($number,$type,$typeBoleto='L',$idboleto = null) {
        if ($idboleto == null)
        {
            $num_boleto = '';
        }
        else
        {
            $num_boleto = "and b.id = $idboleto";
        }

       /* $qry = "SELECT b.id as nosso_numero, b.codigo as sacado_id, b.tipo_codigo as sacado_tipo,
            b.bol_valor as valor, b.bol_valor_desc as desconto, to_char(b.bol_dt_venc,'dd/mm/yyyy') as vencimento, 
            to_char(b.bol_dt_emiss,'dd/mm/yyyy') as processamento, b.ins_texto as instrucoes, 
            b.inf_sacado as info_sacado, c.cont_numero as conta, c.cont_digito as digito, c.cont_agencia as agencia,
            CASE b.tipo_codigo 
                WHEN 'G' THEN a.as_nome 
                WHEN 'A' THEN a.as_nome
                WHEN 'I' THEN i.igr_nome 
                WHEN 'T' THEN t.ter_nome
            END as sacado_nome,
            CASE b.tipo_codigo 
                WHEN 'G' THEN trim(a.as_end)||', '||a.as_num||
                    CASE WHEN a.as_compl IS NULL THEN '' ELSE ' / '||a.as_compl END
                    ||' - '||a.as_bairro
                WHEN 'A' THEN trim(a.as_end)||', '||a.as_num||
                    CASE WHEN a.as_compl IS NULL THEN '' ELSE ' / '||a.as_compl END
                    ||' - '||a.as_bairro
                WHEN 'I' THEN trim(i.end_igr_res_nome)||','||i.end_igr_res_num||
                    CASE WHEN i.end_igr_res_comp IS NULL THEN '' ELSE ' / '||trim(i.end_igr_res_comp) END
                    ||' - '||i.end_igr_res_bairro
                WHEN 'T' THEN trim(t.ter_end)||','||t.ter_num||
                    CASE WHEN t.ter_compl IS NULL THEN '' ELSE ' / '||trim(t.ter_compl) END
                    ||' - '||t.ter_bairro
            END as sacado_end1,
            CASE b.tipo_codigo 
                WHEN 'G' THEN trim(a.as_cidade)||' / '||a.as_estado||' - CEP '||to_char(a.as_cep::int,'00000-999')
                WHEN 'A' THEN trim(a.as_cidade)||' / '||a.as_estado||' - CEP '||to_char(a.as_cep::int,'00000-999')
                WHEN 'I' THEN trim(i.end_igr_res_cidade)||' / '||i.end_igr_res_estado||
                    ' - CEP '||to_char(i.end_igr_res_cep::int,'00000-999')
                WHEN 'T' THEN
                    CASE WHEN trim(t.ter_cidade) = '' THEN '' ELSE trim(t.ter_cidade)||' / '||t.ter_estado||
                        CASE WHEN trim(t.ter_cep) = '' THEN '' ELSE ' - CEP '||to_char(t.ter_cep::int,'00000-999') END
                    END
            END as sacado_end2,
            CASE b.tipo_codigo
                WHEN 'T' THEN trim(regexp_replace(t.ter_cpf, '[^[:digit:]]', '','g'))
                WHEN 'G' THEN trim(regexp_replace(a.as_cpf, '[^[:digit:]]', '','g'))
            END as doc_id
            FROM boleto b
            LEFT JOIN associado a ON b.codigo = a.as_cod AND b.tipo_codigo = a.as_tipo
            LEFT JOIN terceiros t ON b.codigo = t.ter_id AND b.tipo_codigo = 'T'
            LEFT JOIN ig_igreja i ON b.codigo = i.igr_id AND b.tipo_codigo = 'I'
            INNER JOIN conta c ON b.cont_cod=c.cont_cod
            WHERE b.bol_tit_liq = 'N' AND b.inf_sacado ilike 'Oferta mensal%' 
                                      AND b.codigo = $number 
                                      AND b.tipo_codigo='$type' 
                                      AND b.tipo_boleto='$typeBoleto' 
            ORDER BY b.bol_dt_venc";*/

            $qry = "SELECT b.id as nosso_numero, b.idcliente as sacado_id, b.tipo_cliente as sacado_tipo,
            b.valor as valor, to_char(b.dt_vencto,'dd/mm/yyyy') as vencimento, 
            to_char(b.dt_created,'dd/mm/yyyy') as processamento, b.st_instrucao as instrucoes, 
            b.st_descricao as info_sacado, 4046 as conta, 7 as digito, 7643 as agencia, 
            CASE b.tipo_cliente  
                WHEN 'G' THEN a.as_nome  
                WHEN 'A' THEN a.as_nome 
                WHEN 'I' THEN i.igr_nome  
                WHEN 'T' THEN t.ter_nome 
            END as sacado_nome,
            CASE b.tipo_cliente 
                WHEN 'G' THEN trim(a.as_end)||', '||a.as_num|| 
                    CASE WHEN a.as_compl IS NULL THEN '' ELSE ' / '||a.as_compl END 
                    ||' - '||a.as_bairro 
                WHEN 'A' THEN trim(a.as_end)||', '||a.as_num|| 
                    CASE WHEN a.as_compl IS NULL THEN '' ELSE ' / '||a.as_compl END 
                    ||' - '||a.as_bairro 
                WHEN 'I' THEN trim(i.end_igr_res_nome)||','||i.end_igr_res_num|| 
                    CASE WHEN i.end_igr_res_comp IS NULL THEN '' ELSE ' / '||trim(i.end_igr_res_comp) END 
                    ||' - '||i.end_igr_res_bairro 
                WHEN 'T' THEN trim(t.ter_end)||','||t.ter_num|| 
                    CASE WHEN t.ter_compl IS NULL THEN '' ELSE ' / '||trim(t.ter_compl) END 
                    ||' - '||t.ter_bairro 
            END as sacado_end1, 
            CASE b.tipo_cliente 
                WHEN 'G' THEN trim(a.as_cidade)||' / '||a.as_estado||' - CEP '||to_char(a.as_cep::int,'00000-999') 
                WHEN 'A' THEN trim(a.as_cidade)||' / '||a.as_estado||' - CEP '||to_char(a.as_cep::int,'00000-999') 
                WHEN 'I' THEN trim(i.end_igr_res_cidade)||' / '||i.end_igr_res_estado|| 
                    ' - CEP '||to_char(i.end_igr_res_cep::int,'00000-999') 
                WHEN 'T' THEN 
                    CASE WHEN trim(t.ter_cidade) = '' THEN '' ELSE trim(t.ter_cidade)||' / '||t.ter_estado|| 
                        CASE WHEN trim(t.ter_cep) = '' THEN '' ELSE ' - CEP '||to_char(t.ter_cep::int,'00000-999') END 
                    END 
            END as sacado_end2,
            CASE b.tipo_cliente 
                WHEN 'T' THEN trim(regexp_replace(t.ter_cpf, '[^[:digit:]]', '','g')) 
                WHEN 'G' THEN trim(regexp_replace(a.as_cpf, '[^[:digit:]]', '','g')) 
            END as doc_id 
            FROM boleto_reg b 
            LEFT JOIN associado a ON b.idcliente = a.as_cod AND b.tipo_cliente = a.as_tipo 
            LEFT JOIN terceiros t ON b.idcliente = t.ter_id AND b.tipo_cliente = 'T' 
            LEFT JOIN ig_igreja i ON b.idcliente = i.igr_id AND b.tipo_cliente = 'I' 
            --INNER JOIN conta c ON b.idtipo=c.cont_cod
            WHERE b.status= 'N' 
                                      AND b.tipo_cliente='T'  
                                      AND b.tipo_boleto='L'  
                                      AND b.idcliente = 38527 
            ORDER BY b.idcliente,b.dt_vencto";

            //echo $qry;

        $rs = $this->conn->Execute($qry);
        if (!$rs) {
            print $this->conn->ErrorMsg()."<br>$qry";
            return false;
        }
        if ($rs->_numOfRows == 0) {
            $ret = NULL;
        } else {
            while (!$rs->EOF) {
                $ret[] = $rs->fields;
                $rs->MoveNext();
            }
        }
        return $ret;
    }
}

function GidConn() {
    $conn =& ADONewConnection("postgres7");
    $conn->debug = false;
    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
    $conn->Connect("db-gideon.gideoes.org.br", "oracle", "deybacsac4", "gideoes");
    return $conn;
}


?>
