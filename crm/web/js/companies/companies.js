var jsPath = window.location.origin+'/'; // + "/softprog.ru/crm/";



$( document ).ready(function() {

    renderContacts();
	
	$('#button').click(function() {
        renderContacts();
	});

	//Форма создания контакта
    $('#create_contact').on('beforeSubmit', function() {
        var data = {};
        $('#create_contact').find('input, select, textarea').each(function() {

            if($(this).attr('type').toLowerCase() != 'checkbox') {
                data[$(this).attr('name')] = this.value;
            }
            else {
                data[$(this).attr('name')] = this.checked;
            }
        });

         $.ajax({
                //url: $form.attr('action'),
                url:'/softprog.ru/crm/contacts/create_without_redirect',
                type: 'POST',
                data: data,
                success: function (data) {
                    if(data == 'ok'){
                        $('#contact_modal').modal('hide');
                        $.pjax.reload({container:"#modal_pj_contacts"});//Очистка формы создания
                        renderContacts();
                    }else{
                        $('#status').html('<p style="color: red";>Во время создания Контакта произошла ошибка</p>');
                    }
                },
                error: function(jqXHR, errMsg) {
                    //alert(errMsg);
                }
            });
            return false; // prevent default submit

    });

    //Форма создания проекта
    $('#create_project').on('beforeSubmit', function() {
        var data = {};
        $('#create_project').find('input, select, textarea').each(function() {
            if($(this).prop('nodeName').toLowerCase() == 'checkbox'){
                data[$(this).attr('name')] = this.checked;
            }else
                if( $(this).prop('nodeName').toLowerCase() == 'select'){
                    data[$(this).attr('name')] = $(this).val();
                }else{
                    data[$(this).attr('name')] = this.value;
                }
        });

        $.ajax({
            //url: $form.attr('action'),
            url:'/softprog.ru/crm/projects/create_without_redirect',
            type: 'POST',
            data: data,
            success: function (data) {
                if(data == 'ok'){
                    $('#project_modal').modal('hide');
                    $.pjax.reload({container:"#modal_pj_projects"});//Очистка формы создания
                    renderProjects();
                }else{
                    $('#status').html('<p style="color: red";>Во время создания Проекта произошла ошибка</p>');
                }
            },
            error: function(jqXHR, errMsg) {
                //alert(errMsg);
            }
        });
        return false; // prevent default submit

    });

    //$('#comment .redactor-editor').on('change', function() {

    $('#comment_item1 .redactor-editor').on('change', function() {
        alert($(this).html());
    });



});

function getForm(id_form){
    var form1 = $(id_form);
    return form1.serialize();
}

function renderContacts() {
    var company_id = $('#company_id').text();

    $.ajax({
        url: jsPath + "/companies/get_contacts_part",
        type: "POST",
        async: false,
        data:  {
            company_id:company_id
        },
        success: function(data){
            $("#contacts").html(data);

            $('#contacts .item input').bind('click', function() {
                var field_name = $(this).attr('field_name');
                var id = $(this).attr('id_item');

                $('div[id_item_'+field_name+'="'+id+'"]').css('display', 'inline-block');

                $('div[id_item_'+field_name+'="'+id+'"]').bind('click', function() {
                    updateField($(this));
                });

            });
        },

        error: function(data){
            $("#contacts").html('<p>Произошла ошибка при отображении контактов</p>');
        },
        complete: function(){
            //renderProjects();
        }
    }).then(renderProjects());
}

function updateField(el, type_fields=''){
    var field_name = el.attr('field_name');
    var id = el.attr('id_item_' + field_name);
    var controller_name = el.attr('controller_name');
    if(type_fields == 'select' ){
        var value = el.val();
    }

    if(type_fields == 'dateinput' ){
        var value = el.val();
    }

    if(type_fields == 'textarea'){
        var value = $('.item textarea[field_name="' + field_name + '"][id_item="' + id + '"]').val();
    }

    if(type_fields == 'textarea_this'){
        var value = el.val();
    }

    if(type_fields == 'input_this'){
        var value = el.val();
    }

    if(type_fields == ''){
        var value = $('.item input[field_name="' + field_name + '"][id_item="' + id + '"]').val();
    }

    $.ajax({
        url: jsPath + controller_name + "/update_field",
        type: "POST",
        async: false,
        data:  {
            id:id
            ,field_name:field_name
            ,value:value
        },
        success: function(data){
            if(data == 'ok'){
                $("#status").html('<p class="green">Изменения сохранены</p>');
            }else{
                $("#status").html('<p class="red">'+data+'</p>');
            }

            $('div[id_item_'+field_name+'="'+id+'"]').css('display', 'none');
        },

        error: function(data){
            $("#status").html('<p class="red">Произошла ошибка при отображении контактов</p>');
        },

    });
}

