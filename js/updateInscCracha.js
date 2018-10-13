$(document).ready(function() {
		$("#impr-all").click(function(){
			$.ajax({
					url: "include/atualizarcracha.php",
					data: {ev_id: $("#ev_id").val()},
					type: "POST",
					cache: true
			}).done(function()
			{
				alert('status de todos os crachás foram atualizados para (IMPRESSO)');
			});

		});
});

