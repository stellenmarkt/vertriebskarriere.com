<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\Mail;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory creates a HTML Template Mail for sending single job pending notice to customer
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class SingleJobMailFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = $container->get('Core/MailService');
        $mail    = $service->get('htmltemplate');

        if (isset($options['admin'])) {
            $jobOptions = $container->get('Jobs/Options');
            $options['email'] = $jobOptions->getMultipostingApprovalMail();
        }

        if (isset($options['subject'])) {
            $mail->setSubject($options['subject']);
        }

        if (isset($options['template'])) {
            $mail->setTemplate($options['template']);
        }

        if (isset($options['email'])) {
            if (isset($options['name'])) {
                $mail->setTo($options['email'], $options['name']);
            } else {
                $mail->setTo($options['email']);
            }
        }

        if (isset($options['vars'])) {
            $mail->setVariables($options['vars']);
        }

        return $mail;
    }
}