function renderProjects() {
    var company_id = $('#company_id').text();

    $.ajax({
        url: jsPath + "companies/get_projects_part",
        type: "POST",
        async: false,
        data:  {
            company_id:company_id
        },
        success: function(data, company_id){
            $("#projects").html(data);

            $('#projects .item input').bind('click', function() {
                var field_name = $(this).attr('field_name');
                var id = $(this).attr('id_item');
                $('#projects div[id_item_'+field_name+'="'+id+'"]').css('display', 'inline-block');

                $('#projects div[id_item_'+field_name+'="'+id+'"]').bind('click', function() {
                    updateField($(this));
                });

            });

        },

        error: function(data){
            $("#projects").html('<p>Произошла ошибка при отображении проектов</p>');
        },
        complete: function(){
            //renderTasks();
        }
    }).then(renderTasks());
}

function renderTasks() {

    $(".id_project" ).each(function( index ) {
        //console.log( index + ": " + $( this ).text() );
        var id_project = $( this ).attr("id_project");
        setContentTask(id_project);
    });

    //Форма загрузки файлов
    /*$('form.load_file').on('beforeSubmit', function() {
        var data = {};
        data['file']


        $('#create_project').find('input, select, textarea').each(function () {
            if ($(this).prop('nodeName').toLowerCase() == 'checkbox') {
                data[$(this).attr('name')] = this.checked;
            } else if ($(this).prop('nodeName').toLowerCase() == 'select') {
                data[$(this).attr('name')] = $(this).val();
            } else {
                data[$(this).attr('name')] = this.value;
            }
        });

        $.ajax({
            //url: $form.attr('action'),
            url: '/softprog.ru/crm/attaches/loadfile',
            type: 'POST',
            data: data,
            success: function (data) {
                if (data == 'ok') {
                    //$('#project_modal').modal('hide');
                    //$.pjax.reload({container: "#modal_pj_projects"});//Очистка формы создания
                    //renderProjects();
                    $("#status").html('<p class="green">Файл загружен</p>');
                } else {
                    $('#status').html('<p style="color: red";>Во время создания Проекта произошла ошибка</p>');
                }
            },
            error: function (jqXHR, errMsg) {
                //alert(errMsg);
            }
        });
        return false; // prevent default submit
    });*/

}

function setContentTask(id_project){
    $.ajax({
        url: jsPath + "companies/get_tasks_part",
        type: "POST",
        async: false,
        data:  {
            id_project:id_project
        },
        success: function(data){
            // $("#prjects").html(data);
            if(data != '-'){
                $("div.id_project[id_project="+id_project+"]").after( data );
            }

            //Форма создания задачи
            $('#create_task_'+id_project).bind('submit', function() {
                //alert('123123123-123123123');
                var data = {};
                $('#create_task_'+id_project).find('input, select, textarea').each(function() {

                    if($(this).prop('nodeName').toLowerCase() == 'checkbox'){
                        data[$(this).attr('name')] = this.checked;
                    }else
                    if( $(this).prop('nodeName').toLowerCase() == 'select'){
                        data[$(this).attr('name')] = $(this).val();
                    }else{
                        data[$(this).attr('name')] = this.value;
                    }
                });

                console.log(data);

                $.ajax({
                    url:'/softprog.ru/crm/tasks/create_without_redirect',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        if(data == 'ok'){
                            $('#task_modal').modal('hide');
                            $.pjax.reload({container:"#modal_pj_tasks"});//Очистка формы создания
                            renderTasks();
                        }else{
                            $('#status').html('<p style="color: red";>Во время создания Задачи произошла ошибка</p>');
                        }
                    },
                    error: function(jqXHR, errMsg) {
                        //alert(errMsg);
                    }
                });
                return false; // prevent default submit

            });





            $('.tasks_item textarea').bind('click', function() {
                var field_name = $(this).attr('field_name');
                var id = $(this).attr('id_item');
                $('.tasks_item div[id_item_'+field_name+'="'+id+'"]').css('display', 'inline-block');
            });

        },
        error: function(data){
            $("#status").html('<p style="color: red;">Произошла ошибка при отображении заметок</p>');
        }
    });
}

function delete_attache(el){
    var server_file_name = el.attr('server_file_name');
    var id_attache = el.attr('id_attache');
    var id_task = el.attr('task_id');

    $.ajax({
        url: jsPath + "attaches/deleteattache",
        type: "POST",
        async: false,
        data:  {
             sfile:server_file_name
            ,id_attache:id_attache
        },
        success: function(data){
            if(data == 'ok'){
                $("#status").html('<p class="green">Файл удален</p>');
                render_attaches(id_task);//Обновление списка файлов
            }else{
                $("#status").html('<p class="red">'+data+'</p>');
            }

        },

        error: function(data){
            $("#status").html('<p class="red">Произошла ошибка при удалении файла</p>');
        },

    })
}

function render_attaches(id_task){
    $.ajax({
        url: jsPath + "attaches/renderattaches",
        type: "POST",
        async: false,
        data:  {
            id_task:id_task
        },
        success: function(data){
            //alert();
            $('#attaches_task_'+id_task).html(data);
        },

        error: function(data){
            $("#status").html('<p class="red">Произошла ошибка при удалении файла</p>');
        },

    })
}

