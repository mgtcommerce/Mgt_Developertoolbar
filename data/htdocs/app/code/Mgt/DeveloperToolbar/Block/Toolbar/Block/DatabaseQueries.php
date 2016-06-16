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

use Magento\Framework\App\ResourceConnection;
use Mgt\DeveloperToolbar\Block\Context;

class DatabaseQueries extends Base
{
    /**
     *  Resource Connection
     *
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resourceConnection;
    
    /**
     *  Profiler
     *
     * @var \Magento\Framework\DB\Profiler
     */
    protected $profiler;
    
    /**
     *
     * @var Double
     */
    protected $totalElapsedSecs;
    
    /**
     *
     * @var Integer
     */
    protected $totalNumQueries;
    
    /**
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function getProfiler()
    {
        if (!$this->profiler) {
            $resourceConnection = $this->getResourceConnection();
            $readConnection = $resourceConnection->getConnection('read');
            $this->profiler = $readConnection->getProfiler();
        }
        return $this->profiler;
    }

    public function getResourceConnection()
    {
        return $this->resourceConnection;
    }
    
    public function setTotalElapsedSecs($totalElapsedSecs)
    {
        $this->totalElapsedSecs = $totalElapsedSecs;
    }
    
    public function getTotalElapsedSecs()
    {
        if (!$this->totalElapsedSecs) {
            $profiler = $this->getProfiler();
            $this->totalElapsedSecs = $profiler->getTotalElapsedSecs();
        }
        return $this->totalElapsedSecs;
    }
    
    public function setTotalNumQueries($totalNumQueries)
    {
        $this->totalNumQueries = $totalNumQueries;
    }
    
    public function getTotalNumQueries()
    {
        if (!$this->totalNumQueries) {
            $profiler = $this->getProfiler();
            $this->totalNumQueries = $profiler->getTotalNumQueries();
        }
        return $this->totalNumQueries;
    }
}
