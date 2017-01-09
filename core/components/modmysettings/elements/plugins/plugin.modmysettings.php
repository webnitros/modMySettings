<?php
switch ($modx->event->name) {

    case 'OnCacheUpdate':
        if ($modx->context->key == 'mgr') {

            $modUserGroup = $modx->getObject('modUserGroup', array('name' => 'Manager'));
            $group_id = $modUserGroup->get('id');

            $modAccessPolicy = $modx->getObject('modAccessPolicy', array('name' => 'Manager'));
            $policy_id = $modAccessPolicy->get('id');

            $modAccessPolicyContext = $modx->getObject('modAccessPolicy', array('name' => 'Context'));
            $policy_context_id = $modAccessPolicyContext->get('id');


            $c = $modx->newQuery('modAccessContext');
            $c->where(array('principal' => $group_id, 'policy:!=' => $policy_id));
            if ($objectList = $modx->getCollection('modAccessContext', $c)) {
                foreach ($objectList as $object) {
                    $policy = $object->get('policy');
                    if ($policy_context_id == $policy) continue;
                    $object->remove();
                }
            }


            /* search policy access */
            $data = array();
            $c = $modx->newQuery('modAccessPolicy');
            $c->where(array('lexicon:!=' => 'permissions'));
            if ($objectList = $modx->getCollection('modAccessPolicy', $c)) {
                foreach ($objectList as $object) {
                    $id = $object->get('id');
                    $data[] = array(
                        'target' => 'mgr',
                        'principal_class' => 'modUserGroup',
                        'principal' => $group_id,
                        'authority' => 9,
                        'policy' => $id,
                    );

                }
            }

            foreach ($data as $key => $row) {
                if (!$tmp = $modx->getObject('modAccessContext', $row)) {
                    $tmp = $modx->newObject('modAccessContext');
                    $tmp->fromArray($row);
                    $tmp->save();
                }
            }

        }

    break;

}
