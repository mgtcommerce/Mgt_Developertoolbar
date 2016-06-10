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

class Phpinfo extends Block
{
    /**
     * @var String
     */
    protected $label = 'PHP-Info';

    public function showPhpInfo()
    {
        ob_start();
        phpinfo();
        preg_match ('%<style type="text/css">(.*?)</style>.*?(<body>.*</body>)%s', ob_get_clean(), $matches);
        echo "<div class='mgt-developer-toolbar-phpinfo-display'><style type='text/css'>\n",
        join("\n",
            array_map(
                create_function(
                    '$i',
                    'return ".mgt-developer-toolbar-phpinfo-display " . preg_replace( "/,/", ",.phpinfodisplay ", $i );'
                ),
                preg_split( '/\n/', $matches[1] )
            )
        ),
        "</style>\n",
        $matches[2],
        "\n</div>\n";
    }
}