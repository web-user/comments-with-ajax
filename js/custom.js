/*global jQuery:false */
jQuery(document).ready(function($) {

            function AjaxFormRequest(result_id,form_id,url) {
                jQuery.ajax({
                    url:     url, //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных
                    data: jQuery("#"+form_id).serialize(), 
                    success: function(response) { //Если все нормально
                    document.getElementById(result_id).innerHTML = response;
                },
                error: function(response) { //Если ошибка
                document.getElementById(result_id).innerHTML = "Ошибка при отправке формы";
                }
             });
        }



        $(document).ready(function(){
          /* Следующий код выполняется только после загрузки DOM */
          
          /* Данный флаг предотвращает отправку нескольких комментариев: */
          var working = false;
          
          /* Ловим событие отправки формы: */
          $('#addCommentForm').submit(function(e){

            e.preventDefault();
            if(working) return false;
            
            working = true;
            $('#submit').val('Working..');
            $('span.error').remove();
            
            /* Отправляем поля формы в submit.php: */
            $.post('form.php',$(this).serialize(),function(msg){

              working = false;
              $('#submit').val('Submit');
              
              if(msg.status){

                /* 
                / Если вставка была успешной, добавляем комментарий 
                / ниже последнего на странице с эффектом slideDown
                /*/

                $(msg.html).hide().insertBefore('#addCommentContainer').slideDown();
                $('#body').val('');
              }
              else {

                /*
                / Если есть ошибки, проходим циклом по объекту
                / msg.errors и выводим их на страницу
                /*/
                
                $.each(msg.errors,function(k,v){
                  $('label[for='+k+']').append('<span class="error">'+v+'</span>');
                });
              }
            },'json');

          });
          
        });



});