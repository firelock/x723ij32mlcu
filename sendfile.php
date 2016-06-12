<?php
	
	$name = $_GET['name']; // Вытаскиваем имя в переменную
	$phone = $_GET['phone'];
	$email = $_GET['email'];
	$text = $_GET['text'];
	$message = "Заявка с вашего сайта \r\n Имя : $name \r\n Телефон: $phone \r\n E-mail: $email \n Сообщение: $text"; // Формируем сообщение, отправляемое на почту
	$to = "idsuf@yandex.ru"; // Задаем получателя письма
	$from = "brasletpromo.ru"; // От кого пришло письмо
	$subject = "Заяка c brasletpromo.ru"; // Задаем тему письма
	$headers = "From: $from\r\nReply-To: $to\r\nContent-type: text/html; charset=utf-8\r\n"; // Формируем заголовок письма (при неправильном формировании может ломаться кодировка и т.д.)
	if (mail($to, $subject, $message, $headers)) { // При помощи функции mail, отправляем сообщение, проверяя отправилось оно или нет
		header('Location: http://new.brasletpromo.ru/contact-page');
	};

?>

<?

/*
 * Перед использованием необходимо вручную создать каталог для загруженных файлов и назначить на него права "777"
 */

// Генерация случайной строки
function rnd_str($length = 10) {

	$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$charactersLength = strlen($characters);
	$randomString = "";

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;

}

// Отправка сообщения по e-mail
function send_mail($to, $title, $msg) {

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	mail($to, $title, $msg, $headers);

}

// Удаление старых файлов
function clear_old_files($dir, $expire_time = 172800) {

	if (is_dir($dir)) {

		if ($dh = opendir($dir)) {

			while (($file = readdir($dh)) !== false) {

				$time_sec = time();

				$time_file = filemtime($dir . $file);

				$time = $time_sec-$time_file;

				$unlink = $dir . $file;

				if (is_file($unlink))
					if ($time > $expire_time)
						unlink($unlink);

			}

			closedir($dh);

		}
	}
}

if (isset($_POST["upload_file"])) {

	$file_format = array_pop(explode(".", basename($_FILES['file']['name']))); // Определяем формат файла

	$upload_dir = "uploads/"; // Папка для загрузки

	$expire_time = 172800; // Время через которое файл считается устаревшим (в сек.)
	clear_old_files($upload_dir, $expire_time); // Удаляем старые файлы

	// Пытаемся записать файл
	while(true) {

		$path = $upload_dir . rnd_str() . "." . $file_format; // Генерируем имя для файла

		//
		if (!file_exists($path)) {

			// Файл успешно загружен
			if (copy($_FILES["file"]["tmp_name"], $path))
			{

				$to = "idsuf@yandex.ru"; // Эл. почта
				$title = "Пришёл файл от клиента!"; // Тема
				$msg = '<a traget="_blank" href="http://' . $_SERVER["SERVER_NAME"] . '/' . $path . '">Скачать файл</a>'; // Сообщение

				send_mail($to, $title, $msg); // Отправка письма

			}

			// Ошибка при загрузке...
			else echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";

			break;

		}

	}

}

?>