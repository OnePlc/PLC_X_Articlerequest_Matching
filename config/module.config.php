<?php
/**
 * module.config.php - Articlerequest Matching Config
 *
 * Main Config File for Articlerequest Matching Module
 *
 * @category Config
 * @package Articlerequest\Matching
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Articlerequest\Matching;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Skeleton Module - Routes
    'router' => [
        'routes' => [
            'articlerequest-matching-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/articlerequest/matching/setup',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
            'articlerequest-matching-success' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/articlerequest/matching/success[/:id]',
                    'constraints' => [
                        'id'     => '[0-9_-]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MatchingController::class,
                        'action'     => 'success',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'articlerequest_matching' => __DIR__ . '/../view',
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
