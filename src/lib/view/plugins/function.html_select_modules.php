<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula_View
 * @subpackage Template_Plugins
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Smarty function to display a list box with a list of active modules.
 *
 * Either user or admin capable or all modules.
 *
 * Available parameters:
 *   - name:     Name for the control (optional) if not present then only the option tags are output
 *   - id:       ID for the control
 *   - selected: Selected value
 *   - type:     Type of modules to show (all = All modules, user = user capable modules, admin = admin capable modules)
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out
 *
 * Example
 *
 *     {html_select_modules name=mod selected=$mymod}
 *
 *     <select name="mod">
 *         <option value="">&bsp;</option>
 *         {html_select_modules selected=$mythemechoice}
 *     </select>
 *
 * @param array  $params  All attributes passed to this function from the template.
 * @param Smarty &$smarty Reference to the Smarty object.
 *
 * @see    function.html_select_modules.php::smarty_function_html_select_modules()
 * @return string A drop down containing a list of modules.
 */
function smarty_function_html_select_modules($params, &$smarty)
{
    // we'll make use of the html_options plugin to simplfiy this plugin
    require_once $smarty->_get_plugin_filepath('function','html_options');

    $supportedtypes = array('all', 'user', 'admin', 'profile', 'message');

    // set some defaults
    if (!isset($params['type']) || array_search($params['type'], $supportedtypes) === false) {
        $params['type'] = 'all';
    }

    // get the modules
    switch ($params['type']) {
        case 'all' :
            $modules = ModUtil::getAllMods();
            break;
        case 'admin' :
            $modules = ModUtil::getAdminMods();
            break;
        case 'user' :
            $modules = ModUtil::getUserMods();
            break;
        case 'profile' :
            $modules = ModUtil::getProfileMods();
            break;
        case 'message' :
            $modules = ModUtil::getMessageMods();
            break;
    }

    // process our list of modules for input to the html_options plugin
    $moduleslist = array();
    $installerArray = array('Blocks', 'Errors', 'Permissions', 'Categories', 'Groups', 'Theme', 'Users', 'Search');
    if (!empty($modules)) {
        foreach ($modules as $module) {
            if (!(System::isInstalling() && in_array($module['name'], $installerArray))) {
                $moduleslist[$module['name']] = $module['displayname'];
            }
        }
    }
    natcasesort($moduleslist);

    // get the formatted list
    $output = smarty_function_html_options(array('options'   => $moduleslist,
                                                 'selected'  => isset($params['selected']) ? $params['selected'] : null,
                                                 'name'      => isset($params['name'])     ? $params['name']     : null,
                                                 'id'        => isset($params['id'])       ? $params['id']       : null),
                                                 $smarty);
    if (isset($params['assign']) && !empty($params['assign'])) {
        $smarty->assign($params['assign'], $output);
    } else {
        return $output;
    }
}