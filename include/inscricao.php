<?php

  if(isset($_post['ins_id']) && $_post['ins_id'] > 0 && isset($_post['deleteaction']))
  {
    updateinsstatus($_post['ins_id'],9);
  }



?> <script>

$(document).ready(function(){


});
</script>

    <!-- Font Awesome Css -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Bootstrap Select Css -->
    <link href="css/bootstrap-select.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>

<h3>Inscrições</h3>
<hr>
<div class="row">
    <div class="col-md-10">
          <div class="table-responsive">
                 <table id="post_list" class="table table-striped table-hover" width="100%" cellspacing="0" style="font-size: 70%">
                    <thead>
                      <tr class="active">
                        <th>Inscrição</th>
                        <th>Numero</th>
                        <th>Nome</th>
                        <th>Crachá</th>
                        <th>Campo</th>
                        <th>Status</th>
                        <th>Credencial</th>
                        <th>Almoço</th>
                        <th>Jantar</th>
                        <th>Transporte</th>
                      </tr>
                    </thead>

                  </table>
            </div>
      </div>

  <div class="col-md-2">
    <div class="panel panel-info">
      <div class="panel-heading" align="center"><strong>LEGENDAS</strong></div>
        <div class="panel-body">
          <div class="row" style="margin-top: 5px">
            <div class="col-sm-1">
                <img src='imgs/v.png' alt='Crachá Impresso' height='25' width='25'>
            </div>
            <div class="col-sm-1">
              Efetivado
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <img src='imgs/x.png' alt='Jantar' height='25' width='25'>
            </div>
            <div class="col-md-1">
              Não Efetivado
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <img src='imgs/dinner2.png' alt='Jantar' height='25' width='25'>
            </div>
            <div class="col-md-1">
              Almoço/Jantar
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <img src='imgs/transporte.png' alt='Jantar' height='25' width='25'>
            </div>
            <div class="col-md-1">
              Transporte
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <span class="glyphicon glyphicon-trash"></span>
            </div>
            <div class="col-md-1">
              Excluir
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <span class="glyphicon glyphicon-pencil"></span>
            </div>
            <div class="col-md-1">
              Editar
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <span class="glyphicon glyphicon-print"></span>
            </div>
            <div class="col-md-1">
              Imprimir
            </div>
          </div>
          <div class="row" style="margin-top: 5px">
            <div class="col-md-1">
                <span class="glyphicon glyphicon-search"></span>
            </div>
            <div class="col-md-1">
              Pesquisar
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-1">
        <a href="index.php?page=nova-inscricao"><button type="button" class="btn btn-primary"> - Nova Inscrição - </button></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" >
  <div class="modal-dialog modal-lg" onlick="return false;">
    <div class="modal-content">
        <form method="post">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteRowModal('listPessoas');deleteRowModal('listItems');"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalhes da inscrição</h4>
              </div>
              <div class="modal-body">
                <h4 align="right" >
                  <span class="label label-warning" id="idspan"></span>
                  <input type="hidden" class="input-sm" name="ins_id" id="ins_id" size="5" readonly/>
                </h4><br>
                <table class="table table-striped" name="listPessoas" id="listPessoas">
                  <th>Nome</th>
                  <th>Crachá</th>
                </table>
                <hr>
                <h4>Items Pedidos</h4>
                <table class="table table-striped" name="listItems" id="listItems">
                  <th>Item</th>
                  <th>Qde</th>
                  <th>Valor</th>
                </table>

                      <h4 align="right" id="valorTotalModal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>

                </table>
              </div>
              <div class="modal-footer">
                  <input type="hidden" name="deleteAction" value="1">
                  <button type='submit' formaction='index.php?page=inscricao' class='btn btn-danger'><span class="glyphicon glyphicon-trash"></span> Inscrição</button>
                  <button type='submit' formaction='index.php?page=edit-inscricao' class='btn btn-primary'><span class="glyphicon glyphicon-pencil"></span> Inscrição</button>
                  <button type="submit" formaction="index.php?page=edit-cracha" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Crachá</button>
                  <button type="submit" formaction="index.php?page=ins-cracha" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Crachá</button>
                  <button type="submit" formaction="index.php?page=impr-recibo" formtarget="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Recibo</button>
                  <button type="submit" formaction="index.php?page=impr-ficha-infantil" formtarget="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Criança</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteRowModal('listPessoas');deleteRowModal('listItems');"><span class="glyphicon glyphicon-remove"></span></button>
              </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<img id="my_image" src=""/>
