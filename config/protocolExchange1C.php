<?php

return [
    /*
     * Путь роута, который будет слушать при получении данных о каталоге товаров,
     * роут регистрируется в сервис провайдере пакета. Т.е. адрес, по которому
     * будет стучаться 1с будет:
     * http(s)://адрес.сайта/значениеПараметра1cRouteNameCatalog
     */
    '1cRouteNameCatalog' => 'in',

    /*
     * Путь, где будут храниться файлы, принятые от 1С
     */
    'inputPath'          => storage_path('1cExchange'),

    /*
     * Максимальный размер одного пакета от 1С, байт
     */
    'maxFileSize'        => 1 * 1000 * 1024,

    /*
     * Файл(ы), для тестов. Файлы будут переданы в шаге протокола обмена - file.
     * Должен быть полный путь.
     * http://v8.1c.ru/edi/edi_stnd/131/
     */
    'filesToSendTest'    => [],

    /*
     * Файл(ы), для тестов. Файлы, которые должны быть обработаны. Протокол
     * обмена, шаг - import (параметр filename для mode=import)
     */
    'filesToWorkTest'    => [],

    /*
     * Имя пользователя и пароль для тестов, если пользователя нет - будет
     * создан, после успешного окончания тестов - удален НЕ БУДЕТ.
     */
    'userEmailToTest'    => env('1C_USER_LOGIN'),
    'userPasswordToTest' => env('1C_USER_PASSWORD'),

    /*
     * Модель, которая будет выполнять обработку принятого каталога от 1С.
     * Модель должна реализовывать интерфейс \Mavsan\LaProtocol\Interfaces\Import
     */
    'catalogWorkModel'   => \App\Models\Bitrix\Exchange::class,

    /*
     * Записывать в лог команды, присылаемые от 1С
     */
    'logCommandsOf1C'    => true,

    /*
     * Гейт(ы) для проверки пользователя после авторизации. Например - есть ли
     * у него нужная роль. В гейт будет передан экземпляр авторизированного
     * пользователя. Впрочем его можно получить Auth::user(). Будут вызваны все
     * гейты, указанные в массиве.
     */
    'gates'              => [],
];
