<?php
/********************************************************************\
  Function: Database & System Configuration
  Author: Jose Tarcisio R Cardoso (tar_br at yahoo com br)
  Created in: 2006-11-20
\********************************************************************/

if (mb_eregi("gid_config.php",$_SERVER["PHP_SELF"])) {
    Header("Location: /");
    die();
}

# Global system variables
define("_VERSION","v.1.0"); // versao do sistema

# Conection to database
$dbhost = "db-gideon.gideoes.org.br";  // address server
$dbuname = "oracle";          // username to conect
$dbpass = "deybacsac4";                   // password for username
$dbname = "gideoes";            // database name
$dbport = 5432;                 // port to conect in database server
$dbtype = "postgres";           // database derver type. Supported servers are:
                                //     MySQL, mysql4, postgres, mssql, oracle, msaccess, db2 and mssql-odbc
/* DADOS DO CEDENTE PARA EMISSAO DE BOLETOS */
define("_CEDENTENOME","Os Gideoes Internacionais do Brasil");
define("_CEDENTECNPJ","49.413.776/0001-22");
define("_CEDENTEENDERECO","Rua Camargo Paes, 474 - Jd.Guanabara");
define("_CEDENTECIDADE","Campinas / SP");
define("_CEDENTECEP","13073-350");
define("_CEDENTECAIXAPOSTAL","Caixa Postal 5506");
define("_CEDENTEFONE","Telefone: (19)3744-3700");
define("_CEDENTEEMAIL","suporte@gideoes.org.br");
define("_CEDENTEWEBSITE","www.gideoes.org.br");

?>
