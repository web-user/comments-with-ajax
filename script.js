$(document).ready(function(){
	/* Следующий код выполняется только после загрузки DOM */
	
	/* Данный флаг предотвращает отправку нескольких комментариев: */
	var working = false;
	
	/* Ловим событие отправки формы: */
	$('#imageform').submit(function(e){

 		e.preventDefault();
		if(working) return false;
		
		working = true;
		$('#submit2').val('Engaged...');
		$('span.error').remove();
		
		/* Отправляем поля формы в submit.php: */
		$.post('submit.php',$(this).serialize(),function(msg){

			working = false;
			$('#submit2').val('Submit');
			
			if(msg.status){


				$(msg.html).hide().insertBefore('#newcoment').slideDown();
				$('#body').val('');
			}
			else {

				/*
				/	Если есть ошибки, проходим циклом по объекту
				/	msg.errors и выводим их на страницу
				/*/
				
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');

	});
	
});