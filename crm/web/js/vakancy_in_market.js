
//var jsPath = window.location.origin + "/fresh_hub/";
var jsPath = window.location.origin + "/fresh/";

//alert(window.location.origin);

$( document ).ready(function() {
    $.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});
	
	$('#markets-id').change(function() {
		getTimetablesByMarketsId(this.value);
		getSourcesByMarketsId(this.value);
	});
	
	   
	$('.set_vacancy_to_market1').click(function() {		
		var id_market = $('#markets-id').val();
		var id_vacancy = $(this).attr('id_vacancy');
		
		$.ajax({
			  url: jsPath + "vacancies/setvacancytomarket",
			  type: "POST",		 
			  data:  {id_market:id_market, id_vacancy:id_vacancy },			  
			  success: function(data){				
				     
				$("#vacancies_list").html(data);
				
			  }
			});
		
		
	});	
	
	$('.set_source_to_market1').click(function() {		
		var id_market = $('#markets-id').val();
		var id_source = $(this).attr('id_source');
		
		$.ajax({
			  url: jsPath + "vacancies/setsourcetomarket",
			  type: "POST",		 
			  data:  {id_market:id_market, id_source:id_source },			  
			  success: function(data){				
				//$("#timetables_market").html(data);
				//alert('error '+ data);
				$("#sources_market").html(data);
				/*
				$("#vacancies_list_in_market td.clickable").click(function() {										
											clickOnVacancy($(this).attr("id_row"));											
										});	*/
			  }
			});
		
		//alert(id_market+' '+id_vacancy);
	});	
	
	
	
	
	
	
	
});

function edit_vacancy(id_vacancy){		
	$.ajax({
			  url: jsPath + "vacancies/getdatavacancy",
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy},			  
			  success: function(data){	
				var result = JSON.parse(data);
				if(result['error'] == 0){				
					$("#modal_edit_vacancy #name_vacancy").val(result['name']);
					$("#modal_edit_vacancy #info_vacancy").val(result['info']);					
					$("#modal_edit_vacancy #btn_edit").attr('id_vacancy', result['id']);
					$('#modal_edit_vacancy').modal({show:true});
				}else{
					alert('Произошла ошибка при открытии окна редактирования');
				}
				
			  }
			});
}

function vacancy_update(Element){
	id_vacancy = Element.attr("id_vacancy");
	
	var vacancy_name = $('#modal_edit_vacancy #name_vacancy').val();
		var vacancy_info = $('#modal_edit_vacancy #info_vacancy').val();
		error_flag = false;
		
		if(vacancy_name == ''){
			$('#modal_edit_vacancy #name_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#modal_edit_vacancy #name_vacancy').removeClass('error_field');
		}
		
		if(vacancy_info == ''){
			$('#modal_edit_vacancy #info_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#modal_edit_vacancy #info_vacancy').removeClass('error_field');
		}
		
		if(!error_flag){
			$.ajax({
			  url: jsPath + "vacancies/updatewithoutredirect",
			  type: "POST",		 
			  data:  {vacancy_name:vacancy_name, 
					  vacancy_info:vacancy_info,
					  id_vacancy:id_vacancy},			  
			  success: function(data){				
				if(data == 1){
					$("#modal_edit_vacancy #result").html('<p>Вакансия успешно сохранена.</p>');
					//$('#create_vacancy #name_vacancy').val('');
					//$('#create_vacancy #info_vacancy').val('');
					$.pjax.reload({container:'#pjax_1'}); 
					
				}else{
						$("#create_vacancy #result").html('<p>При сохранении вакансии произошла ошибка.</p>');
						
					}	
			  }
			});
		}
}

