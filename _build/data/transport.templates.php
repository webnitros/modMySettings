<?php

$chunks = array();

$tmp = array(
     'service'  => 'service'
    ,'page'     => 'page'
    ,'main'     => 'main'
);

// Save chunks for setup options
$BUILD_TEMPLATES = array();

foreach ($tmp as $k => $v) {
    /* @avr modChunk $chunk */
    $chunk = $modx->newObject('modTemplate');
    $chunk->fromArray(array(
        'id' => 0,
        'templatename' => $k,
        'description' => '',
        'content' => file_get_contents($sources['source_core'].'/elements/templates/template.'.$v.'.tpl'),
        'static' => BUILD_CHUNK_STATIC,
        'source' => 1,
        'static_file' => 'core/components/'.PKG_NAME_LOWER.'/elements/templates/template.'.$v.'.tpl',
    ),'',true,true);
    $templates[] = $chunk;

    $BUILD_TEMPLATES[$k] = file_get_contents($sources['source_core'].'/elements/templates/template.'.$v.'.tpl');
}

ksort($BUILD_TEMPLATES);
return $templates;