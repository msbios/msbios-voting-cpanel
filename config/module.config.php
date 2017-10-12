<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\CPanel;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'router' => [
        'routes' => [
            'cpanel' => [
                'child_routes' => [
                    'poll' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'poll[/[:action[/[:id[/]]]]]',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                            ],
                            'constraints' => [
                                'action' => 'add|edit|drop',
                                'id' => '[0-9]+'
                            ]
                        ]
                    ],
                    'poll-option' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'poll-option/:poll_id[/[:action[/[:id[/]]]]]',
                            'defaults' => [
                                'controller' => Controller\OptionController::class,
                            ],
                            'constraints' => [
                                'action' => 'add|edit|drop',
                                'id' => '[0-9]+'
                            ]
                        ]
                    ],
                ]
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\OptionController::class => InvokableFactory::class,
        ],
    ],

    'navigation' => [
        \MSBios\CPanel\Navigation\Sidebar::class => [
            'voting' => [
                'label' => _('Voting'),
                'uri' => '#',
                'class' => 'icon-rating3',
                'order' => 300,
                'pages' => [
                    [
                        'label' => _('Poll'),
                        'route' => 'cpanel/poll',
                        'pages' => [
                            [
                                'label' => _('Poll option'),
                                'route' => 'cpanel/poll-option',
                            ],
                        ]
                    ],
                ]
            ],
        ],
    ],

    'form_elements' => [
        'aliases' => [
            // Forms
            Controller\IndexController::class =>
                \MSBios\Voting\Resource\Form\PollForm::class,
        ]
    ],

    \MSBios\Guard\Module::class => [

        'role_providers' => [
            \MSBios\Guard\Provider\RoleProvider::class => [
            ]
        ],

        'resource_providers' => [
            \MSBios\Guard\Provider\ResourceProvider::class => [
                Controller\IndexController::class,
                Controller\OptionController::class,
            ]
        ],

        'rule_providers' => [
            \MSBios\Guard\Provider\RuleProvider::class => [
                'allow' => [
                    [['DEVELOPER'], Controller\IndexController::class],
                    [['DEVELOPER'], Controller\OptionController::class],
                ],
                'deny' => []
            ]
        ],
    ],
];
