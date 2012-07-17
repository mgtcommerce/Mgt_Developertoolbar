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

class Mgt_DeveloperToolbar_Model_Resource extends Mage_Core_Model_Resource 
{
    public function getConnection($name)
    {
        if (isset($this->_connections[$name])) {
            return $this->_connections[$name];
        }
        $connConfig = Mage::getConfig()->getResourceConnectionConfig($name);
        if (!$connConfig) {
            $this->_connections[$name] = $this->_getDefaultConnection($name);
            return $this->_connections[$name];
        }
        if (!$connConfig->is('active', 1)) {
            return false;
        }
        $origName = $connConfig->getParent()->getName();

        if (isset($this->_connections[$origName])) {
            $this->_connections[$name] = $this->_connections[$origName];
            return $this->_connections[$origName];
        }

        $typeInstance = $this->getConnectionTypeInstance((string)$connConfig->type);
        $conn = $typeInstance->getConnection($connConfig);
        $conn->getProfiler()->setEnabled(true);
        if (method_exists($conn, 'setCacheAdapter')) {
            $conn->setCacheAdapter(Mage::app()->getCache());
        }

        $this->_connections[$name] = $conn;
        if ($origName!==$name) {
            $this->_connections[$origName] = $conn;
        }
        return $conn;
    } 	
}