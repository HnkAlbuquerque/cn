  

/////////////////////////FUNÇÂO DE EXIBIR E OCUTAR DIV///////////////////////
  $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


    function Mostrar(){

        document.getElementById("pai").style.display = "block";
    }

    function Ocultar(){

        document.getElementById("pai").style.display = "none";
    }

    function Mostrar_Ocultar1(){

        var pai = document.getElementById("pai");
        var div = document.getElementById("div_cor");

        if(pai.style.display == "none"){
            Mostrar();
            document.getElementById("table1").value = "Ocultar ";
            document.getElementById("div_cor").className = "panel panel-primary";
        }

        else{

            Ocultar();
            document.getElementById("table1").value = "Expandir";

        }
    }

    function Mostrar_Ocultar2(){

        var pai = document.getElementById("pai");

        if(pai.style.display == "none"){
            Mostrar();
            document.getElementById("table2").value = "Ocultar ";
            document.getElementById("div_cor").className = "panel panel-green";
        }

        else{

            Ocultar();
            document.getElementById("table2").value = "Expandir";

        }
    }

    function Mostrar_Ocultar3(){

        var pai = document.getElementById("pai");

        if(pai.style.display == "none"){
            Mostrar();
            document.getElementById("table3").value = "Ocultar";
            document.getElementById("div_cor").className = "panel panel-red";
        }

        else{

            Ocultar();
            document.getElementById("table3").value = "Expandir";

        }
    }
/////////////////////////FIM FUNCAO EXIBIR E OCULTAR DIV///////////////


//////////////FUNCAO CARREGA DADOS TABLE /////////////////////////////

$(document).ready(function() {

        function buscar (carteira01){

            var page = "carregaDados.php";

            $.ajax
                ({

                    type: 'POST',
                    dataType: 'html',
                    url: page,
                    beforeSend: function() {

                        $("#div_dados").html("Carregando...");
                    },
                    data: {carteira: carteira01},
                    success: function(msg)
                    {
                        $("#div_dados").html(msg);
                    }

                });
        }

        $('#table1').click(function () {
            buscar($("#carteira01").val())
        });



        function buscar (carteira02){

            var page = "carregaDados.php";

            $.ajax
                ({

                    type: 'POST',
                    dataType: 'html',
                    url: page,
                    beforeSend: function() {

                        $("#div_dados").html("Carregando...");
                    },
                    data: {carteira: carteira02},
                    success: function(msg)
                    {
                        $("#div_dados").html(msg);
                    }

                });
        }

        $('#table2').click(function () {
            buscar($("#carteira02").val())
        });


        function buscar (carteira03){

            var page = "carregaDados.php";

            $.ajax
                ({

                    type: 'POST',
                    dataType: 'html',
                    url: page,
                    beforeSend: function() {

                        $("#div_dados").html("Carregando...");
                    },
                    data: {carteira: carteira03},
                    success: function(msg)
                    {
                        $("#div_dados").html(msg);
                    }

                });
        }

        $('#table3').click(function () {
            buscar($("#carteira03").val())
        });

    });   

///////////////////FIM FUNCAO CARREGA DADOS/////////////////////////////