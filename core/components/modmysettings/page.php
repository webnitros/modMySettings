<?php
/**
 * Created by PhpStorm.
 * User: burgen
 * Date: 09.01.2016
 * Time: 13:50
 */

// Resources
$resources_in = array(
    'system' => array(
        'checked'   => 1,
        'pagetitle' => 'system',
        'template' => 0,
        'published' => 0,
        'hidemenu' => 1,
        'cacheable' => 0,
        'alias' => 'system',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'content' =>'',
        'uri_override' => 1,
        'uri'  => 'system/',
    )
    ,'sitemap' => array('pagetitle' => 'sitemap',
        'checked'   => 1,
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'parent' => $parent_id,
        'alias' => 'sitemap'
        ,'content_type' => 2,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'sitemap.xml',
        'content' =>'[[!pdoSitemap? &checkPermissions=`list`]]'
    )
    ,'robots' => array('pagetitle' => 'robots',
        'checked'   => 1,
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'robots',
        'content_type' => 3,
        'parent' => $parent_id,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'robots.txt',
        'content' => file_get_contents(MODX_BASE_PATH.'modMySettings/core/components/modmysettings/elements/robot.txt')
    )
    ,'search' =>  array('pagetitle' => 'search',
        'checked'   => 0,
        'template' => $template_id,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'search',
        'content_type' => 1,
        'parent' => $parent_id,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'search.html',
        'content' => ''
    )
    ,'error404' =>  array('pagetitle' => 'Ошибка 404',
        'checked'   => 1,
        'template' => $template_id,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'error404',
        'content_type' => 1,
        'parent' => $parent_id,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error404.html',
        'content' => 'Страница не существует или вы не правильно ввели адрес'
    )
    ,'error403' =>  array('pagetitle' => 'Доступ запрещен',
        'checked'   => 1,
        'template' => $template_id,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'error403',
        'content_type' => 1,
        'parent' => $parent_id,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error403.html',
        'content' => 'Доступ к этой странице запрещен'
    )
    ,'error503' =>  array('pagetitle' => 'Сайт временно не доступен',
        'checked'   => 1,
        'template' => $template_id,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'error503',
        'content_type' => 1,
        'parent' => $parent_id,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error503.html',
        'content' => 'Сайт временно не доступен'
    )
);

