<?php

session_start();
date_default_timezone_set('europe/kiev');

// Константы проекта
define('ROOT_DIR',getcwd().'/../');
define('RESOURCES_DIR',getcwd().'/../resources/');
define('APP_DIR',getcwd().'/../app/');

// Автозагрузка классов
spl_autoload_register(function (string $class){
    $file = APP_DIR.str_replace('\\','/',$class).'.php';
    if(is_file($file)){
        require_once $file;
    }
});

// Глобальная функция для вывода страницы
function view(string $content, array $data = null, string $layout='app'){
    ob_start();
    include_once RESOURCES_DIR.'views/contents/'.$content.'.php';
    $content = ob_get_clean();
    include_once RESOURCES_DIR.'views/layouts/'.$layout.'.php';
}

// Глобальная функция конфигураций базы данных
function dbConfig(){
    return [
        'dsn' => 'mysql:host=localhost;dbname=comments_db;charset=utf8',
        'user' => 'homestead',
        'pass' => 'secret'
    ];
}
// Запуск миграций базы данных
include_once ROOT_DIR.'database/migrations.php';

// Подключение файла маршрутизации
require_once ROOT_DIR.'app/routes.php';




