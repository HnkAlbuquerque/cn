<?php
session_cache_limiter('private_no_expire');
session_cache_expire(30);
session_start();
$_SESSION["SID"] = session_id();

// define constant's for system
define("_VERSION","v.1.0"); // versao do sistema
define("_DOC_ROOT","http://{$_SERVER["HTTP_HOST"]}/cn"); // document root
define("_DOC_ROOT_AJAX","/cn"); // document root

$periodo = date("Y");

if (isset($_GET["logout"])) {
	include("logout.php");
}	

// define action's in url
$_URL = array_keys($_GET);

// define conection for database
$dbhost = "localhost";		// address server
$dbuname = "oracle";	// username to conect
$dbpass = "deybacsac4";	// password for username
$dbname = "gideoes";		// database name
$dbport = 5432;					// port to conect in database server
$dbtype = "postgres";		// database derver type. Supported servers are:
												// MySQL, mysql4, postgres, mssql, oracle, msaccess, db2 and mssql-odbc

// define users for all functions in the system
$admin_users[] = "cardoso";
$admin_users[] = "ffnascimento";

// default params for new event
$param_defaul = Array("cracha_tipo"=>"cbr",
											"auto_prn"=>"true",
											"unidade"=>"cm",
											"page_width"=>"19.7",
											"margin_top"=>"0",
											"cracha_height"=>"6.9",
											"vr_inscricao_membro"=>"0",
											"vr_inscricao_visitante"=>"0",
											"vr_inscricao_crianca1"=>"0",
											"vr_inscricao_crianca2"=>"0",
											"vr_inscricao_crianca3"=>"0",
											"vr_jantar_membro"=>"0",
											"vr_jantar_visitante"=>"0");
$cn_ins=25;
$cn_jan=50;
$cn_cri=array(3=>20,12=>40,17=>80);
$vencto_boleto="24/08/2007";
$inst_pagto="<b>N&Atilde;O RECEBER AP&Oacute;S O VENCIMENTO</b>";

/* DADOS PARA EMISSAO DE BOLETOS - BRADESCO (237) */
define("_AGENCIA237","0595");	// Numero da Agencia 4 Digitos s/DAC
define("_AGENCIA237DIG","9");	// Digito do Numero da Agencia 1 Digito
define("_CONTA237","0060599");	// Numero da Conta 7 Digitos s/ DAC
define("_CONTADIGITO237","9");	// Digito da Conta 1 Digito
define("_TIPOCARTEIRA237","06");
define("_TIPOACEITE237","N");
define("_USOBANCO237","");
define("_ESPECIE237","R$");
define("_ESPECIEDOC237","REC");

/* DADOS DO CEDENTE PARA EMISSAO DE BOLETOS */
define("_CEDENTENOME","Os Gideoes Internacionais do Brasil");
define("_CEDENTECNPJ","49.413.776/0001-22");
define("_CEDENTEENDERECO","Rua Camargo Paes, 474 - Jd.Guanabara");
define("_CEDENTECIDADE","Campinas - SP");
define("_CEDENTECEP","13073-350");
define("_CEDENTECAIXAPOSTAL","Caixa Postal 5506");
define("_CEDENTEFONE","Telefone: (19)3744-3700");
define("_CEDENTEEMAIL","suporte@gideoes.org.br");
define("_CEDENTEWEBSITE","www.gideoes.org.br");

define("_NIVEL_NACIONAL","0F,1N,2N,3N,4N,5N,10N,11N,13N,16N,17N");
define("_NIVEL_REGIAO","14R,27R");
define("_NIVEL_ESTADUAL","1E,2E,3E,4E,5E,10E,11E,12E,13E,15E");
define("_NIVEL_AREA","24D");
define("_NIVEL_CAMPO","1C,2C,3C,4C,5C,6C,7C,8C,9C");

define("_PAYMENTFROM","Pagamento através de");
define("_CARDNUMBER","Número do Cartão");
define("_CCNOTVALID","não é válido.");
define("_CREDITCARD","Cartão de Crédito");
define("_BOLETOBANCARIO","Boleto Bancário");
define("_CARDVALID","Validade do Cartão");

$mes_ext = array("01"=>"Janeiro",
        "02"=>"Fevereiro",
        "03"=>"Março",
        "04"=>"Abril",
        "05"=>"Mail",
        "06"=>"Junho",
        "07"=>"Julho",
        "08"=>"Agosto",
        "09"=>"Setembro",
        "10"=>"Outubro",
        "11"=>"Novembro",
        "12"=>"Dezembro");
?>
