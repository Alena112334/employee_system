'use strict';

function initDate(el){
	el.val(getCurDate());
		$.datepicker.regional['ru'] = {
			closeText: 'Закрыть',
			prevText: '&#x3c;Пред',
			nextText: 'След&#x3e;',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			'Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			dateFormat: 'dd-mm-yy',
			firstDay: 1,
			isRTL: false
			};
		$.datepicker.setDefaults($.datepicker.regional['ru']);
		el.datepicker( $.datepicker.regional[ "ru" ] );
		
}

function getCurDate(){
	var dateStr = moment().format('DD-MM-YYYY');
	return dateStr;
}

function getWorkers(date){
	console.log(date);
	 $.ajax({
		type: "POST",
		url: "/worker/get",
		data: {"date":date, "is_reload": false},
		success: function(response) 
		{
		  var notFoundStr = "<div class='row justify-content-center'><div class='col-auto'>Результаты по заданному месяцу не найдены.</div></div>";
		  if(response){
		  	console.log(response);
			var result = $.parseJSON(response);
			if(result.err) {
				alert(result.err);
				return;
			}
			$("#workers-block").empty();
			var workers = result.res;
			if(workers.length == 0){
				$("#workers-block").append(notFoundStr);
			}else {
				var data = "<table class='table' id='workers'>"+
				  "<thead>"+
					"<tr>"+
					  "<th>№</th>"+
					  "<th>Фото</th>"+
					  "<th>Фамилия</th>"+
					  "<th>Имя</th>"+
					  "<th>Должность</th>"+
					  "<th>Зарплата</th>"+
					"</tr>"+
				  "</thead>"+
				  "<tbody>";
				var rowNum = 0, len = workers.length;
				for(var i=0; i<len; i++){
				  rowNum++;
				  var photo = workers[i].photo ? workers[i].photo.slice(0, -4) + "_min" + workers[i].photo.slice(-4) : "/photo/w/no_photo_min.jpg";
				  data += "<tr>"+
					  "<th scope='row'>"+rowNum+"</th>"+
					  "<td data-id='photo'><a href='"+workers[i].photo+"' data-fancybox data-caption='"+workers[i].first_name+" "+workers[i].last_name+"'>"+
						"<img class='photo-min' src='"+photo+"' alt='"+rowNum+"'/>"+
					  "</a></td>"+
					  "<td data-id='firstName'>"+workers[i].first_name+"</td>"+
					  "<td data-id='lastName'>"+workers[i].last_name+"</td>"+
					  "<td data-id='prof'>"+workers[i].profession+"</td>"+
					  "<td data-id='pay' data-cur='"+Math.floor(workers[i].pay)+"'>"+Math.floor(workers[i].pay)+"</td>"+
					"</tr>";
				}
				$("#workers-block").append(data);
			}
		  } else {
			  $("#workers-block").append(notFoundStr);
			}
		}
	  });
}

function transfer(isToDollar){
    if ($("#usrutd").text()) {
        $("#workers tr").each(function(){
            $("td[data-id = 'pay']",this).each(function(){
                var cur = $(this).attr("data-cur");
                var us = $("#usrutd").text();
                var pay = isToDollar ? cur/us : cur*us;
                $(this).attr("data-cur", pay);
                $(this).text(Math.floor(pay));
            });
        });
    }
}

function initCreateWorker(formData){
	if(isNaN($("#salaryInput").val())) { alert("Поле 'Зарплата' должно быть числом! "); return;}
	$.ajax({
		type: "POST",
		url: "/worker/set",
		contentType: false,
		processData: false,
		data: formData,
		success: function(response){
            console.log(response);
            alert("Изменения внесены!");
            $(location).attr('href', '/');
		}
	  });
}
 
function setPrize(formData) {
    if(isNaN($("#prizeInput").val())) { alert("Поле 'Зарплата' должно быть числом! "); return;}
    $.ajax({
        type: "POST",
        url: "/worker/setprize",
        contentType: false,
        processData: false,
        data: formData,
        success: function(response){
        	console.log(response);
            alert("Изменения внесены!");
            $(location).attr('href', '/');
        }
    });
}
