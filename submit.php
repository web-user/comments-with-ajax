<?php

// Сообщение об ошибке:
error_reporting(E_ALL^E_NOTICE);

include "connect.php";
include "comment.class.php";

/*
/	Данный массив будет наполняться либо данными,
/	которые передаются в скрипт,
/	либо сообщениями об ошибке.
/*/

$arr = array();
$validates = Comment::validate($arr);

if($validates)
{
	/* Все в порядке, вставляем данные в базу: */
	
	mysql_query("	INSERT INTO comments(email,name,phone,body)
					VALUES (
						'".$arr['email']."',
						'".$arr['name']."',
						'".$arr['phone']."',
						'".$arr['body']."'
					)");
	
	$arr['dt'] = date('r',time());
	$arr['id'] = mysql_insert_id();

	// тема письма
	$thm = "Коментарий";

	        // текст письма
	$newtext = wordwrap($message_new, 30, "<br />\n");

	$email = $arr['email'];

	// текст письма
	$message = " 
	<html>
	<head>
	</head>
	<body>
	     <div >
	     	<p>".$arr['name']." Благодарим за оставленый коментарий!</p>
	     	</div>
			</body>
			</html>";


	// Для отправки HTML-письма должен быть установлен заголовок Content-type
	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	// Дополнительные заголовки
	$headers .= 'To: Admin' . "\r\n";

	$headers .= 'From: Sate' . "\r\n";

	$headers .='X-Mailer: PHP/' . phpversion(); 

	mail($email, $thm, $message,  $headers );


	
	/*
	/	Данные в $arr подготовлены для запроса mysql,
	/	но нам нужно делать вывод на экран, поэтому 
	/	готовим все элементы в массиве:
	/*/
	
	$arr = array_map('stripslashes',$arr);
	
	$insertedComment = new Comment($arr);

	/* Вывод разметки только-что вставленного комментария: */

	echo json_encode(array('status'=>1,'html'=>$insertedComment->markup()));

}
else
{
	/* Вывод сообщений об ошибке */
	echo '{"status":0,"errors":'.json_encode($arr).'}';
}

?>