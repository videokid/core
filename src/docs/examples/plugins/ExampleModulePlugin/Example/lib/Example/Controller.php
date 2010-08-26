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

/**
 * Controller class.
 */
class ModulePlugin_SysInfo_Example_Controller extends Zikula_Plugin_Controller
{
    /**
     * Configuration screen.
     *
     * @return string Plugin configuration output.
     */
    public function configure()
    {
        return $this->view->fetch('configure.tpl');
    }
}
