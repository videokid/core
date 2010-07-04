<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */


class SecurityCenter_Controller_Adminform extends Zikula_Controller
{
    /**
     * Generic delete function for object model
     */
    public function delete()
    {
        // Security check
        if (!SecurityUtil::checkPermission('SecurityCenter::', '::', ACCESS_DELETE)) {
            return LogUtil::registerPermissionError();
        }

        // verify auth-key
        if (!SecurityUtil::confirmAuthKey('SecurityCenter')) {
            return LogUtil::registerAuthidError();
        }

        // get paramters
        $ot = FormUtil::getPassedValue('ot', 'log_event', 'GETPOST');
        $id = (int)FormUtil::getPassedValue('id', 0, 'GETPOST');

        // sanity checkc
        if (!is_numeric($id)) {
            return LogUtil::registerError($this->__f("Error! Received a non-numeric object ID '%s'.", $id));
        }

        $class = 'SecurityCenter_DBObject_'.StringUtil::camelize($ot);
        $object = new $class();
        $data = $object->get($id);

        // check for valid object
        if (!$data) {
            return LogUtil::registerError($this->__f('Error! Invalid %s received.', "object ID [$id]"));
        } else {
            // delete object
            $object->delete();
        }

        // redirect back to view function
        return System::redirect(ModUtil::url('SecurityCenter', 'admin', 'viewobj', array('ot' => $ot)));
    }
}