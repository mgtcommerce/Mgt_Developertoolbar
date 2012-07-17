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

class Mgt_DeveloperToolbar_Block_Tab_PhpInfo extends Mgt_DeveloperToolbar_Block_Tab
{
    const CACHE_LIFETIME = 15000;
    const CACHE_KEY = 'DEVELOPER_TOOLBAR_TAB_PHPINFO';
    
    public function __construct($name, $label)
    {
        parent::__construct($name, $label);
        $this->setTemplate('mgt_developertoolbar/tab/phpinfo.phtml');
        $this->addData(array(
            'cache_key'      => self::CACHE_KEY,
            'cache_lifetime' => self::CACHE_LIFETIME,
        ));
    }
    
    public function showPhpInfo()
    {
        ob_start();
        phpinfo();
        preg_match ('%<style type="text/css">(.*?)</style>.*?(<body>.*</body>)%s', ob_get_clean(), $matches);
        echo "<div class='mgt-developer-toolbar-phpinfo-display'><style type='text/css'>\n",
            join( "\n",
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