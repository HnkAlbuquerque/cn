<?php
require_once("db/db.php");

/*--------------------------------------------------*\
Action: create box for navigation options
Params: boxId - Id to box,
		header - title in box,
		link - array width:
			linkHref - link in item,
			linkTitle - text for hint in mouse over,
			linkText - text the item
			linkType - style class for type link
\*--------------------------------------------------*/
function PortletNavigation($boxId, $boxHeader="", $aLink=array(), $selec="") {
	$ret = "<dl class='portlet' id='$boxId'>";
	if (strlen($boxHeader) > 0) {
            $ret .= "<dt class='portletHeader'>$boxHeader</dt>";
        }
	if (is_array($aLink) AND count($aLink) > 0) {
		$ret .= "<dd class='portletItem'>
				<ul class='portletNavigationTree navTreeLevel0'>";
		foreach ($aLink as $item => $valor) {
                    $target = "";
                    if (isset($valor["linkTarget"])) {
                        $target = " target='{$valor["linkTarget"]}'";
                    }
                    $ret .= "<li class='navTreeItem'>
                                <div class='{$valor["linkType"]}'>
                                    <a class='".($valor["refe"]==$selec?"navTreeCurrentItem":"state-published")." visualIconPadding' href='"._DOC_ROOT."/{$valor["linkHref"]}' title='{$valor["linkTitle"]}'$target> {$valor["linkText"]}</a>
                                </div>
                            </li>";
		}
		$ret .= "</ul></dd>";
	}
	$ret .= "</dl>";
	return $ret;
}

/*--------------------------------------------------*\
Action: display menu top and personal tools bar
Params: none
\*--------------------------------------------------*/
function pageTop() {
	global $_URL;
	echo "<div id='portal-top'>";
	if ($_SERVER["QUERY_STRING"] != "ins_hospeda&evid=22") {
		echo "<div id='portal-header'>
                        <ul id='portal-globalnav'>
                                <li id='portaltab-index_html' class='".(file_exists("{$_URL[0]}.php")?"plain":"selected")."'>
                                    <a href='"._DOC_ROOT_AJAX."/?index_html&t=".time()."' title='Pagina Inicial'>Home</a></li>
                                <li id='portaltab-inscricao' class='".($_URL[0]=="inscricao"?"selected":"plain")."'>
                                    <a href='"._DOC_ROOT_AJAX."/?inscricao&t=".time()."' title='Inscricao no Evento'>Inscri&ccedil;&otilde;es</a></li>
                                <li id='portaltab-report' class='".($_URL[0]=="report"?"selected":"plain")."'>
                                    <a href='"._DOC_ROOT_AJAX."/?report&t=".time()."' title='Emissao de Relatorios e Listagens'>Relat&oacute;rios</a></li>
                                <li id='portaltab-params' class='".($_URL[0]=="params"?"selected":"plain")."'>
                                    <a href='"._DOC_ROOT_AJAX."/?params&t=".time()."' title='Manutencao de Parametros do Sistema'>Configura&ccedil;&atilde;o</a></li>";
//                                <li id='portaltab-cracha' class='".($_URL[0]=="cracha"?"selected":"plain")."'>
//                                    <a href='"._DOC_ROOT_AJAX."/?cracha&t=".time()."' title='Imprimir Cracha de Identificacao'>Emitir Crach&aacute;</a></li>";
		echo "	</ul>
					</div>";
	}
	echo "	<div style='color:#436976; font-size:90%; float:right; position:absolute; top:0.2em; right:0.5em;'><b>{$_SESSION["evno"]}</b></div>
				<div id='portal-personaltools'>"
						 .(isset($_SESSION["uid"])?"{$_SESSION["unm"]} &mdash; <a href='?logout&t=".time()."'>Sair</a>":"")
						 ."&nbsp;</div>
			</div>";
}

/*--------------------------------------------------*\
Action: display footer page information
Params: none
\*--------------------------------------------------*/
function pageFooter() {
	echo "<div style='float:left;'><hr /><p></p>";
/*	if (!isset($_GET["evid"]) AND $_SERVER["QUERY_STRING"] != "ins_hospeda&evid=22") {
		echo "	<div id='portal-colophon'>
						<div class='colophonWrapper'>
							<ul>
								<li>
									<a href='http://validator.w3.org/check/referer'
											class='colophonIcon'
											title='Este site possui XHTML válido.'
											style='background-image: url("._DOC_ROOT."/images/colophon_xhtml.png);'>XHTML Válido</a>
								</li>
								<li>
									<a href='http://jigsaw.w3.org/css-validator/check/referer'
											class='colophonIcon'
											title='Este site foi construído com CSS válido.'
											style='background-image: url("._DOC_ROOT."/images/colophon_css.png);'>CSS Válido</a>
								</li>
							</ul>
						</div>
					</div>";
	} */
	echo "</div>";
}

