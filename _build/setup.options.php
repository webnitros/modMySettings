<?php

$module = '';
$output = null;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $exists = $modx->getObject('transport.modTransportPackage', array('package_name' => 'pdoTools'));

        if (!empty($options['attributes']['resources'])) {
            $resources_in = $options['attributes']['resources'];

            $resources = array();
            foreach ($resources_in as $key => $val) {
                $resources[$key] = $val;
            }

            $container = array(
                'system' => array(
                    'name' => 'Служебные страницы'
                    ,'page' => 'system,service,sitemap,robots,error404,error403,error503,search'
                )
                , 'additional' => array(
                    'name' => 'Дополнительные страницы'
                    , 'page' => 'about,contacts'
                )
                , 'cabinet' => array(
                    'name' => 'Личный кабинет'
                    , 'page' => 'auth,cabinet,profile,orders'
                )
                , 'minishop' => array(
                    'name' => 'Интернет-магазин'
                    , 'page' => 'catalog,cart'
                )
            );
            $resource = '<ul id="formCheckboxes" class="formCheckedInpit"  style="height:250px;overflow:auto;">';

            foreach ($container as $key => $cont) {
                $children = '';
                $resource .= '<li><h3>' . $cont['name'] . '</h3></li>';

                $resource_chill = explode(',', $cont['page']);
                foreach ($resource_chill as $k) {
                    $v = $resources[$k];

                    $checked = !empty($v['checked']) ? 'checked' : '';
                    $blocked = !empty($v['blocked']) ? 'onclick=\'window.event.returnValue=false\'' : '';
                    $desc = !empty($v['desc']) ? ' - <small style="font-weight: normal">' . $v['desc'] . '</small>' : '';


                    $text = !empty($blocked) ? '(обязателен)' : '';
                    $children .= '
                        <li>
                            <label>
                                <input '.$blocked.' type="checkbox" name="install_resources[' . $k . ']" value="' . $k . '"' . $checked . '> ' . $v['pagetitle'] .$text. $desc . '
                            </label>
                        </li>';
                }

                $resource .= $children;
            }
            $resource .= '</ul>';


        }

        /* packages */
        if (!empty($options['attributes']['packages'])) {
            $packages_in = $options['attributes']['packages'];

            /* package install*/
            $packages = array();
            foreach ($packages_in as $key => $val) {
                $packages[$key] = $val;
            }

            $package_container = array(
                'system' => array(
                     'name' => 'Утилиты'
                    ,'page' => 'pdoTools,MinifyX,translit,yTranslit,ClientConfig'
                ),
                'edit' => array(
                     'name' => 'Редакторы'
                    ,'page' => 'Ace,CodeMirror,CKEditor,TinyMCE'
                ),
                'ie' => array(
                     'name' => 'Коммерция'
                    ,'page' => 'miniShop2,mspReceiptAccount'
                )
            );
            $package_install = '<ul id="formCheckboxesPackage" class="formCheckedInpit" style="height:250px;overflow:auto;">';
            foreach ($package_container as $key => $cont) {
                $children  = '';
                $package_install .= '<li><h3>'.$cont['name'].'</h3></li>';

                $package_chill = explode(',', $cont['page']);
                foreach ($package_chill as $k) {
                    $v = $packages[$k];

                    $checked = !empty($v['checked']) ? 'checked' : '';
                    $desc = !empty($v['desc']) ? '<br> <em style="font-weight: normal">'.$v['desc'].'</em>' : '';
                    $analog = !empty($v['analog']) ? 'onchange="Ext.get(\'formCheckboxesPackage\').select(\'input#package_'.$v['analog'].'\').each(function(v) {v.dom.checked = false;});"' : '';


                    $link = !empty($v['link']) ? ' <a target="_blank" href="'.$v['link'].'"><span class="icon-link icon"></span></a>' : '';

                    $children .= '
                        <li>
                            <label for="package_' . $k . '">
                                <input '.$analog.' type="checkbox" id="package_' . $k . '" name="install_packages[' . $k . ']" value="' . $k . '"' . $checked . '> ' . $v['pagetitle'] . $link . $desc . '
                            </label>
                        </li>';
                }

                $package_install .= $children;
            }
            $package_install .= '</ul>';
        }


        if (!empty($options['attributes']['settings'])) {
            $settings_in = $options['attributes']['settings'];

            /* Получаем настройки и названиями */
            $objectsData = array();
            $key_in = array_keys($settings_in);

            $q = $modx->newQuery('modSystemSetting');
            $q->select('key,xtype,area,namespace');
            $q->where(array('key:IN' => $key_in));
            if ($q->prepare() && $q->stmt->execute()){
                $objectsData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
                if(is_array($objectsData) && count($objectsData)>0){
                    foreach($objectsData as $objectData){
                        $namespaces[$objectData['namespace']] = $objectData['namespace'];
                    }
                }
            }


            $rows = array();
            foreach ($namespaces as $key) {
                $modx->lexicon->load($key.':setting');
                $rows[$key] = array(
                    'name' => $modx->lexicon('area_'.$key),
                    'settings' => array()
                );
            }

            foreach($objectsData as $objectD){
                $data = $objectD;
                $data['name'] = $modx->lexicon('setting_'.$objectD['key']);
                $data['desc'] = $modx->lexicon('setting_'.$objectD['key'].'_desc');
                $rows[$data['namespace']]['settings'][$data['key']] = array(
                    'xtype' => $data['xtype'],
                    'name' => $data['name'],
                    'desc' => $data['desc']
                );
            }


            /* settings install*/
            $setting_install = '<ul id="formCheckboxesSettings" class="formCheckedInpit" style="height:250px;overflow:auto;">';
            foreach ($rows as $key => $cont) {
                $children  = '';
                $setting_install .= '<li><h3>'.$cont['name'].'</h3></li>';


                foreach ($cont['settings'] as $k => $v) {
                    $value = $settings_in[$k];

                    $name = $v['name'];
                    $desc = !empty($v['desc']) ? '<small class="smallms">'.$v['desc'].'</small>' : '';
                    $xtype = $v['xtype'];
                    if($xtype == 'combo-boolean'){

                        $checked = !empty($value) ? 'checked' : '';
                        $format = '
                            <label for="package_' . $k . '">
                                <input type="checkbox" id="setting_' . $k . '" name="install_settings[' . $k . ']" value="1"' . $checked . '>
                            </label>
                        ';

                    } else {

                        $format = '<input type="text" id="setting_' . $k . '" name="install_settings[' . $k . ']" value="' . $value . '"> ';

                    }

                    $children .= '
                    <li>
                        <table id="settings_sgs_'.$k.'" class="x-grid3-row-collapsed">
                            <tr>
                                <td class="x-grid3-col x-grid3-cell x-grid3-td-expander x-selectable x-grid3-cell-first " style="width: 18px;" tabindex="0" rowspan="2">
                                    <div class="x-grid3-col-expander">
                                        <div id="sgs_'.$k.'" class="x-grid3-row-expander" onclick="thisPlus(this)">&nbsp;</div>
                                    </div>
                                </td>
                                <td class="td_first">
                                '.$name.'<br>
                                <span class="msettings-hidden" id="desc_sgs_'.$k.'">'.$desc.'</span>
                                <em>'.$k.'</em>
                                </td>
                                <td class="td_last">'.$format.'</td>
                            </tr>
                        </table>

                    </li>';
                }

                $setting_install .= $children;
            }



            $setting_install .= '</ul>';
        }

        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

