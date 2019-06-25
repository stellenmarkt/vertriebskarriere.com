<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\WordpressApi\Service\Plugin;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class MenusV1 extends AbstractPlugin
{

    protected $basePath = 'menus/v1';

    protected $invokableMethods = [
        'menu' => 'getMenu',
    ];

    public function getMenus()
    {
        return $this->request('menus');
    }

    public function getMenu($slug)
    {
        return $this->request('menus/' . $slug);
    }
}