function userLoged() {
    global $db;
    if (isset($_SESSION["uid"]) AND $_SESSION["uid"] >= 0) {
        return true;
    } elseif (isset($_POST["username"])) {
        /*$_sql = "SELECT u.as_cod, u.as_tipo, u.as_nome, u.as_login, u.as_pass
                FROM usuarios u
                WHERE u.as_cod=0 AND u.as_login = '".strtolower($_POST["username"])."'";*/
        $_sql = "SELECT u.as_cod, u.as_tipo, u.as_nome, u.as_login, u.as_pass, eu.ev_id 
            FROM usuarios u 
            LEFT JOIN ev_usuarios eu ON u.as_login = eu.as_login 
            WHERE u.as_cod=0 AND u.as_login = '".strtolower($_POST["username"])."' 
            ORDER BY eu.ev_id desc";
        $result = $db->sql_query($_sql);
        $_error = $db->sql_error();
        if ($_error["message"] != NULL) {
            print_r($_error);
        } else {
            $aUser = $db->sql_fetchrow($result);
            if ($aUser["as_pass"] == strtolower($_POST["passwd"])) {
                $_SESSION["uid"] = $aUser["as_cod"];
                $_SESSION["utp"] = $aUser["as_tipo"];
                $_SESSION["ulo"] = $aUser["as_login"];
                $_SESSION["uem"] = $aUser["as_email"];
                $_SESSION["ust"] = time();
                $_SESSION["unm"] = ucwords(trim($aUser["as_nome"]));
                $_SESSION["evid"] = $aUser["ev_id"];
                echo "<script>document.getElementById('portal-personaltools').innerHTML=\"{$_SESSION["unm"]} &mdash; <a href='?logout'>Sair</a>\";</script>";
                return true;
            } else {
                echo "<center class='error'>Nome de Usuário não encontrado ou Senha Inválida !!</center>";
            }
        }
    }
    return false;
}


/*--------------------------------------------------*\
 check a date in the format dd/mm/yyyy
\*--------------------------------------------------*/
function checkData($date)
{
	if (!isset($date) || $date=="") {
		return false;
	}
	list($dd,$mm,$yy) = explode("/",$date);
	if ($dd > 0 AND $mm > 0 AND $yy > 0) {
		return checkdate($mm,$dd,$yy);
	}
	return false;
}

/*--------------------------------------------------*\
 check if user logged is administrator
\*--------------------------------------------------*/
function is_admin() {
	global $admin_users;
	if (in_array($_SESSION["ulo"],$admin_users)) {
		return true;
	}
	return false;
}


function footer_print() {
	echo "<p><table border='0' cellpadding='0' cellspacing='0' width='98%' align='center'>
		<tr><td class='bodyfooter_ut'>Os Gide&otilde;es Internacionais no Brasil</td>
		<td class='bodyfooter_ut' align='right'>Emitido em ".strftime("%d/%m/%Y %Hh%M")."</td></tr></table>";
}

/*
if (!userLoged() AND ($_SERVER["QUERY_STRING"] != "" OR !mb_eregi('index.php',$_SERVER['PHP_SELF']))) {
	header("location:"._DOC_ROOT."/index.php");
	die();
}
*/
$temp = $db->sql_query("SELECT * FROM ev_params WHERE ev_id={$_SESSION["evid"]}");
while ($row = $db->sql_fetchrow($temp))
	$params[$row["param_id"]] = $row["param_value"];
$qry = "SELECT count(*) as qd_transporte FROM ev_inscricao_detail d
    INNER JOIN ev_inscricao i ON d.ins_id=i.ins_id
    WHERE i.ev_id={$_SESSION["evid"]} AND i.ins_status <> '9' AND d.valor_transporte > 0";
$temp1 = $db->sql_query($qry);
$row1 = $db->sql_fetchrow($temp1);
$params["dp_transporte"] = $params["qd_transporte"] - $row1["qd_transporte"];

