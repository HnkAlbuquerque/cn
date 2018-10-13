<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.5/socket.io.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>    
    <link rel="stylesheet" type="text/css" href="login/css/style.css">
    <style>
      
      body{
        background-color:#e0e0e0;
      }
      .fadeIn {
      -webkit-animation: fadeIn 3s ease-in-out;
      -moz-animation: fadeIn 3s ease-in-out;
      -o-animation: fadeIn 3s ease-in-out;
      animation: fadeIn 3s ease-in-out;
      }
      @-webkit-keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; } 
      }
      @-moz-keyframes fadeIn {
      0% { opacity: 0;}
      100% { opacity: 1; }
      }
      @-o-keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
      }
      @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
      }

    </style>



  </head>
  <body>
  <div class="row">
  <div class="col-sm-12" align="center">
  <img src="imgs/logo_alta.png" class="fadeIn" class="img-responsive" alt="Cinque Terre">
  </div><br>
  <form class="animated swing" id="login" method="POST" action="capture.php" style="margin-top:0px;" >
        <label>
          <img src="imgs/conv_logo.png" width="250" height="130">
        </label><p id="demo"></p>

      <div style="margin-left: 18px"><strong>Login:</strong></div>
      <input type="text" id="login" autocomplete="off" placeholder="Usuário" name="login">
      <input type="password" id="senha" autocomplete="off" placeholder="Senha" name="senha" >
      <input type="submit" name="send" class="animated bounce" value="acessar" id="sendbtn">


  </form>

  <div class="row">
  <p class="footer">
    <a href="http://www.gideoes.org.br"><strong>Os Gideões Internacionais no Brasil ©</strong></a>
  </p>
  </div>
  </div>


</body>

<?php $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); 
$_SESSION['color'] = $color;
if ($color == '#fff' || $color == '#ffffff') {
  $color = '#ff6600';  
}
?>
</html>