function set_vacancy_to_market(id_vacancy){
	var id_market = $('#markets-id').val();
		//var id_vacancy = $(this).attr('id_vacancy');
		
		$.ajax({
			  url: jsPath + "vacancies/setvacancytomarket",
			  type: "POST",		 
			  data:  {id_market:id_market, id_vacancy:id_vacancy },			  
			  success: function(data){				
				//$("#timetables_market").html(data);
				//alert('error '+ data);
				$("#vacancies_list").html(data);
				
				$("#vacancies_list_in_market td.clickable").click(function() {										
											clickOnVacancy($(this).attr("id_row"));											
										});	
			  }
			});
}

function set_source_to_market(id_source){
		var id_market = $('#markets-id').val();
		//var id_source = $(this).attr('id_source');
		
		$.ajax({
			  //url: jsPath + "vacancies/setsourcetomarket",
			  url: jsPath + "vacancies/setsourcetomarket",
			  type: "POST",		 
			  data:  {id_market:id_market, id_source:id_source },			  
			  success: function(data){				
				//$("#timetables_market").html(data);
				//alert('error '+ data);
				$("#sources_market").html(data);
				/*
				$("#vacancies_list_in_market td.clickable").click(function() {										
											clickOnVacancy($(this).attr("id_row"));											
										});	*/
			  }
			});
	}

function clickOnVacancy(id_row){
		
		$('#vacancies_list_in_market tr').removeClass('selected');
		$('#vacancies_list_in_market tr[id_row="'+id_row+'"]').addClass('selected');
		//alert('#vacancies_list_in_market tr[id_row="'+id_row+'"]');
		
		$.ajax({
			  url: jsPath + "vacancies/gettimetablesbyvakancysid",
			  type: "POST",		 
			  data:  {id_vacancy:id_row },			  
			  success: function(data){				
				$("#timetables_vacancy").html(data);
				/*
				$("#vacancies_list_in_market td.clickable").click(function() {
						clickOnVacancy($(this).attr("id_row"));											
				});*/	
			  }
			});
			
			
	}

function del_vakancy_from_market(Element){
	//alert(Element.attr("id_row"));		
		
		
	id_row = Element.attr("id_row");
	id_market = $('#markets-id').val();
	$.ajax({
			  url: jsPath + "vacancies/del_vacancy_from_market",
			  type: "POST",		 
			  data:  {id_row:id_row,  id_market:id_market},			  
			  success: function(data){				
				$("#vacancies_list").html(data);
				$("#vacancies_list_in_market td.clickable").click(function() {
						clickOnVacancy($(this).attr("id_row"));											
				});	
			  }
			});
}	

function delete_vacancy(id_vacancy){
	$.ajax({
			  url: jsPath + "vacancies/deletewithoutredirect",
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy},
			  success: function(data){				
				if(data == 1){					
					$.pjax.reload({container:'#pjax_1'}); 					
				}else{
						alert('При удалении вакансии произошла ошибка');
					}
			  }
			});
}	

/*Затирает расписания и список вакансий при смене Региона, города, маркета*/
function clearOptions(){
	
	$("#vacancies_list").html('<span class="gray">Необходимо выбрать <u>Магазин</u></span>');
	$("#timetables_market").html('<span class="gray">Необходимо выбрать <u>Магазин</u></span>');
	$("#timetables_vacancy").html('<span class="gray">Необходимо выбрать <u>Вакансию</u></span>');
	$("#all_vacansieslist").css('display','none');
	$("#all_sourceslist").css('display','none');
	
}

function vacancy_create() {
		var vacancy_name = $('#create_vacancy #name_vacancy').val();
		var vacancy_info = $('#create_vacancy #info_vacancy').val();
		error_flag = false;
		
		if(vacancy_name == ''){
			$('#create_vacancy #name_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_vacancy #name_vacancy').removeClass('error_field');
		}
		
		if(vacancy_info == ''){
			$('#create_vacancy #info_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_vacancy #info_vacancy').removeClass('error_field');
		}
		
		if(!error_flag){
			$.ajax({
			  url: jsPath + "vacancies/createwithoutredirect",
			  type: "POST",		 
			  data:  {vacancy_name:vacancy_name, vacancy_info:vacancy_info },			  
			  success: function(data){				
				if(data == 1){
					$("#create_vacancy #result").html('<p>Вакансия успешно создана.</p>');
					$('#create_vacancy #name_vacancy').val('');
					$('#create_vacancy #info_vacancy').val('');
					$.pjax.reload({container:'#pjax_1'}); 
					
				}else{
						$("#create_vacancy #result").html('<p>При создании вакансии произошла ошибка.</p>');
						
					}	
			  }
			});
		}
	}
	
