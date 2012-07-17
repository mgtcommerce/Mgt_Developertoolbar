<?php

class Wee_Base_Model_Source_Updates_Type extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