function processVisaCard($dataCard, $ccRefe=NULL) {
	global $db;
	if (isset($dataCard['cc1']) AND isset($dataCard['cc2']) AND isset($dataCard['cc3']) AND
		isset($dataCard['cc4']) AND isset($dataCard['cc5']) AND isset($dataCard['cc6']) AND
		mb_strlen(trim($dataCard['cc1']))==4 AND mb_strlen(trim($dataCard['cc2']))==4 AND
		mb_strlen(trim($dataCard['cc3']))==4 AND mb_strlen(trim($dataCard['cc4']))==4 AND
		trim($dataCard['cc5'])!="00" AND trim($dataCard['cc6'])!="00") {
		$cardnumber = $dataCard['cc1'].$dataCard['cc2'].$dataCard['cc3'].$dataCard['cc4'];
		$cardvalid = $dataCard['cc5'].$dataCard['cc6'];
		$valid = validateCreditCard($cardnumber, "Visa", $dataCard['cc5'], $dataCard['cc6']);
// $valid[0] = true;
		$dataCard['res_total'] = str_ireplace(".","",$dataCard['res_total']);
		$dataCard['res_total'] = str_ireplace(",",".",$dataCard['res_total']);
		if (!$valid[0]) {
			$message = array(false,"{$valid[1]}\\nPor favor, verifique as informa��es.");
			return $message;
		} else {
			$cardnumber = "c{$dataCard['cc1']}c{$dataCard['cc2']}c{$dataCard['cc3']}c{$dataCard['cc4']}c".time();
			$cardnumber = base64_encode($cardnumber);
			$cckeysec = base64_encode($dataCard['cc7']);
			$sql = "insert into cartao (ip, as_cod, as_tipo, as_login, cc_refer,"
				." cc_number, cc_value, cc_type, cc_status) values ('{$_SERVER['REMOTE_ADDR']}', {$_SESSION["uid"]},"
				." '{$_SESSION["utp"]}', '{$_SESSION["ulo"]}', '$ccRefe',0, ".($dataCard['res_total']).", 'visa', '0');"
				." select CurrVal('public.cartao".$dbsincro."_cc_id_seq');";
			$ccid = $db->sql_fetchrow($db->sql_query($sql));
// GERAR DEBUG (2006-06-22 :: Tarcisio)
// valor que esta sendo gravado na tabela cartao, em ALGUNS CASOS, esta diferente do valor total
// da inscricao no evento
			$_debug = "insert into cartao_debug"
				." values ({$ccid[0]},'".implode(", ",$dataCard)." :: ".str_replace("'","\'",$sql)."')";
			$db->sql_query($_debug);
// FIM DEBUG
			$cckey = md5("Gideoes{$_SESSION["uid"]}{$_SESSION["utp"]}Anui");
			$sql = "insert into cartao_process (cc_id, cc_field1, cc_field2, cc_field3, cc_field4)"
				." values ({$ccid[0]}, '$cardnumber', '{$dataCard['cc5']}/{$dataCard['cc6']}','$cckey',"
				." '$cckeysec')";
			if ($result = $db->sql_query($sql))
				return array(true,"Ok",$ccid[0]);
			else
				return array(false,$db->sql_error());
		}
	} else {
		$message = array(false,"N�o foi poss�vel fazer a valida��o dos dados do cart�o informado.\\nPor favor, verifique as informa��es.");
		return $message;
	}
}

