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
namespace Mgt\DeveloperToolbar\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Format extends AbstractHelper
{
    static public function formatBytes($bytes, $decimals = 0)
    {
        $size = $bytes / 1024;
        if ($size < 1024) {
            $size = number_format($size, $decimals);
            $size .= ' KB';
        } else  {
            if ($size / 1024 < 1024)  {
                $size = number_format($size / 1024, $decimals);
                $size .= ' MB';
            }
            else if ($size / 1024 / 1024 < 1024) {
                $size = number_format($size / 1024 / 1024, $decimals);
                $size .= ' GB';
            }
        }
        return $size;
    }
    
    public function formatTime($number, $decimals = 2, $isSeconds = true)
    {
        if ($isSeconds) {
            $number *= 1000;
        }
    
        return number_format($number, $decimals, '.', '');
    }
}