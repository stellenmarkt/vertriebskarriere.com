<?php
/**
 * Created by PhpStorm.
 * User: cbleek
 * Date: 13.02.16
 * Time: 12:45
 */

return [
    /**
     * Identifier of the navigation configuration. This must be called "navigation"
     */
    'navigation' => [
        /**
         * Identifies a navigation.
         */
        'default' => [
            'settings' => [
                'visible' => false,
                'pages' => [
//                    'my-profile' => [
//                        'label' => /*@translate */ 'My profile',
//                        'route' => 'lang/my',
//                        'order' => 20,
//                    ],
//                    'my-password' => [
//                        'label' => /*@translate */ 'Change password',
//                        'route' => 'lang/my-password',
//                        'order' => 30,
//                    ],
//                    'my-organization' => [
//                        'label' => /*@translate */ 'My organization',
//                        'route' => 'lang/my-organization',
//                        'order' => 30,
//                    ],
                ]
            ],

            'jobboard' => [
                'label' => 'Jobs',
                'text_domain' => 'do-not-translate',
                'active_on' => ['lang/jobboard', 'lang/landingPage'],
                'query' => [ 'clear' => 1 ],
            ],
            'post-a-job' => [
                'label' => 'Stellenanzeige schalten',
                'route' => 'lang/wordpress',
                'resource' => 'resource/stellenanzeigen-schalten',
                'params' => [
                    'type' => 'page',
                    'id' => 'stellenanzeigen-schalten',
                ],
                'order' => 960,
                'class' => 'inverted'
            ],

//            'ratgeber' => [
//                'label' => 'Ratgeber',
//                'route' => 'lang/wordpress',
//                'resource' => 'resource/ratgeber',
//                'params' => [
//                    'type' => 'page',
//                    'id' => 'ratgeber',
//                ],
//                'order' => 1000,
//            ],

            'resume-recruiter' => [
                'visible' => false,
            ],
            'resume-user' => [
                'visible' => false,
            ],
            'apply' => [
                'visible' => false,
            ],
        ],
        'login' => [
            'login' => [
                'label' => 'Login',
                'route' => 'lang/auth',
                'resource' => 'route/lang/auth',  // login link only for guests
                'order' => 150,
                'class' => 'top-right'
            ],
            'logout' => [
                'label' => 'Logout',
                'route' => 'auth-logout',
                'resource' => 'route/logout',  // logout link only for logged in users
                'order' => 150,
                'class' => 'top-right'
            ],

        ],
    ],

    /**
     * if you want to completely hide the Applications fom the Menu, you can do so by ACL. Lookup the identifier
     * for the resource of the "Application" menu in the applications Module. Deny the Access for recruiters.
     */
    'acl' => [
        'rules' => [
            'guest' => [
                'allow' => [
//                  'resource/stellenanzeigen-schalten',
                    'resource/ratgeber',
                    'route/lang/organizations-profiles',
                ]
            ],
            'user' => [
                'deny' => [
                    'resource/stellenanzeigen-schalten',
                    'resource/ratgeber'
                ]
            ],
            'recruiter' => [
                'allow' => [
                    'route/logout'
                ],
                'deny' => [
                    'route/lang/auth',
                    'resource/stellenanzeigen-schalten'
                ],
            ],
        ],
    ],
    /**
     * Modules can implement SettingEntities. If they do so, they will be automatically inserted into the navigation.
     * If you want to disable this feature, you can unset Modules Settings in your configuration
     */
    'Applications' => [
        'settings' => null,
    ],
    'Core' => [
      //  'settings' => null,
    ],
];
