<div id="create_candidat">
	<h3>Запись на собеседование на вакансию:</h3>
    <h3 style="color:green;" id="vakancy_name_tittle"></h3>
	<div class="block">
		<span>Дата собеседования: </span><span id="date_timetable"></span> <span id="address_timetable" style="display: none;"></span>
	</div>

    <!--<label class="control-label">Источники информации для магазина:</label>-->
    <!--<div id="sources_market" class="form-group"><span class="gray">Необходимо выбрать <u>Магазин</u></span></div>-->
	
	<div class="block">
		<p>ФИО кандидата</p>
		<input id="fio_candidat" value="<?php echo $fio;?>" type="text" />
	</div>	
	
	<div class="block">
		<p>Телефон кандидата</p>
		<input id="phone_candidat" value="<?php echo $phone;?>" type="text" />
	</div>	
	
	<div class="block">
		<p>Возраст кандидата</p>
		<input id="age_candidat" type="text" value="<?php echo $age;?>"/>
	</div>

    <div class="block">
        <p>Гражданство кандидата</p>
        <input id="nation_candidat" type="text" value="<?php echo $nation;?>"/>
    </div>
	

	
	<div class="block">	
		<div id="btn_create" class ="btn btn-primary" id_timetable="" rezerv="" id_candidat="<?php echo $id_candidat;?>" onclick="create_candidat($(this))">Записать</div>
		<div id="btn_cancel" class ="btn btn-warning" onclick="cancel_candidat()">Отмена</div>
	</div>	
	
	
	
	<div class="block">	
		<div id="result"></div>
		<div id="result_text" style="display: none;">
			<p><b><i>
				Вы записаны на собеседование [дата, время], собеседование проходит по адресу [зачитать адрес]. Всё верно?"<br/>
				<span style="color:red; font-size: 16px;">Вопрос : «Вы знаете, как добраться до магазина?»</span><br/>
				<span style="color:red; font-size: 16px;">Если нет, то консультируем по 2Gis</span><br/><br/>
				Будем ждать Вас на собеседовании. Если у Вас изменятся планы , пожалуйста, перезвоните по этому номеру, мы подберем другую дату.
				</i></b>
			</p>
			
			<p>
				<u>Для склада:</u>  <b>Обратите, пожалуйста, внимание, что въезд на территорию РЦ с Каширского шоссе (М4) , НЕ с ул. Дорожная) На территории следует двигаться по знакам: после КПП – направо, далее прямо мимо склада (зона отгрузки), обогнуть примыкающее двухэтажное здание белого цвета – административный корпус. </b>
			</p>
			
			<!-- <p>
				Если Соискатель записывается на вакансию в РЦ (склад Ступино), то ОБЯЗАТЕЛЬНО!!!! спрашиваем, как будет добираться на своем авто, на общественном транспорте (пешком), а также вносим данную информацию в поле доп.комментарии.

			</p> -->
		</div>
		<div id="send_sms_block" style="">
			<p>Отправить Вам смс с адресом и временем проведения собеседования?</p>
			<input id="btn_send_sms" type="button" value="Отправить SMS кандидату"/>
			<span id="is_zum" style="display: none;">0</span>
			<div id="sms_result"></div>
		</div>
	</div>

</div>