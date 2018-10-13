<?php
session_start();
require_once('../header.php');

//require_once('../mainfile.php');

define('FPDF_FONTPATH','/home/oracle/public_html/online/cn/fpdf152/font/');
require('../fpdf152/fpdf.php');

//echo "a";

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

if (isset($_POST["order"]) AND strlen(trim($_POST["order"])) > 0)
	$order = "{$_POST["order"]} {$_POST["sequ"]}";
else
	$order = "nome";


$_sql = "SELECT d.ins_id, d.owner_id, d.owner_tipo, d.ins_jantar, d.ins_pastor, d.ins_seq, i.ev_id,
		g.nm_regiao||'.'||g.idestadual||'.'||g.nm_area||'.'||g.idcampo as geo_cod,  
		CASE d.owner_tipo 
			WHEN 'G' THEN sem_acentos(trim(a.as_nome))  
			WHEN 'A' THEN sem_acentos(trim(a.as_nome))
			WHEN 'V' THEN sem_acentos(trim(v.vis_nome)) 
			WHEN 'C' THEN sem_acentos(trim(v.vis_nome))||' ('||v.vis_idade||' anos)' 
		END as nome,
		CASE d.owner_tipo 
			WHEN 'G' THEN g.idcampo||' / '||g.nm_campo 
			WHEN 'A' THEN g.idcampo||' / '||g.nm_campo 
			WHEN 'V' THEN 'VISITANTE' 
			WHEN 'C' THEN '('||v.vis_idade||' anos)' 
		END as meio,
		CASE d.owner_tipo 
			WHEN 'G' THEN 
						case when length(a.as_apelido) > 0 
						then trim(a.as_apelido) 
						else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
						end
			WHEN 'A' THEN 
						case when length(a.as_apelido) > 0 
						then trim(a.as_apelido) 
						else substring(a.as_nome from 1 for position(' ' in a.as_nome)) 
						end			 
			WHEN 'V' THEN 
						case when length(v.vis_apelido) > 0 
						then trim(v.vis_apelido) 
						else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
						end
			WHEN 'C' THEN 
						case when length(v.vis_apelido) > 0 
						then trim(v.vis_apelido) 
						else substring(v.vis_nome from 1 for position(' ' in v.vis_nome)) 
						end 
		END as apelido
		FROM ev_inscricao_detail d 
		INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
		LEFT JOIN associado a ON d.owner_id=a.as_cod AND d.owner_tipo=a.as_tipo
		LEFT JOIN visitante v ON d.owner_id=v.vis_id AND d.owner_tipo=v.vis_tipo
		LEFT JOIN geo.geografia g ON a.cmp_cod=g.idcampo and g.periodo = $geoperiodo 
		WHERE i.ev_id={$_SESSION['gsr']['ev_id']} and i.ins_status='1'";
//print_r($_SESSION);
//echo $_sql."<br>";
if (isset($_POST["f.ins_status"]) AND $_POST["f.ins_status"] != "-")
	$_sql .= " AND i.ins_status = ". $_POST["f.ins_status"];
if (isset($_POST["f_owner_tipo"]) AND $_POST["f_owner_tipo"] != '-')
	$_sql .= " AND d.owner_tipo = '". $_POST["f_owner_tipo"] ."'";
if (isset($_POST["f.ins_jantar"]) AND $_POST["f.ins_jantar"] > 0)
	$_sql .= " AND d.ins_jantar = ". $_POST["f.ins_jantar"];

$_sql .= " ORDER BY nome, d.ins_seq";

//echo $_sql;
//print_r($_POST);
//exit;

$result = $db->SetFetchMode(ADODB_FETCH_ASSOC);
$result = $db->Execute($_sql);

//$result = $db->sql_query($_sql);

//echo $result;

$aBody = array();