$output = '';

    // check pdoTools
    if (!$exists) {
        switch ($modx->getOption('manager_language')) {
            case 'ru':
                $output = 'Этот компонент требует <b>pdoTools</b>. Он будет автоматически скачан и установлен.';
                break;
            default:
                $output = 'This component requires <b>pdoTools</b>. It will be automaticly downloaded and installed?';
        }
        $output .= '<br/>';
    }

    if ($resource) {

        switch ($modx->getOption('manager_language')) {
            case 'ru':
                $output .= 'Выберите страницы, которые необходимо <b>добавить</b>:<br/>
                    <small>
                        <a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = true;});">отметить все</a> |
                        <a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = false;});">cнять отметки</a>
                    </small>
                ';
                break;
            default:
                $output .= 'Select modules, which need to <b>build</b>:<br/>
                    <small>
                        <a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = true;});">select all</a> |
                        <a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = false;});">deselect all</a>
                    </small>
                ';
        }

        $output .= '<br/>'.$resource;
    }

    if ($package_install) {
       $output_install = '';
        /* switch ($modx->getOption('manager_language')) {
            case 'ru':
                $output_install .= 'Выберите приложение, которые необходимо <b>установить</b>:<br/>
                    <small>
                        <a href="#" onclick="Ext.get(\'formCheckboxesPackage\').select(\'input\').each(function(v) {v.dom.checked = true;});">отметить все</a> |
                        <a href="#" onclick="Ext.get(\'formCheckboxesPackage\').select(\'input\').each(function(v) {v.dom.checked = false;});">cнять отметки</a>
                    </small>
                ';
                break;
            default:
                $output_install .= 'Select package, which need to <b>build</b>:<br/>
                    <small>
                        <a href="#" onclick="Ext.get(\'formCheckboxesPackage\').select(\'input\').each(function(v) {v.dom.checked = true;});">select all</a> |
                        <a href="#" onclick="Ext.get(\'formCheckboxesPackage\').select(\'input\').each(function(v) {v.dom.checked = false;});">deselect all</a>
                    </small>
                ';
        }*/

        $output_install .= $package_install;
    }

   /* $output .= '<table cellspacing="5" id="setup_form">
			<tr>
				<td><label for="email">Email:</label></td>
				<td><input type="email" name="emailsender" value="" placeholder="user@gmail.com" id="email" /></td>
			</tr>
			<tr><td colspan="2"><small>'.$email_intro.'</small></td></tr>
		</table>
		';*/

