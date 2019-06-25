<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Controller;

use JobsFrankfurt\ContactForm\Form\ContactForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\ContactForm\Controller\ContactFormController
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class ContactFormControllerFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = $container->get('forms')->get(ContactForm::class);
        $controller = new ContactFormController($form);

        return $controller;
    }
}
