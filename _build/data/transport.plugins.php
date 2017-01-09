<?php

$plugins = array();

$tmp = array(
	'modMySettings' => array(
		'file' => 'modmysettings'
		,'description' => ''
		,'events' => array(
			'OnCacheUpdate',
		)
	)
);

foreach ($tmp as $k => $v) {
	/* @avr modplugin $plugin */
	$plugin = $modx->newObject('modPlugin');
	$plugin->fromArray(array(
		'id' => 0
		,'name' => $k
		,'category' => 0
		,'description' => @$v['description']
		,'plugincode' => getSnippetContent(MODX_BASE_PATH.'modMySettings/core/components/modmysettings/elements/plugins/plugin.'.$v['file'].'.php')
		,'static' => BUILD_PLUGIN_STATIC
		,'source' => 1
		,'static_file' => 'core/components/'.PKG_NAME_LOWER.'/elements/plugins/plugin.'.$v['file'].'.php'
	),'',true,true);

	$events = array();
	if (!empty($v['events'])) {
		foreach ($v['events'] as $k2 => $v2) {
			/* @var modPluginEvent $event */
			$event = $modx->newObject('modPluginEvent');
			$event->fromArray(array(
				'event' => $v2,
				'priority' => 0,
				'propertyset' => 0,
			),'',true,true);
			$events[] = $event;
		}
		unset($v['events']);
	}

	if (!empty($events)) {
		$plugin->addMany($events);
	}

	$plugins[] = $plugin;
}

unset($tmp, $properties);
return $plugins;