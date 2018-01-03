<?php
/**
 * MGT-Commerce GmbH
 * https://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2016 (https://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mgt\DeveloperToolbar\Block\Toolbar\Block;

class MemoryConsumption extends Base
{
    /**
     * @var Integer
     */
    protected $memoryConsumption;
    
    /**
     * @var Integer
     */
    protected $phpMemoryLimit;
    
    
    public function setMemoryConsumption($memoryConsumption)
    {
        $this->memoryConsumption = $memoryConsumption;
    }
    
    public function getMemoryConsumption()
    {
        if (!$this->memoryConsumption) {
            $this->memoryConsumption =  self::getMemoryUsage(true);
        }
        return $this->memoryConsumption;
    }
    
    static protected function getMemoryUsage($real)
    {
        return memory_get_usage($real);
    }
    
    public function setPhpMemoryLimit($phpMemoryLimit)
    {
        $this->phpMemoryLimit = $phpMemoryLimit;
    }
    
    public function getPhpMemoryLimit()
    {
        if (!$this->phpMemoryLimit) {
            $convertToBytes = function($value) {
                $value = trim($value);
                $last = strtolower($value[strlen($value)-1]);
                $value = (int)$value;
                switch($last) {
                    case 'g':
                        $value *= 1024;
                    case 'm':
                        $value *= 1024;
                    case 'k':
                        $value *= 1024;
                }
            
                return $value;
            };
            $this->phpMemoryLimit = $convertToBytes(ini_get('memory_limit'));
        }
        return $this->phpMemoryLimit;
    }
}
