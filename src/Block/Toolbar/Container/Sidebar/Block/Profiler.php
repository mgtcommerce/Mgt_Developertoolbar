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
namespace Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

use Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

class Profiler extends Block
{
    /**
     * @var String
     */
    protected $label = 'Profiler';
    
    /**
     * @var Array
     */
    protected $timers = [];
    
    /**
     * @var Array
     */
    protected $sortedTimers = [];

    public function setTimers(array $timers)
    {
        $this->timers = $timers;
    }
    
    public function getTimers()
    {
        return $this->timers;
    }
    
    public function sortTimers(array $timers)
    {
        $uid = 0;
        foreach ($timers as $timer) {
            $realTimerId = explode('->', $timer['id']);
            $timerId = array_pop($realTimerId);
            $timer['uid'] = $uid;
            $timer['label'] = $timerId;
            if (count($realTimerId)) {
                $parentTimerId = implode('->', $realTimerId);
                $timer['parent'] = $this->sortedTimers[$parentTimerId]['uid'];
            }
            if ($timer['id'] == 'magento') {
                $timer['percentage'] = 100;
            } else {
                if (isset($this->sortedTimers['magento'])) {
                    $timer['percentage'] = round((($timer['sum'] / $this->sortedTimers['magento']['sum']) * 100),2);
                }
            }
            $this->sortedTimers[$timer['id']] = $timer;
            $uid++;
        }
        return $this->sortedTimers;
    }
    
    public function getSortedTimers()
    {
        return $this->sortedTimers;
    }
}