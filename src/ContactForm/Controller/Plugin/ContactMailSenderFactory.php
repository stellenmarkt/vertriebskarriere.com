<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Controller\Plugin;

use JobsFrankfurt\ContactForm\Options\ContactFormOptions;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\ContactForm\Controller\Plugin\ContactMailSender
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class ContactMailSenderFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $mailer = $container->get('Core/MailService');
        $options = $container->get(ContactFormOptions::class);
        $plugin = new ContactMailSender($mailer, $options);

        return $plugin;
    }
}
