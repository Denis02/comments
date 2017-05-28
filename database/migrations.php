<?php
/* Подключение к БД */
$db = new PDO("mysql:host=localhost;dbname=comments_db;charset=utf8", "homestead", "secret");
/* Создание таблиц, если их не существует*/
try
{
//  таблица Пользователей
    $db->query("CREATE TABLE IF NOT EXISTS users(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");

    /*таблица Комментариев содержит
    id пользователя написавшего комментарий и
    id комментария для определения вложенности комментария*/
    $db->query("CREATE TABLE IF NOT EXISTS comments(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	text MEDIUMTEXT NOT NULL,
	user_id INT(10) UNSIGNED NOT NULL,
	comment_id INT(10) UNSIGNED,
	created_at DATETIME NOT NULL,
	updated_at DATETIME
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");

    /*таблица Оценок для связи комментария с 
    пользователем оценившем его*/
    $db->query("CREATE TABLE IF NOT EXISTS appraisals(
	user_id INT(10) UNSIGNED NOT NULL,
	comment_id INT(10) UNSIGNED NOT NULL,
	value BOOLEAN NOT NULL DEFAULT 0,
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (comment_id) REFERENCES comments(id),
	UNIQUE (user_id,comment_id)
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
catch(PDOException $e)
{
    var_dump($db);
    die("Error: ".$e->getMessage());
}

/* Отключение от БД */
$db = null;