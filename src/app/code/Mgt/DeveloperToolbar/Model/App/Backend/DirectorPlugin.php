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
namespace Mgt\DeveloperToolbar\Model\App\Backend;


/**
 * Plugin for Director
 */
class DirectorPlugin
{
    CONST MENU_ID = 'Mgt_Base::Mgt_Hosting';
    const MENU_SORT_ORDER = 88;

    /**
     * @param \Magento\Framework\App\ActionInterface $subject
     * @param \Closure $proceed
     * @param array $config
     * @return \Magento\Backend\Model\Menu\Builder $builder
     * @return \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function aroundDirect(
        \Magento\Backend\Model\Menu\Director\Director\Interceptor $subject,
        \Closure $proceed,
        array $config,
        \Magento\Backend\Model\Menu\Builder $builder,
        \Psr\Log\LoggerInterface $logger
    ) {

        $itemExists = $this->itemExists($config);

        if (false === $itemExists) {
            $config[] = [
                'type'      => 'add',
                'id'        => self::MENU_ID,
                'title'     => 'Magento Hosting',
                'module'    => 'Mgt_DeveloperToolbar',
                'sortOrder' => self::MENU_SORT_ORDER,
                'action'    => 'mgtdevelopertoolbar/menu/container',
                'resource'  => self::MENU_ID,
            ];
        }

        return $proceed($config, $builder, $logger);
    }

    protected function itemExists(array $config)
    {
        $itemExists = false;
        foreach ($config as $item) {
            if (isset($item['id']) && $item['id'] == self::MENU_ID) {
                $itemExists = true;
                break;
            }
        }
        return $itemExists;
    }
}