function timetable_for_market_create() {
	var id_market = $('#markets-id').val();
	var date_interview = $('#create_time_table_for_market #timetable_for_market').val();	
	var quota = $('#create_time_table_for_market #timetable_quota_for_market').val();
	var id_address = $('select#address').val();
	error_flag = false;
	
	
	
	if(date_interview == ''){
			$('#create_time_table_for_market #timetable_for_market').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_market #timetable_for_market').removeClass('error_field');
		}
		
	if(quota == ''){
			$('#create_time_table_for_market #timetable_quota_for_market').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_market #timetable_quota_for_market').removeClass('error_field');
		}	
		
	if(id_address == ''){		
			$('#create_time_table_for_market div#address_block').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_market div#address_block').removeClass('error_field');
		}		
		
	if(!error_flag){
			$.ajax({
			  url: jsPath + "vacancies/create_time_table_for_market",
			  type: "POST",		 
			  data:  {id_market:id_market, 
					  date_interview:date_interview,
					  id_address: id_address,
					  quota:quota
					 },			  
			  success: function(id_market){				
				if(id_market > 0){
					$("#create_time_table_for_market #result").html('<p>Расписание успешно создано.</p>');
					$('#create_time_table_for_market #timetable_for_market').val('');
					$('#create_time_table_for_market #timetable_quota_for_market').val('');
					//$.pjax.reload({container:'#pjax_1'}); 
					getTimetablesByMarketsId(id_market)
					
				}else{
						$("#create_time_table_for_market #result").html('<p>При создании расписания произошла ошибка.</p>');
						
					}	
			  }
			});
		}
	
	//alert(id_market + ' '+date_interview + ' ' + quota);
}

function timetable_for_vacancy_create() {
	var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
	var date_interview = $('#create_time_table_for_vacancy #timetable_for_vacancy').val();
	var quota = $('#create_time_table_for_vacancy #timetable_quota_for_vacancy').val();
	var id_address = $('#create_time_table_for_vacancy select#address2').val();
	error_flag = false;
	
	if(date_interview == ''){
			$('#create_time_table_for_vacancy #timetable_for_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_vacancy #timetable_for_vacancy').removeClass('error_field');
		}
		
	if(quota == ''){
			$('#create_time_table_for_vacancy #timetable_quota_for_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_vacancy #timetable_quota_for_vacancy').removeClass('error_field');
		}	
		
	if(id_address == ''){		
			$('#create_time_table_for_vacancy div#address_block').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_time_table_for_vacancy div#address_block').removeClass('error_field');
		}	
		
	if(!error_flag){
			$.ajax({
			  url: jsPath + "vacancies/create_time_table_for_vacancy",
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy, 
					  date_interview:date_interview,
					  quota:quota,
					  id_address: id_address,
					 },			  
			  success: function(id_vacancy){				
				if(id_vacancy > 0){
					$("#create_time_table_for_vacancy #result").html('<p style="color: Green;">Расписание успешно создано.</p>');
					$('#create_time_table_for_vacancy #timetable_for_vacancy').val('');
					$('#create_time_table_for_vacancy #timetable_quota_for_vacancy').val('');
					//$.pjax.reload({container:'#pjax_1'}); 
					clickOnVacancy(id_vacancy);
					
				}else{
						$("#create_time_table_for_vacancy #result").html('<p style="color: Red;">Ошибка. Не выделена вакансия.</p>');
						
					}	
			  }
			});
		}
	
}	

