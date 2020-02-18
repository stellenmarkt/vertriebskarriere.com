<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace JobsFrankfurt\ContactForm\Options;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\ContactForm\Options\ContactFormOptions
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class ContactFormOptionsFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $options = isset($config['options'][ContactFormOptions::class]) ? $config['options'][ContactFormOptions::class] : [];
        $options = isset($options['options']) ? $options['options'] : (isset($options[0]) ? $options[0] : []);

        if (empty($options['email'])) {
            $options['email'] = isset($config['core_options']['system_message_email'])
                    ? $config['core_options']['system_message_email']
                    : null
            ;
        }

        $service = new ContactFormOptions($options);
        
        return $service;    
    }
}
