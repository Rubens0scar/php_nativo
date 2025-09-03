		$(document).ready(function(){
				$("#de").change(function(){
					$.ajax({
						url:"../mod_enfermedad/procesa.php",
						type: "POST",
						data:"idmarca="+$("#de").val(),
						success: function(opciones){
							$("#a").html(opciones);
						}
					});
				});
			});
/************************************************************************************
***** Carga tabla con resultados de la consulta entre los dos selects de fechas *****
************************************************************************************/
		$(document).ready(function(){
				$("#a").change(function(){
					$.ajax({
						url:"gen_tabla.php",
						type: "POST",
						data:"firts_fech="+$("#de").val() + "&second_fech="+$("#a").val(),
						success: function(table){
							$("#data_table").html(table);
						}
					});
				});
			});
/**************************************************************
****************** Funciones del Slide Inicial ****************
**************************************************************/
RunSlideShow("backslide","slidehow",
    "../theme/slide/slide/bannern01.jpg;../theme/slide/slide/bannern02.jpg;../theme/slide/slide/bannern03.jpg;../theme/slide/slide/bannern04.jpg;../theme/slide/slide/bannern05.jpg",5);
/*************************************
************ Menu ********************
*************************************/
// initialise plugins
		jQuery(function(){
			jQuery('ul.sf-menu').superfish();
		});