/*Создание Источника информации*/
function source_create() {
		var source_name = $('#create_source #name_source').val();
		
		error_flag = false;
		
		if(source_name == ''){
			$('#create_source #name_source').addClass('error_field');
			error_flag = true;
		}else{
			$('#create_source #name_source').removeClass('error_field');
		}
						
		if(!error_flag){
			$.ajax({
			  url: jsPath + "sources/createwithoutredirect",
			  type: "POST",		 
			  data:  {source_name:source_name},			  
			  success: function(data){				
				if(data == 1){
					$("#create_source #result").html('<p>Источник информации успешно создан.</p>');
					$('#create_source #name_source').val('');					
					
					$.pjax.reload({container:'#pjax_2'}); 
				}else{
						$("#create_source #result").html('<p>При создании источника произошла ошибка.</p>');						
					}	
			  }
			});
		}
	}

function getTimetablesByMarketsId(id_market){
	/*
	$.ajax({
			  //url: jsPath + "vacancies/gettimetablesbymarketsid",
			  url: jsPath + "vacancies/gettimetablesbymarketsid",
			  type: "POST",		 
			  data:  {id_market:id_market },			  
			  success: function(data){				
				$("#timetables_market").html(data);
			  }
			});*/
}

/*Список источников*/
function getSourcesByMarketsId(id_market){
	$.ajax({
			  //url: jsPath + "vacancies/getsourcesbymarketsid",
			  url: jsPath + "vacancies/getsourcesbymarketsid",
			  type: "POST",		 
			  data:  {id_market:id_market },			  
			  success: function(data){				
				$("#sources_market").html(data);
			  }
			});
}
	
function vacancy_refresh() {	
	$.pjax.reload({container:'#pjax_1'}); 	
	$.pjax.reload({container:'#pjax_2'}); 	
}

/*Снимает с публикации расписание для магазина*/
function unpublish_timetable_market(Element){
	var id_market = $('#markets-id').val();
	var id_row_timetable =  Element.attr("id_row");
	$.ajax({
			  url: jsPath + "vacancies/unpublish_timetable_market",
			  type: "POST",		 
			  data:  {id_market:id_market, id_row_timetable },			  
			  success: function(data){				
				$("#timetables_market").html(data);
			  }
			});
}

/*Открывает модальное окно редактирования расписания для вакансии*/
function edit_timetable_vacancy(id_timetable){
	$.ajax({			  
			  url: jsPath + "vacancies/getdatatimetablevacancy",
			  type: "POST",		 
			  data:  {id_timetable:id_timetable},			  
			  success: function(data){	
				var result = JSON.parse(data);
				if(result['error'] == 0){				
					$("#edit_time_table_for_vacancy #timetable_for_vacancy").val(result['date_interview']);
					
					$("#edit_time_table_for_vacancy #timetable_quota_for_vacancy").val(result['quota']);					
					$("#edit_time_table_for_vacancy #address3").val(result['id_address']).change();
					$("#edit_time_table_for_vacancy #btn_update").attr('id_timetable', result['id']);
					
					$('#modal_edit_timetable_vacancy').modal({show:true});
				}else{
					alert('Произошла ошибка при открытии окна редактирования');
				}
				
			  }
			});
}