$regs=0;
$insID=0;
$cTempCrianca=0; $cTempInscr=0; $cTempJantar=0; $cTemp="";
//while ($row = $db->sql_fetchrow($result)){
foreach ($result as $temporario) {
	
	
	$row = $result -> fields;
		//echo "começo<br>";

	$regs++;

	switch ($row["owner_tipo"]) {

		case 'G':
			$numero = "00";
			
			break;
		case 'A':
			$numero = "01";
			
			break;
		case 'C':
			$numero = "98";
			
			break;
		case 'V':
			$numero = "99";
			
			break;
	}


	$inscricao = $row["meio"];
	$numero .= sprintf("%05d",$row["owner_id"]);
	$nome = ucwords(strtolower(trim($row["apelido"])));
	
	if ($insID == 0) {

		$insID = $row["ins_id"];
		$indice = $row["ins_id"].$row["owner_id"];
		$aBody[$indice][0] = sprintf("%07d",$row["ins_id"]);
		$aBody[$indice][1] = $inscricao;
		$aBody[$indice][2] = $nome;	
		$aBody[$indice][3]++;
		$aBody[$indice][4]++;
		$aBody[$indice][5]++;

		
	}

	$rs = $result->RecordCount();

	if ($insID != $row["ins_id"] OR $regs == $rs) {

		$insID = $row["ins_id"];
		$indice = $row["ins_id"].$row["owner_id"];
		$aBody[$indice][0] = sprintf("%07d",$row["ins_id"]);
		$aBody[$indice][1] = $inscricao;
		$aBody[$indice][2] = $nome;	
		$aBody[$indice][3]++;
		$aBody[$indice][4]++;
		$aBody[$indice][5]++;

	}

	//echo "fim<br>";
}

		



/*$_sql = "SELECT i.ins_id, i.owner_id, i.owner_tipo, i.ev_id,
		CASE i.owner_tipo WHEN 'G' THEN trim(a.as_nome) WHEN 'A' THEN trim(a.as_nome)
			WHEN 'V' THEN trim(v.vis_nome) WHEN 'C' THEN trim(v.vis_nome) END as nome
		FROM ev_inscricao i 
		LEFT JOIN associado a ON i.owner_id=a.as_cod AND i.owner_tipo=a.as_tipo 
		LEFT JOIN visitante v ON i.owner_id=v.vis_id AND i.owner_tipo=v.vis_tipo 
		LEFT JOIN geo.geografia g ON a.cmp_cod=g.idcampo and g.periodo = $geoperiodo 
		--LEFT JOIN lico l ON a.cmp_cod=l.cmp_cod
		WHERE i.ev_id={$_SESSION['gsr']['ev_id']} and i.ins_status = '1'";
//echo $_sql."<br>";
//echo "recebeu segunda query<bR>";
if (isset($_POST["f.ins_status"]) AND $_POST["f.ins_status"] != "-")
	$_sql .= " AND i.ins_status = ". $_POST["f.ins_status"];
if (isset($_POST["f.owner_tipo"]) AND $_POST["f.owner_tipo"] != '-')
	$_sql .= " AND d.owner_tipo = '". $_POST["f.owner_tipo"] ."'";
if (isset($_POST["f.ins_jantar"]) AND $_POST["f.ins_jantar"] > 0)
	$_sql .= " AND d.ins_jantar = ". $_POST["f.ins_jantar"];
$_sql .= " ORDER BY ". $_POST["order"];

$result2 = $db->SetFetchMode(ADODB_FETCH_ASSOC);
$result2 = $db->Execute($_sql);*/

$aBody1 = array();
$aBody2 = array();

$col = 1;

foreach ($result as $temporario) {

	$row = $result -> fields;
	$indice = $row["ins_id"].$row["owner_id"];
	$temp = array(	$aBody[$indice][0], 
					$aBody[$indice][1], 
					$aBody[$indice][2], 
					number_format($aBody[$indice][3],0), 
					number_format($aBody[$indice][5],0), 
					number_format($aBody[$indice][4],0)
				 );

	if ($col == 1) 
		{ 
			$aBody1[] = $temp; $col = 2; 
		}
	else 
		{ 
			$aBody2[] = $temp; $col = 1; 
		}
	//echo "fim do segundo foreach<br>";

}


$nomearquivo = "etiqueta_convencao.pdf";

$nLnEti = 10; // numero de linhas de etiquetas

$tam_pag = "Letter"; // tamanho do papel
$margin_left = 5;
$margin_right = 5;
$margin_top = 13;
$margin_bottom = 13;
$wCols=array(100,5,100);

