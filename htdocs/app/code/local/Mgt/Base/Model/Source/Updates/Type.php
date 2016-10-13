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
 * @package     Mgt_Base
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2012 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mgt_Base_Model_Source_Updates_Type extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const TYPE_NEW_RELEASE   = 'NEW_RELEASE';
    const TYPE_MODULE_UPDATE = 'MODULE_UPDATE';
    const TYPE_INFO          = 'INFO';

    public function toOptionArray()
    {
        return array(
            array('value' => self::TYPE_NEW_RELEASE,   'label' => Mage::helper('core')->__('New Releases')),
            array('value' => self::TYPE_MODULE_UPDATE, 'label' => Mage::helper('core')->__('My Modules Updates')),
            array('value' => self::TYPE_INFO,          'label' => Mage::helper('core')->__('Other Information')),
        );
    }

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
