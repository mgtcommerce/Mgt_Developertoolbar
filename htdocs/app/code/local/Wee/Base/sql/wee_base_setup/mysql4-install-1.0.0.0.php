<?php

$this->startSetup();

Mage::getModel('core/config_data')->setScope('default')->setPath('wee_base/feed/installed')->setValue(time())->save(); 

$this->endSetup();