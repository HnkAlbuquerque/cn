<?php
session_start();
/********************************************************************\
  User: The Gideons International in Brazil
  Function: Main file
  Licensed by GPLv2
  Author: Jose Tarcisio R Cardoso (tarcisio dot cardoso at gmail dot com)
  Created in: 2007-02-19
  Framework based: Joomla
  File name: gid_mainfile.php
\********************************************************************/

if (mb_eregi("gid_mainfile.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

require_once("gid_config.php");
require_once("db.php");

?>
