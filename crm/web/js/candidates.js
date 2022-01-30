
//var jsPath = window.location.origin + "/fresh_hub/";
var jsPath = window.location.origin + "/fresh/";

$( document ).ready(function() {

	
	
	$('#load_report').click(function() {
		var id_market = $('#markets-id').val();
		var id_vacancy = $(this).attr('id_vacancy');
		
		$.ajax({
			  url: jsPath + "candidates/load_candidates",
			  type: "POST",		 
			  data:  {id_market:id_market, id_vacancy:id_vacancy },			  
			  success: function(data){				
				//$("#timetables_market").html(data);
				//alert('error '+ data);
				$("#vacancies_list").html(data);
				/*
				$("#vacancies_list_in_market td.clickable").click(function() {										
											clickOnVacancy($(this).attr("id_row"));											
										});	*/
			  }
			});
		

	});	


});