<!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="js/boostrap 3/bootstrap.min.js"></script>

    <!-- Bootstrap Select Js -->
    <script src="js/bootstrap-select.js"></script>

  <!-- DataTables -->
  <script type="text/javascript" src="js/dataTablemin.js"></script>
  <script>

  $(document).ready(function(e){
    $('#post_list').dataTable({
      "bProcessing": true,
          "serverSide": true,
          "responsive": true,
          "aoColumnDefs" : [
            //adiciona a classe para todas as células referente a coluna indicada
            {  "sWidth": "0%", "aTargets": [9],"className": "dt-body-center",
              "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if ( sData == "t" ) {
                  $(nTd).html("<img src='imgs/transporte.png' alt='tranposrte' height='30' width='30'>")
                }else{
                  $(nTd).html("")
                }
              }
            },
            {  "sWidth": "0%", "aTargets": [8],"className": "dt-body-center",
              "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if ( sData == "t" ) {
                  $(nTd).html("<img src='imgs/dinner2.png' alt='jantar' height='25' width='25'>")
                }else{
                  $(nTd).html("")
                }
              }
            },
            {  "sWidth": "1%", "aTargets": [7],"className": "dt-body-center",
              "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if ( sData == "t" ) {
                  $(nTd).html("<img src='imgs/dinner2.png' alt='almoço' height='25' width='25'>")
                }else{
                  $(nTd).html("")
                }
              }
            },
            {  "sWidth": "1%", "aTargets": [6],"className": "dt-body-center",
              "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                 if ( sData == "t" ) {
                  $(nTd).html("<img src='imgs/v.png' alt='cracha' height='25' width='25'>")
                }else{
                  $(nTd).html("<img src='imgs/x.png' alt='cracha' height='22' width='22'>")
                }
              }
            },
            {  "sWidth": "1%", "aTargets": [5],"className": "dt-body-center",
              "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if ( sData == "1" ) {
                  $(nTd).html("<img src='imgs/v.png' alt='status' height='25' width='25'>")
                }else{
                  $(nTd).html("<img src='imgs/x.png' alt='status' height='22' width='22'>")
                }
              }
            },
            {"sWidth": "0%", "aTargets": [0],"className": "dt-body-center",

            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              for (var i = 0; i <= iRow; i++) {

                  $(nTd).html('<button id="btns_'+[i]+'" name="btns_'+[i]+'" class="btn btn-success btn-sm" value="'+sData+'" type="button" onclick="MeuMetodo('+i+')">'+sData+'</button>')
                  }
            }


            },
            {"sWidth": "0%", "aTargets": [1],"className": "dt-body-center",},
            {"sWidth": "80%", "aTargets": [2]},
            {"sWidth": "10000%", "aTargets": [4]}


        ],
          "ajax":{
              url :"dados/post_inscricao.php",
              type: "POST",
              error: function(){
                $("#post_list_processing").css("display","none");
              }
            }

        });
  });

  function MeuMetodo(inteiro){

      $(document).ready(function() {


        $("#btns_"+inteiro).ready(function() {
        $("#myModal").modal({backdrop: 'static', keyboard: false});

          var ins_id = $('#btns_'+inteiro).val();
          var span = document.getElementById("idspan");
          document.getElementById('ins_id').value = ins_id;
           $(span).html("Inscrição: "+ins_id);
                   // var as_nome = $("input[name='nome']");

                $.getJSON( // inicia carregamento da primeira lista (lista de inscritos)
                'dados/carregaInsPessoas.php',
                { ins_id: ins_id},
                function( json )
                {

                                                      globalJ = json;

                }).always(function(){
                                                  if (globalJ[0] != 2)
                                                  {

                                                    //as_nome.val( globalJ[0].as_nome );
                                                    tableLinhas = globalJ.length;
                                                    var table = document.getElementById("listPessoas");
                                                      var j = 1;
                                                    for (var i = 0; i < tableLinhas; i++)
                                                    {

                                                        var row = table.insertRow(table.length);
                                                        var cell1 = row.insertCell(0);
                                                        var cell2 = row.insertCell(1);

                                                        cell1.innerHTML = globalJ[i].as_nome;

                                                        var ins2 = document.createElement("input");
                                                        ins2.type = "checkbox";
                                                        ins2.setAttribute("id","cracha_"+j);
                                                        ins2.setAttribute("name","cracha_"+j);
                                                        ins2.setAttribute('checked',true);
                                                        cell2.appendChild(ins2);

                                                        var ins2 = document.createElement("input");
                                                        ins2.type = "hidden";
                                                        ins2.setAttribute("id","info_"+j);
                                                        ins2.setAttribute("name","info_"+j);
                                                        ins2.setAttribute("value",globalJ[i].info_cracha);
                                                        ins2.setAttribute("readonly","readonly");
                                                        cell2.appendChild(ins2);

                                                        j++;
                                                    }

                                                  }
                                                  else
                                                  {

                                                      alert("Numero de membro não encontrado");
                                                  }

                                  }); // finaliza preenchimento da lista de inscritos

                $.getJSON( // inicia carregamento da primeira lista (lista de inscritos)
                'dados/carregaInsItems.php',
                { ins_id: ins_id},
                function( json )
                {

                                                      globalJ = json;

                }).always(function(){
                                                  if (globalJ[0] != 2)
                                                  {

                                                    //as_nome.val( globalJ[0].as_nome );
                                                    tableLinhas = globalJ.length;
                                                    var table = document.getElementById("listItems");

                                                    for (var i = 0; i < tableLinhas-1; i++)
                                                    {

                                                        var row = table.insertRow(table.length);
                                                        var cell1 = row.insertCell(0);
                                                        var cell2 = row.insertCell(1);
                                                        var cell3 = row.insertCell(2);

                                                        cell1.innerHTML = globalJ[i].descricao;
                                                        cell2.innerHTML = globalJ[i].quantidade;
                                                        cell3.innerHTML = globalJ[i].valor;
                                                    }

                                                   // alert(globalJ[tableLinhas-1].valor);

                                                    document.getElementById('valorTotalModal').innerHTML = "R$ "+globalJ[tableLinhas-1].valor+"&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;";
                                                //    document.getElementById('valorTotalModal').innerHTML = "&nbsp;&nbsp;"

                                                  }
                                                  else
                                                  {

                                                      alert("Numero de membro não encontrado");
                                                  }

                                  }); // finaliza preenchimento da lista de inscritos
                            });
                      });
}




    </script>
