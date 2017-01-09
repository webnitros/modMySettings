<?php
/**
 * Resolve creating needed statuses
 *
 * @var xPDOObject $object
 * @var array $options
 */


function full_copy($source, $target) {
    if (is_dir($source))  {
        @mkdir($target);
        $d = dir($source);
        while (FALSE !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') continue;
            full_copy("$source/$entry", "$target/$entry");
        }
        $d->close();
    }
    else copy($source, $target);
}


if ($object->xpdo) {
	/* @var modX $modx */
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

            /* @var modCategory $category */
            // add new resource group resource system
            if(!$category = $modx->getObject('modCategory', array('category' => '- Сайт'))) {

                $category= $modx->newObject('modCategory');
                $category->set('category', '- Сайт');
                $category->save();

            }
            $category_id = $category->get('id');

            /* @var modCategory $category */
            // add new resource group resource system
            if(!$category = $modx->getObject('modCategory', array('category' => 'Основное'))) {

                $category= $modx->newObject('modCategory');
                $category->set('category', 'Основное');
                $category->set('parent', $category_id);
                $category->save();

            }
            $category_main_id = $category->get('id');


            /* set settings global */
            $settings = array();
            foreach ($options['settings'] as $key => $val) {
                $value = $val;
                if(isset($options['install_settings'][$key])){
                    $value = $options['install_settings'][$key];
                }
                $settings[$key] = $value;
            }

            foreach ($settings as $k => $v) {

                if ($opt = $modx->getObject('modSystemSetting', array('key' => $k))){
                    $opt->set('value', $v);
                    $opt->save();
                } else {
                    $newOpt = $modx->newObject('modSystemSetting');
                    $newOpt->set('key', $k);
                    $newOpt->set('value', $v);
                    $newOpt->save();
                }
            }


            /* Update template category */
            $parents_in = $templates_in = array();
            foreach ($options['resources'] as $key => $val) {
                if(!empty($val['parent_uri']))
                $parents_in[] = $val['parent_uri'];

                if(!empty($val['template_name']))
                $templates_in[] = $val['template_name'];
            }
            $parents_in = array_unique($parents_in);
            $templates_in = array_unique($templates_in);

            // getList modTemplate
            $q = $modx->newQuery('modTemplate');
            $q->select($modx->getSelectColumns('modTemplate', 'modTemplate', ''));
            $q->where(array('templatename:IN' => $templates_in));
            if ($q->prepare() && $q->stmt->execute()){
                $templatesData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
                if(is_array($templatesData) && count($templatesData)>0){
                    foreach($templatesData as $templateData){
                        $templates_ins[$templateData['templatename']] = $templateData['id'];
                    }
                }
            }

            // set main template
            $index_main = $modx->getOption('site_start');
            if($template = $modx->getObject('modTemplate', array('templatename' => 'main'))){
                if($resource = $modx->getObject('modResource', $index_main)){
                    $resource->set('template', $template->get('id'));
                    $resource->save();
                }
            }

            // getList object
            $q = $modx->newQuery('modResource');
            $q->select($modx->getSelectColumns('modResource', 'modResource', ''));
            $q->where(array('uri:IN' => $parents_in));
            if ($q->prepare() && $q->stmt->execute()){
                $objectsData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
                if(is_array($objectsData) && count($objectsData)>0){
                    foreach($objectsData as $objectData){
                        $parents_ins[$objectData['uri']] = $objectData['id'];
                    }
                }
            }

            // unset system
            array_shift($options['install_resources']);
            $resources_install = $options['install_resources'];
            $resources = $options['resources'];
            foreach ($resources_install as $ko => $key) {
                if(!isset($resources[$key])) continue;

                $page = $resources[$key];
                $uri = isset($page['uri']) ? $page['uri'] : '';

                // set template and parent
                if($resource = $modx->getObject('modResource', array('uri' => $uri))){

                    // parent
                    if(isset($page['parent'])){
                        $parents_id = $page['parent'];
                    }

                    // parent_uri
                    if(isset($page['parent_uri'])){
                        if(isset($parents_ins[$page['parent_uri']])) {
                            $parents_id = $parents_ins[$page['parent_uri']];
                        }
                    }

                    // template
                    if(isset($page['template_name'])){
                        if(isset($templates_ins[$page['template_name']])){
                            $resource->set('template', $templates_ins[$page['template_name']]);
                        }
                    }

                    // parent
                    $resource->set('parent', $parents_id);
                    $resource->save();
                }
            }


            /* Update modSetting page */
            $modSetting = array(
                'error404.html' => 'error_page',
                'error403.html' => 'unauthorized_page',
                'error503.html' => 'site_unavailable_page',
            );
            foreach ($modSetting as $uri => $k) {
                if(!$page = $modx->getObject('modResource', array('uri' => $uri))){
                    continue;
                }
                $v = $page->get('id');
                if ($opt = $modx->getObject('modSystemSetting', array('key' => $k))){
                    $opt->set('value', $v);
                    $opt->save();
                }
            }


        break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;