<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Listener;

use Core\Form\Event\FormEvent;
use JobsFrankfurt\Form\UserProductInfo;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class InjectUserProductInfo 
{
    public function __invoke(FormEvent $event)
    {
        $container = $event->getForm();
        $spec      = $container->getForm('general', false);

        $info = [
            'type' => UserProductInfo::class,
            'property' => true,
            'priority' => 10,
        ];

        $spec['options']['forms']['userProduct'] = $info;

        $container->setForm('general', $spec);

    }
}
