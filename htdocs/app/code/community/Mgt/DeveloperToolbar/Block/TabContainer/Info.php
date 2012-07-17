<?php
/**
 * MGT-Commerce GmbH
 * http://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2012 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mgt_DeveloperToolbar_Block_TabContainer_Info extends Mgt_DeveloperToolbar_Block_TabContainer
{
    public function __construct($name) 
    {
        parent::__construct($name);
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_Request('request', 'Request'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_General('general', 'General'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_Handles('handles', 'Handles'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_Events('events', 'Events/Observer'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_Blocks('blocks', 'Blocks'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_Config('config', 'Config'));
        $this->addTab(new Mgt_DeveloperToolbar_Block_Tab_PhpInfo('phpinfo', 'PHP-Info'));
    }
}