if ($_POST["tam_eti"] == "6281") {
	$tam_pag = array(215.9,279.4);
	$tam_eti = array("h"=>25.4,"w"=>101.6,"ml"=>3.85);
	$margin_left = 0;
	$margin_right = 0;
	$margin_top = 8.2;
	$margin_bottom = 10.2;
	$wCols=array(101.6,5.0,101.6);
} elseif ($_POST["tam_eti"] == "6282") {
	$tam_pag = array(215.9,279.4);
	$margin_left = 0;
	$margin_right = 0;
	$margin_top = 19.2;
	$margin_bottom = 19.2;
	$wCols=array(113.76,5.16,101.6);
} elseif ($_POST["tam_eti"] == "A4262") {
	$tam_pag = array(210,297);
	$margin_left = 4.7;
	$margin_right = 4.7;
	$margin_top = 12.9;
	$margin_bottom = 12.9;
	$wCols=array(99,2.6,99);
} elseif ($_POST["tam_eti"] == "8936") {
	$tam_pag = array(180,330);
	$margin_left = 4.7;
	$margin_right = 4.7;
	$margin_top = 5;
	$margin_bottom = 0;
	$wCols=array(100,10,100);
}
if (isset($_POST["margin_top"]) AND $_POST["margin_top"] != "") $margin_top=$_POST["margin_top"];
if (isset($_POST["margin_bottom"]) AND $_POST["margin_bottom"] != "") $margin_bottom=$_POST["margin_bottom"];
if (isset($_POST["margin_left"]) AND $_POST["margin_left"] != "") $margin_left=$_POST["margin_left"];
if (isset($_POST["margin_right"]) AND $_POST["margin_right"] != "") $margin_right=$_POST["margin_right"];

//echo "recebeu os parametros<br>";

class PDF extends FPDF
{
	function TableData($col1,$col2)
	{
		global $wCols, $nLnEti, $tam_eti, $margin_left;
		$hRow=4;
		$nLn = 0;
		for($nA=0; $nA < count($col1); $nA++) {


			$this->SetFont('Arial','B',13);
			$this->Cell($wCols[0],$hRow,$col1[$nA][2],0,0,'C');
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2],$hRow,$col2[$nA][2],0,0,'C');
			$this->SetFont('Arial','',9);
			$this->Ln();
			$this->Cell($wCols[0],$hRow,$col1[$nA][1],0,0,'C');
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2],$hRow,$col2[$nA][1],0,0,'C');
			$this->Ln();
			$this->Cell($wCols[0]-5,$hRow,"Inscrição: ".$col1[$nA][0],0,0,'C');
			$this->Cell(5,$hRow,"");
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2]-5-($margin_left-$tam_eti["ml"]),$hRow,"Inscrição: ".$col2[$nA][0],0,0,'C');
			$this->Cell(5,$hRow,"");
			$this->Ln();
			$this->Cell($wCols[0],$hRow," ");
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2],$hRow," ");
			$this->Ln();
			$this->Cell($wCols[0],$hRow," ");
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2],$hRow," ");
			$this->Ln();
			$this->Cell($wCols[0],$hRow," ");
			$this->Cell($wCols[1],$hRow,' ');
			$this->Cell($wCols[2],$hRow," ");
			$nLn++;
			if ($nLn == $nLnEti AND $nA < count($col1)) {
				$this->AddPage();
				$nLn = 0;
			} else {
				$this->Ln();
				if (isset($tam_eti) AND is_array($tam_eti)) $this->Cell(0,$tam_eti["h"]-($hRow*6),"");
				elseif ($_POST["tam_eti"] == "8936") $this->Cell($wCols[2],17.79," ");
				elseif ($_POST["tam_eti"] == "6281") $this->Cell($wCols[2],2.4," ");
				else $this->Cell($wCols[2],11.9," ");
				$this->Ln();
			}
		}
	}
}

$pdf=new PDF("P","mm",$tam_pag);
$pdf->SetFont('Arial','',9);
$pdf->SetMargins($margin_left,$margin_top,$margin_right);
$pdf->SetAutoPageBreak(1,2.12);
$pdf->AddPage('P');
$pdf->TableData($aBody1,$aBody2);
$pdf->Output("$nomearquivo",'D'); 

?>

