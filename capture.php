<?php

	require_once('header.php');

  if (!isset($_POST['login']))
  {
    $login = 1;
    $senha = 1;
  }
	else
  {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
  }

	$result_log = "SELECT u.as_login,u.as_pass,ev.ev_id,trim(to_char(e.ev_dt_ini,'YYYY')) as ev_data, e.tipo_cracha,e.ev_nome from usuarios u 
                  inner join ev_usuarios ev on u.as_login = ev.as_login 
                  inner join ev_evento e on ev.ev_id = e.ev_id 
                  where u.as_login = '$login' and as_pass = '$senha' ";

	$sql_log = $db->SetFetchMode(ADODB_FETCH_ASSOC);

	$sql_log = $db->Execute($result_log);

	$temp_log = $sql_log -> fields;


	if($login == $temp_log['as_login'] && $senha == $temp_log['as_pass'])
	{
    sleep(1);
		$_SESSION['gsr']['usr'] = "$login";
    $_SESSION['gsr']['ev_id'] = $temp_log['ev_id'];
    $_SESSION['gsr']['ev_data'] = $temp_log['ev_data'];
    $_SESSION['gsr']['ev_cracha'] = $temp_log['tipo_cracha'];
    $_SESSION['gsr']['ev_nome'] = $temp_log['ev_nome'];
		$_SESSION['gsr']['vldusr'] = time() + 25000;
	  header("Location: index.php");
  
	}
	else
	{ 
    header("Location: login.php");
	}

?>