<script>$(document).ready(function() {
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
</script>  