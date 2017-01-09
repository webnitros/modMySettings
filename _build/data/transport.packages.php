<?php
/**
 * Created by PhpStorm.
 * User: burgen
 * Date: 09.01.2016
 * Time: 13:50
 */
// Resources
$packages_in = array(
    'pdoTools' => array(
        'pagetitle' => 'pdoTools',
        'checked'   => 1,
        'desc'      => 'Микро-библиотека для быстрой выборки данных из СУБД MySql через PDO.',
        'versions'  => '2.1.0-pl',
        'link'      => 'https://modstore.pro/packages/utilities/pdotools',
    )
    ,'MinifyX' => array(
        'pagetitle' => 'MinifyX',
        'checked'   => 1,
        'desc'      => 'Автоматизированное сжатие скриптов и стилей сайта.',
        'versions'  => '1.4.2-pl',
        'link'      => 'https://modstore.pro/packages/utilities/minifyx',
    )
    ,'translit' => array(
        'pagetitle' => 'translit',
        'checked'   => 1,
        'desc'      => 'генерации дружественных url',
        'versions'  => '1.0.0-beta',
        'analog'    => 'yTranslit',
        'link'      => 'http://modx.com/extras/package/translit',
    )
    ,'yTranslit' => array(
        'pagetitle' => 'yTranslit',
        'checked'   => 0,
        'desc'      => 'генерации дружественных url через api переводчика Яндекс.',
        'versions'  => '1.1.2-pl',
        'form'      => '',
        'analog'    => 'translit',
        'link'      => 'https://modstore.pro/packages/content/ytranslit',
    )
    ,'Ace' => array(
        'pagetitle' => 'Ace',
        'checked'   => 1,
        'desc'      => 'Лучший редактор кода с подсветкой',
        'versions'  => '1.6.5-pl',
        'analog'    => 'CodeMirror',
        'link'      => 'https://modstore.pro/packages/content/ace',
    )
    ,'CodeMirror' => array(
        'pagetitle' => 'CodeMirror',
        'checked'   => 0,
        'desc'      => 'Редактор кода с подсветкой',
        'versions'  => '1.6.5-pl',
        'analog'    => 'Ace',
        'link'      => 'http://modx.com/extras/package/codemirror',
    )
    ,'CKEditor' => array(
        'pagetitle' => 'CKEditor',
        'checked'   => 1,
        'desc'      => 'Редактор текста в документах',
        'versions'  => '',
        'analog'    => 'TinyMCE',
        'link'      => 'http://modx.com/extras/package/ckeditor',
    )
    ,'TinyMCE' => array(
        'pagetitle' => 'TinyMCE',
        'checked'   => 0,
        'desc'      => 'Редактор текста в документах',
        'versions'  => '',
        'analog'    => 'CKEditor',
        'link'      => 'http://modx.com/extras/package/tinymce',
    )
    ,'modAccessManager' => array(
        'pagetitle' => 'modAccessManager',
        'checked'   => 0,
        'desc'      => 'Ограничение доступа для менеджера сайта',
        'versions'  => '',
        'link'      => 'https://modstore.pro/packages/users/modaccessmanager',
    )
    ,'ClientConfig' => array(
        'pagetitle' => 'ClientConfig',
        'checked'   => 1,
        'desc'      => 'клиентские настройки',
        'versions'  => '1.4.0-pl',
        'link'      => 'http://modx.com/extras/package/clientconfig',
    )
    ,'miniShop2' => array(
        'pagetitle' => 'miniShop2',
        'checked'   => 0,
        'desc'      => 'компонент интернет-магазина',
        'versions'  => '2.2.0-pl2',
        'link'      => 'https://modstore.pro/packages/ecommerce/minishop2',
    )
    ,'mspReceiptAccount' => array(
        'pagetitle' => 'mspReceiptAccount',
        'checked'   => 0,
        'desc'      => 'Квитанция и счет на оплату для интернет-магазина minishop',
        'versions'  => '',
        'link'      => 'https://modstore.pro/packages/payment-system/mspreceiptaccount',
    )
);


return $packages_in;