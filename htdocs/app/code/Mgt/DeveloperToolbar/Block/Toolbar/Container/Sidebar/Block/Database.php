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

class Database extends Block
{
    /**
     * A connection operation or selecting a database.
     */
    const QUERY_TYPE_CONNECT = 1;
    
    /**
     * Any general database query that does not fit into the other constants.
     */
    const QUERY_TYPE_QUERY = 2;
    
    /**
     * Adding new data to the database, such as SQL's INSERT.
     */
    const QUERY_TYPE_INSERT = 4;
    
    /**
     * Updating existing information in the database, such as SQL's UPDATE.
     *
     */
    const QUERY_TYPE_UPDATE = 8;
    
    /**
     * An operation related to deleting data in the database,
     * such as SQL's DELETE.
     */
    const QUERY_TYPE_DELETE = 16;
    
    /**
     * Retrieving information from the database, such as SQL's SELECT.
     */
    const QUERY_TYPE_SELECT = 32;
    
    /**
     * Transactional operation, such as start transaction, commit, or rollback.
     */
    const QUERY_TYPE_TRANSACTION = 64;
    
    /**
     * @var String
     */
    protected $label = 'Database';
    
    /**
     * @var Array
     */
    protected $queries = [];
    
    /**
     * @var Integer
     */
    protected $totalNumberOfQueries;
    
    /**
     *
     * @var Double
     */
    protected $totalElapsedSecs;
    
    public function setQueries(array $queries)
    {
        $this->queries = $queries;
    }
    
    public function getQueries()
    {
        return $this->queries;
    }
    
    public function setTotalNumberOfQueries($totalNumberOfQueries)
    {
        $this->totalNumberOfQueries = $totalNumberOfQueries;
    }
    
    public function getTotalNumberOfQueries()
    {
        return $this->totalNumberOfQueries;
    }
    
    public function setTotalElapsedSecs($totalElapsedSecs)
    {
        $this->totalElapsedSecs = $totalElapsedSecs;
    }
    
    public function getTotalElapsedSecs()
    {
        return $this->totalElapsedSecs;
    }
    
    public function getQueriesByType($queryType)
    {
        $filertedQueries = [];
        $queries = $this->getQueries();
        foreach ($queries as $query) {
            if (isset($query['type']) && $query['type'] == $queryType) {
                $filertedQueries[] = $query;
            }
        }
        return $filertedQueries;
    }
    
    public function getSlowestQueries($limit = 5)
    {
        $queries = $this->getQueries();

        usort($queries, function($a, $b){
            return $a['time'] < $b['time'];
        });
        
        $queries = array_slice($queries, 0, $limit);
        
        return $queries;
    }
}