$out = '
    <script>
	    '.$options['attributes']['js'].'
    </script>

    <style>
		#setup_form_wrapper {font: normal 12px Arial;line-height:18px;}
		#setup_form_wrapper a {color: #08C;}
		#setup_form_wrapper input#email {height: 25px; width: 200px;}
		#setup_form_wrapper input#key {height: 25px; width: 300px;}
		#setup_form_wrapper label {margin-bottom:5px;}
		#setup_form_wrapper table {margin-top:10px;}
		#setup_form_wrapper .x-grid3-cell-first {vertical-align: top;}
		#setup_form_wrapper .x-grid3-row-expander {margin-top: 0px;}
		#setup_form_wrapper .td_first {width:350px; min-width:350px; padding-rigth: 25px;}
		#setup_form_wrapper .td_center {width: 200px; padding: 0 15px; vertical-align: top;}
		#setup_form_wrapper .td_last {width: 150px; padding-right: 15px; vertical-align: top;}
		#setup_form_wrapper .msettings-hidden {display: none;}
		#setup_form_wrapper form {padding:0px;}
		#setup_form_wrapper small {font-size: 10px; color:#555; font-style:italic;}
		#setup_form_wrapper .more_info {width: 100%;}
		#setup_form_wrapper .more_info a {line-height: 21px; display:inline-block;}
		#setup_form_wrapper .more_info img {border: none; display:inline-block;padding-top:10px;}
		#setup_form_wrapper .taberney{padding: 5px 0px 0px 15px;}
		#setup_form_wrapper .formCheckedInpit{padding-left: 5px;}
		#setup_form_wrapper .smallms{ line-height: 10px;}
		#package-show-setupoptions-btn,#package-show-setupoptions-btn {width: auto !important;}
	</style>

	<div id="setup_form_wrapper">
<div id="modx-mysettings-beforeinstall" class="x-tab-panel vertical-tabs-panel wrapped x-tab-panel-noborder" style="width: auto;">
    <div class="x-tab-panel-header vertical-tabs-header x-tab-panel-header-noborder x-unselectable x-tab-panel-header-plain">
        <div class="x-tab-strip-wrap" style="width: 268px;">
            <ul class="x-tab-strip x-tab-strip-top" id="tab-expansions">
                <li class="x-tab-strip-active">
                    <span onclick="thisTab(this)"  id="ms-page-tab" class="x-tab-strip-text">Страницы</span></a>
                </li>
                <li>
                    <span onclick="thisTab(this)" id="ms-pack-tab" class="x-tab-strip-text ">Приложения</span>
                </li>
                <li>
                    <span onclick="thisTab(this)"  id="ms-settings-tab" class="x-tab-strip-text ">Настройки</span>
                </li>
            </ul>
        </div>
        <div class="x-tab-strip-spacer" id="ext-gen174"></div>
    </div>
    <div class="x-tab-panel-bwrap vertical-tabs-bwrap" id="tab-caontent">
        <div class="x-tab-panel-body x-tab-panel-body-noborder x-tab-panel-body-top" id="ext-gen172" style="overflow: auto; width: auto; height: auto;">

            <div id="con-ms-page-tab" class="taber-panel taber-panel-action x-panel x-panel-noborder" style="width: auto;">
                <div class="x-panel-bwrap">
                    <div class="taberney x-panel-body x-panel-body-noheader x-panel-body-noborder" id="ext-gen246" style="visibility: visible; position: relative; overflow: auto; left: auto; top: auto; z-index: auto; width: auto; height: auto;">
                            '.$output.'
                    </div>
                </div>
            </div>

            <div id="con-ms-pack-tab" class="taber-panel x-panel x-panel-noborder x-hide-display" style="width: auto;">
                <div class="x-panel-bwrap">
                    <div class="taberney x-panel-body x-panel-body-noheader x-panel-body-noborder" id="ext-gen246" style="visibility: visible; position: relative; overflow: auto; left: auto; top: auto; z-index: auto; width: auto; height: auto;">
                         '.$package_install.'
                    </div>
                </div>
            </div>
            <div id="con-ms-settings-tab" class="taber-panel x-panel x-panel-noborder x-hide-display" style="width: auto;">
                <div class="x-panel-bwrap">
                    <div class="taberney x-panel-body x-panel-body-noheader x-panel-body-noborder" id="ext-gen246" style="visibility: visible; position: relative; overflow: auto; left: auto; top: auto; z-index: auto; width: auto; height: auto;">
                      '.$setting_install.'
                    </div>
                </div>
            </div>
            <div id="con-ms-templates-tab" class="taber-panel x-panel x-panel-noborder x-hide-display" style="width: auto;">
                <div class="x-panel-bwrap">
                    <div class="taberney x-panel-body x-panel-body-noheader x-panel-body-noborder" id="ext-gen246" style="visibility: visible; position: relative; overflow: auto; left: auto; top: auto; z-index: auto; width: auto; height: auto;">
                      '.$setting_install.'
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

	</div>
	';

return $out;