function validateCreditCard($cc_number,$cc_type, $cc_month, $cc_year) {
	$validated = FALSE;
	$err_msg = "";
	/* First, we get rid of any spaces or dashes the user might have typed in, then test the result
	to see if it's a numeric value ($not_int is the regular expression /\D/, which matches any
	non-digit characters in a string):*/
	$not_int = "/\D/";
	$value = preg_replace("[ .-]","",$cc_number);
	if( $value!="" && preg_match($not_int, $value ) ) {
		/* If we find any non-digits in the value, we add an appropriate error message onto the
		 value of the variable $err_msg, and set our validation flag $validated to FALSE:*/
		$err_msg .= "The <b>$field_name</b> should contain only the digits 0-9.<br />\n";
		$validated = FALSE;
	} else {
		// Otherwise, we check to see if the user has selected a credit card type:
		if (isset($cc_type) AND $cc_type != "" ) {
			/* If so, we get that type as the variable $cc_type, the value in the Card Number field
			 as $cc_number, and the length of that value as $cc_length: */
			$cc_length = mb_strlen($cc_number);
			/* Now we test the length of the number against what's correct for its type, setting
			 $validated to TRUE or FALSE accordingly: */
			$cc_type = mb_strtolower($cc_type);
			switch($cc_type)
			{
				case "mastercard":
					$validated = $cc_length == 16;
					break;
				case "visa":
					$validated = ($cc_length == 13 || $cc_length == 16);
					break;
				case "americanexpress":
					$validated = $cc_length == 15;
					break;
			}
			/* If $validated is FALSE, the number has the wrong number of digits for the type of
			 card indicated: */
			if(!$validated)
				$err_msg .= "N�mero de d�gitos para o cart�o ".mb_strtoupper($cc_type)
					." informado � inv�lido.\\n";
			else {
				// Otherwise, we check to see if the number has the correct prefix for that type:
				switch($cc_type)
				{
					case "mastercard":
					$prefix = mb_substr($cc_number, 0, 2);
					$validated = $validated && ($prefix > 50 && $prefix < 56);
					break;
					case "visa":
					$prefix = mb_substr($cc_number, 0, 1);
					$validated = $validated && ($prefix == 4);
					break;
					case "americanexpress":
					$prefix = mb_substr($cc_number, 0, 2);
					$validated = $validated && ($prefix == 34 || $prefix == 37);
					break;
				}
				if(!$validated)
					$err_msg .= "Prefixo inv�lido para n�mero ".mb_strtoupper($cc_type).".\\n";
				else {
					/* If the number has met all of the preceding conditions, then we perform the
					 checksum test using the Luhn formula. First we make a copy of the number,
					 reversing the order of the digits, since it's easier to count them from left
					 to right, and store it in a variable named $copy: */
					$copy = strrev($cc_number);
					/* Then we store its length as $length and we initialise a running total $sum
					 to zero: */
					$length = mb_strlen($cc_number);
					$sum = 0;
					for($c = 0; $c < $length; $c++)
					{
						/* As we add up the digits, we'll want to double every other digit starting
						 with the second one from the left, since we've reversed their order. Since
						 the first digit the first digit has the index 0, this means we'll be
						 doubling the odd-numbered ones. The first digit can be obtained as
						 mb_substr($digit,0,1), the second one as mb_substr($digit,1,1), and so on
						 through mb_substr($digit,$length-1,1): */
						$digit = mb_substr($copy,$c,1);
						if($c % 2 == 1)
						{
							// If the digit has an odd-numbered index in the string, we double it:
							$digit *= 2;
							/* Then we determine if the result is greater than 10. If it is, then
							 it has two digits (the highest possible value being 2 * 9 = 18), once
							 again using the mb_substr() function: */
							if($digit > 9)
							{
								$first = mb_substr($digit,0,1);
								$second = mb_substr($digit,1,1);
								$digit = $first + $second;
							}
						}
						/* Now we increment the running total by the value of $digit (which hasn't
						 changed if the digit had an even-numbered index), and repeat the process
						 with the next digit until we've gone through all the digits in $copy: */
						$sum += $digit;
					}
					/* Now we determine if the final value of $sum is evenly divisible by 10. If it
					 isn't, we know there was an error in the number somewhere; we alert the
					 customer accordingly and set the error flag to FALSE: */
					if($sum % 10 != 0)
					{
						$err_msg .= _CARDNUMBER." ".mb_strtoupper($cc_type)." "._CCNOTVALID;
						$validated = FALSE;
					} else {
						/* Finally, if the number's passed all of the above tests, we perform a
						 check on the expiration date indicated by the user to ensure that he
						 hasn't given us a date in the past. We obtain the number 1-12 for the
						 current month and the four-digit current year using date() and compare
						 these to the values selected in the form: */
						$thismonth = date("n");
						$thisyear = date("Y");
						if( $_POST["Expiration0Year_required"] == $thisyear &&
							$_POST["Expiration0Month_required"] < $thismonth )
						{
							/* If the year is the same as the current year but the month is
							 previous to the current month, then we know we've got a problem, and
							 we respond appropriately: */
							$err_msg .= "Data de validade incorreta (a data indicada est� vencida).\\n";
							$validated = FALSE;
						} else
							$validated = TRUE;
					}
				}
			}
		}
	}
	return $ret = array($validated,$err_msg);
}

function gidsendmail($recipient="mailalert@gideoes.org.br",$subject,$from="",$body="") {

	$mailheader = "MIME-Version: 1.0; \n"
		."Return-Path: ".($from=="" ? "mailalert@gideoes.org.br" : $from)."; \n"
		."Content-Type: text/html; \n"
		."Content-class: urn:content-classes:message; \n"
		."X-Mailer: PHP/".phpversion()."; \n"
		."From: ".($from=="" ? "mailalert@gideoes.org.br" : $from)."; \n"
		."Bcc: hardfinger@gideoes.org.br; \n";

	$mailbody = "<html>\n<head></head>\n<body>\n$body</body></html>";

	//***** ENVIO DA MENSAGEM
	mb_language("English");
	$mail = mb_send_mail($recipient, $subject, $mailbody, $mailheader);
#	$mail = mail($recipient, $subject, $mailbody, $mailheader);

	if ($mail) {
		return true;
	} else {
		return "ERROR: $mail";
	}
}

function format_coin($val) {
    if (is_numeric($val))
        return number_format($val,2,".",",");
    return "error";
}

$qry = "SELECT * FROM ev_params WHERE ev_id = {$_SESSION["evid"]}";
$rst = $db->sql_query($qry);
while ($row = $db->sql_fetchrow($rst)) {
    $vEvent[$row["param_id"]] = $row["param_value"];
}
?>
