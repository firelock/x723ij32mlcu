<?php
	
	$name = $_GET['name']; // Вытаскиваем имя в переменную
	$phone = $_GET['phone'];
	$email = $_GET['email'];
	$text = $_GET['text'];
	$message = "Заявка с вашего сайта \r\n Имя : $name \r\n Телефон: $phone \r\n E-mail: $email \n Сообщение: $text"; // Формируем сообщение, отправляемое на почту
	$to = "zakaz@brasletpromo.ru"; // Задаем получателя письма
	$from = "brasletpromo.ru"; // От кого пришло письмо
	$subject = "Заяка c brasletpromo.ru"; // Задаем тему письма
	$headers = "From: $from\r\nReply-To: $to\r\nContent-type: text/html; charset=utf-8\r\n"; // Формируем заголовок письма (при неправильном формировании может ломаться кодировка и т.д.)
	if (mail($to, $subject, $message, $headers)) { // При помощи функции mail, отправляем сообщение, проверяя отправилось оно или нет
		header('Location: http://new.brasletpromo.ru/contact-page');
	};

?>