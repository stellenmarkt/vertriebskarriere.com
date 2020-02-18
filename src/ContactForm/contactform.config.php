<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */

namespace JobsFrankfurt\ContactForm;

use JobsFrankfurt\ContactForm\View\Helper\SetSubject;
use Laminas\ServiceManager\Factory\InvokableFactory;

$options = [
    // defaults to $config['core_options']['system_message_email']
    'email' => '',
];

$route = [
    'contact-form' => [
        'type' => 'Literal',
        'options' => [
            'route' => '/contact',
            'defaults' => [
                'controller' => Controller\ContactFormController::class,
                'action' => 'index',
            ],
        ],
    ],
];


return [
    'router' => ['routes' => [ 'lang' => ['child_routes' => $route ]]],

    'service_manager' => [
        'factories' => [
            Options\ContactFormOptions::class => Options\ContactFormOptionsFactory::class,
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\ContactFormController::class => Controller\ContactFormControllerFactory::class,
        ],
    ],

    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\ContactMailSender::class => Controller\Plugin\ContactMailSenderFactory::class,
        ],
    ],

    'form_elements' => [
        'factories' => [
            Form\ContactForm::class => Form\ContactFormFactory::class,
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'contactform.view' => __DIR__ . '/View/contactform.view.phtml',
            'contactform.mail' => __DIR__ . '/View/contactform.mail.phtml',
        ],
    ],

    'view_helpers' => [
        'factories' => [
            SetSubject::class => InvokableFactory::class,
        ],
        'aliases' => [
            'setSubject' => SetSubject::class,
        ],
    ],

    'options' => [
        Options\ContactFormOptions::class => [$options],
        Options\ContactFormFormOptions::class => [],
    ],
];
