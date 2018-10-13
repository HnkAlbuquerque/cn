
<?php
  
  $pagina = 'home';

  if(array_key_exists('page',$_GET)) {
    $pagina = $_GET['page'];   
  }

  require_once('header.php');
  include_once('functions/functions.php');

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Convenção Nacional</title>

    <!-- Bootstrap -->
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-flex.min.css" rel="stylesheet">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet">
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/tabela1.css" rel="stylesheet">
    
    <style type="text/css">

     .form-control.my-form-control {
    height: auto;
    
    }
  
    @media print
    {
        #non-printable { display: none; }
        #printable { display: block; }
    }

        .divCracha    {
            margin: 0;
            font-family: Verdana, Arial, 'sans-serif';
            font-size: 12px;
            text-align: center;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
        }
        .pag { page-break-after: always; }

    .body2 {
        font-family: Verdana, Arial, Luxi Sans, Lucida, Helvetica;
        font-size : 10px;
        color: #000000;
        text-decoration : none;
    }
    .body_u {
        font-family: Verdana, Arial, Luxi Sans, Lucida, Helvetica;
        font-size : 10px;
        color: #000000;
        text-decoration : none;
        border-bottom: 1px solid #CCCCCC;
    }


    .body_ub {
        font-family: Verdana, Arial, Luxi Sans, Lucida, Helvetica;
        font-size : 10px;
        color: #000000;
        text-decoration : none;
        border-bottom: 1px solid #888888;
    }


    .body_ut {
        font-family: Verdana, Arial, Luxi Sans, Lucida, Helvetica;
        font-size : 10px;
        color: #000000;
        text-decoration : none;
        border-top: 1px solid #888888;
    }


    .body_utb {
        font-family: Verdana, Arial, Luxi Sans, Lucida, Helvetica;
        font-size : 10px;
        color: #000000;
        text-decoration : none;
        border-bottom: 1px solid #888888;
        border-top: 1px solid #888888;
    }
</style>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript">

    function deleteRowModal(elementoHtml)
        {
          var table = document.getElementById(elementoHtml);
         // alert(table+" tamanho da tabela");
          var tableTamanho = table.rows.length;
          //alert(tableTamanho+" tamanho da tabela");
          var desc = tableTamanho-1;

          for (var i = 0; i < tableTamanho-1; i++)
          {
            //alert("entrou no for");
            table.deleteRow(desc);
            desc--;
          }
        } 

        function deleteRow(insnum)
        {
          document.getElementById("tabelaEdit").deleteRow(insnum);
        }


      
      function printDiv(divName) 
      {
           var printContents = document.getElementById(divName).innerHTML;
           var originalContents = document.body.innerHTML;

           document.body.innerHTML = printContents;

           window.print();

           document.body.innerHTML = originalContents;
      }
    </script>
      

   <!-- <link href="css/bootstrap-responsive.css" rel="stylesheet">

     HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
   <nav class="navbar navbar-inverse navbar-fixed" id="non-printable">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand active" href="index.php">Convenção Nacional</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="?page=inscricao">Inscrições</a></li>
              <li><a href="?page=relatorios">Relatórios</a></li>
              <li><a href="?page=documentos">Documentos</a></li>
              <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Crachás</a>
                  <ul class="dropdown-menu">
                        <li><a href="?page=pimaco">Etiqueta Pimaco</a></li>
                        <li><a href="?page=termica62mm">Térmica 62mm</a></li>
                        <li><a href="?page=cracha-normal">Crachá Normal</a></li>
                  </ul>
              </li>
              <li><a href="?page=tutoriais">Tutoriais</a></li> 
          </ul>
          <form class="navbar-form navbar-right">
          <!--  <div class="form-group">
              <input name="idsearch" type="text" placeholder="Número Inscrição" class="form-control">
            </div>
            <button formaction="?page=inscricao" type="submit" class="btn btn-primary">Pesquisar</button> -->
            <button formaction="logout.php" type="submit" class="btn btn-danger">Sair</button> 
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <div class="container body">
      <?php
      switch ($pagina) {
        case 'inscricao':
            include 'include/inscricao.php';
            break;
        case 'nova-inscricao':
            include 'include/nova-inscricao.php';
            break;
        case 'finalizar':
            include 'include/finalizar.php';
            break;
        case 'relatorios':
            include 'include/relatorios.php';
            break;
        case 'documentos':
            include 'include/documentos.php';
            break;
        case 'ins-cracha':
            include 'include/impr-cracha.php';
            break;
        case 'edit-cracha':
            include 'include/edit-cracha.php';
            break;
        case 'pimaco':
            include 'include/pimaco.php';
            break;
        case 'termica62mm':
            include 'include/termica62mm.php';
            break;
        case 'cracha-normal':
            include 'include/cracha-normal.php';
            break;
        case 'edit-inscricao':
            include 'include/edit-inscricao.php';
            break;
        case 'finalizar-edicao':
            include 'include/finalizar-edicao.php';
            break;
        case 'tutoriais':
            include 'include/tutoriais.php';
            break;
        case 'impr-ficha-infantil':
            include 'include/impr-ficha-infantil.php';
            break;
        case 'impr-recibo':
            include 'include/impr-recibo.php';
            break;
        
        default:
            include 'include/home.php';
          }

      ?>
    </div>

    <body>
    <html>