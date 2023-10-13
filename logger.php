<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Создаем логгер 
$log = new Logger('mylogger');

// Хендлер, который будет писать логи в "log.txt" и слушать все ошибки с уровнем "INFO" и выше .
$log->pushHandler(new StreamHandler('log.txt', Level::Info));

