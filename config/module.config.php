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
    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'articlerequest_matching' => __DIR__ . '/../view',
        ],
    ],
];