function timetable_for_vacancy_update(Element){
	var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
	var id_timetable =  Element.attr("id_timetable");
	var date_interview = $('#edit_time_table_for_vacancy #timetable_for_vacancy').val();
	var quota = $('#edit_time_table_for_vacancy #timetable_quota_for_vacancy').val();
	var id_address = $('#edit_time_table_for_vacancy select#address3').val();
	error_flag = false;
	
	if(date_interview == ''){
			$('#edit_time_table_for_vacancy #timetable_for_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#edit_time_table_for_vacancy #timetable_for_vacancy').removeClass('error_field');
		}
		
	if(quota == ''){
			$('#edit_time_table_for_vacancy #timetable_quota_for_vacancy').addClass('error_field');
			error_flag = true;
		}else{
			$('#edit_time_table_for_vacancy #timetable_quota_for_vacancy').removeClass('error_field');
		}	
		
	if(id_address == ''){		
			$('#edit_time_table_for_vacancy div#address_block').addClass('error_field');
			error_flag = true;
		}else{
			$('#edit_time_table_for_vacancy div#address_block').removeClass('error_field');
		}	
		
	if(!error_flag){
			$.ajax({
			  url: jsPath + "vacancies/updatetimetablewithoutredirect",
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy, 
					  id_timetable:id_timetable,	
					  date_interview:date_interview,
					  quota:quota,
					  id_address: id_address,
					 },			  
			  success: function(id_vacancy){				
				if(id_vacancy > 0){
					$("#create_time_table_for_vacancy #result").html('<p>Расписание успешно создано.</p>');
					$('#create_time_table_for_vacancy #timetable_for_vacancy').val('');
					$('#create_time_table_for_vacancy #timetable_quota_for_vacancy').val('');
					//$.pjax.reload({container:'#pjax_1'}); 
					clickOnVacancy(id_vacancy);
					
				}else{
						$("#create_time_table_for_vacancy #result").html('<p>При создании расписания произошла ошибка.</p>');
						
					}	
			  }
			});
		}
}

/*Снимает с публикации расписание для вакансии*/
function unpublish_timetable_vacancy(Element){
	var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
	var id_row_timetable =  Element.attr("id_row");
	$.ajax({
			  url: jsPath + "vacancies/unpublish_timetable_vacancy", 
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy, id_row_timetable },			  
			  success: function(data){				
				$("#timetables_vacancy").html(data);
			  }
			});
}

/*Удаляет расписание Магазина*/
function delete_timetable_market(Element){
	var id_market = $('#markets-id').val();
	var id_row_timetable =  Element.attr("id_row");
	$.ajax({
			  url: jsPath + "vacancies/delete_timetable_market",
			  type: "POST",		 
			  data:  {id_market:id_market, id_row_timetable },			  
			  success: function(data){				
				$("#timetables_market").html(data);
			  }
			});
}

/*Удаляет расписание Вакансии*/
function delete_timetable_vacancy(Element){
	var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
	var id_row_timetable =  Element.attr("id_row");
	$.ajax({
			  url: jsPath + "vacancies/delete_timetable_vacancy",
			  type: "POST",		 
			  data:  {id_vacancy:id_vacancy, id_row_timetable },			  
			  success: function(data){				
				$("#timetables_vacancy").html(data);
			  }
			});
}

/*Удаляет Источник информации Магазина*/
function delete_source_from_market(Element){
	var id_market = $('#markets-id').val();
	var id_row_source =  Element.attr("id_row");
	$.ajax({
			  url: jsPath + "vacancies/delete_source_market",
			  type: "POST",		 
			  data:  {id_market:id_market, id_row_source },			  
			  success: function(data){				
				$("#sources_market").html(data);
			  }
			});
}

function delete_source(id_source){
	$.ajax({
			  url: jsPath + "vacancies/deletesourcewithoutredirect",
			  type: "POST",		 
			  data:  {id_source:id_source},
			  success: function(data){				
				if(data == 1){					
					$.pjax.reload({container:'#pjax_2'}); 					
				}else{
						alert('При удалении источника произошла ошибка');
					}
			  }
			});
}

function load_vakansyes(){

    id_source= "";
    $.ajax({
        url: jsPath + "vacancies/load_vakansyes",
        type: "POST",
        data:  {id_source:id_source},
        success: function(data){

            $("#rez_load_vakansyes").html(data);

            if(data == 1){
               // $.pjax.reload({container:'#pjax_2'});
            }else{
                //alert('При создании вакансий произошла ошибка');
            }
        }
    });
}

function set_rm() {

    var id_market = $('#markets-id').val();

    $.ajax({
        url: jsPath + "vacancies/get_rm",
        type: "POST",
        data:  {id_market:id_market},
        success: function(data){

            $("#rm_value").text(data);


        }
    });
}