<?php
/**
 * module.config.php - Articlerequest_Matching Config
 *
 * Main Config File for Articlerequest_Matching Module
 *
 * @category Config
 * @package Articlerequest_Matching
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Articlerequest_Matching;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Articlerequest_Matching Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'articlerequest_Matching' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\Articlerequest_MatchingController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'articlerequest_Matching-setup' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching/setup[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
            'articlerequest_Matching-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching/api[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'articlerequest_Matching-export' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching/export[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ExportController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'articlerequest_Matching-search' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching/search[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\SearchController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'articlerequest_Matching-plugin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest_Matching/plugin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\PluginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'articlerequest_Matching' => __DIR__ . '/../view',
        ],
    ],

    # Translator
    'translator' => [
        'locale' => 'de_DE',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
];
