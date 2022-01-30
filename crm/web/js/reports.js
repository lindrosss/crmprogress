
var jsPath = window.location.origin + "/fresh_hub/";
//var jsPath = window.location.origin + "/fresh/";

$( document ).ready(function() {

	
	
	$('#btn_dwld_actual_time_tables').click(function() {
		//var id_market = $('#markets-id').val();
		//var id_vacancy = $(this).attr('id_vacancy');

        $("#status").html('<p>Отчет формируется</p>');
        $("#result").html('');

		$.ajax({
			  url: jsPath + "reports/download_actual_time_tables",
			  type: "POST",		 
			  data:  {
			  	         //id_market:id_market
				  		//, id_vacancy:id_vacancy
			  			},
			  success: function(data){
                  //$("#status").html('');
                  $("#result").html(data);
                  $("#status").html('<p>Отчет сформирован успешно</p>');
			  },

            error: function(data){
               // $("#result").html('<p>Произошла ошибка формирования отчета</p>');
            }
			});
		

	});

    $('#btn_dwld_actual_time_tables_range').click(function() {
        //var id_market = $('#markets-id').val();
        //var id_vacancy = $(this).attr('id_vacancy');

        $("#status_range").html('<p>Отчет формируется</p>');
        $("#result_range").html('');

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            url: jsPath + "reports/download_time_tables_range",
            type: "POST",
            data:  {
                	  start_date:start_date
                	, end_date:end_date
            },
            success: function(data){
                //$("#status").html('');
                $("#result_range").html(data);
                $("#status_range").html('<p>Отчет сформирован успешно</p>');
            },

            error: function(data){
                // $("#result").html('<p>Произошла ошибка формирования отчета</p>');
            }
        });


    });


});

