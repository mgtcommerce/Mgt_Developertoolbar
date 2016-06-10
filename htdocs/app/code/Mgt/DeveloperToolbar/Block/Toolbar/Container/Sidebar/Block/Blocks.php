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

class Blocks extends Block
{
    /**
     * @var String
     */
    protected $label = 'Blocks';
    
    /**
     * @var Array
     */
    protected $blocks = [];

    public function setBlocks(array $blocks)
    {
        $this->blocks = $blocks;
    }
    
    public function getBlocks()
    {
        return $this->blocks;
    }

    public function renderBlocks(array $blocks)
    {
        $out = '';
        if (count($blocks)) {
          $out .= '<ul>';
          foreach ($blocks as $block) {
              $hasChildren = isset($block['children']) && count($block['children']);
              $out .= '<li '.($hasChildren ? 'class="mgt-developer-toolbar-sidebar-block-parent"' : '').'>';
              $out .= sprintf('<a href="javascript:void(0);">%s</a>', $block['name']);
              $out .= $this->renderBlockProperties($block);
              if (true === $hasChildren) {
                  $out .= $this->renderBlocks($block['children']);
              }
              $out .= '</li>';
          }
          $out .= '</ul>';
        }
        return $out;
    }
    
    protected function renderBlockProperties(array $block)
    {
        $properties = '<ul class="mgt-developer-toolbar-sidebar-block-properties" style="display:none;">';
        foreach(array('template', 'class', 'fileName') as $key) {
            if (isset($block[$key]) && $block[$key]) {
                $properties .= sprintf('<li><strong>%s:</strong> %s</li>', ucfirst($key), $block[$key]);
            }
        }
        $properties .= '</ul>';
        return $properties;
    }
}