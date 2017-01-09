<?php

$settings = array(
     'emailsender' => $modx->getOption('emailsender','' , '')
    ,'publish_default' => 1
    ,'upload_maxsize' => '10485760'
    ,'locale' => 'ru_RU.utf-8'
    ,'auto_check_pkg_updates' => 0
    ,'feed_modx_news_enabled' => 0
    ,'feed_modx_security_enabled' => 0

    //url
    , 'automatic_alias' => 1
    , 'use_alias_path' => 1
    , 'friendly_urls' => 1
    , 'global_duplicate_uri_check' => 1
    , 'link_tag_scheme' => 'full'

    , 'tiny.base_url' => '/'
    , 'tiny.path_options' => 'rootrelative'
    , 'friendly_alias_translit' => 'russian'

    // auth
    , 'password_generated_length' => 6
    , 'password_min_length' => 6
    , 'signupemail_message' => '<p>Здравствуйте [[+uid]],</p><p>Ваши данные для административного входа на [[+sname]]:</p>
                <p><strong>Логин:</strong> [[+uid]]<br /><strong>Пароль:</strong> [[+pwd]]<br /></p>
                <p>После того как вы войдете в административную часть MODX [[+surl]], вы можете изменить свой пароль.</p>
                <p>С уважением, <br />Администрация сайта</p>'

);
return $settings;
