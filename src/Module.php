<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Articlerequest Matching Module
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

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Mvc\MvcEvent;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Container;
use Laminas\EventManager\EventInterface as Event;
use Application\Controller\CoreEntityController;
use OnePlace\Articlerequest\Matching\Controller\MatchingController;
use OnePlace\Articlerequest\Model\ArticlerequestTable;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.0';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(ArticlerequestTable::class);

        # Register Filter Plugin Hook
        CoreEntityController::addHook('articlerequest-view-before',(object)['sFunction'=>'attachMatchingForm','oItem'=>new MatchingController($oDbAdapter,$tableGateway,$container)]);
    }

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                # Installer
                Controller\InstallController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\InstallController(
                        $oDbAdapter,
                        $container->get(\OnePlace\Articlerequest\Model\ArticlerequestTable::class),
                        $container
                    );
                },
                Controller\MatchingController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\MatchingController(
                        $oDbAdapter,
                        $container->get(\OnePlace\Articlerequest\Model\ArticlerequestTable::class),
                        $container
                    );
                },
            ],
        ];
    }
}
