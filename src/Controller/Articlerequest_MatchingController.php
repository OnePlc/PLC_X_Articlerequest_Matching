<?php
/**
 * Articlerequest_MatchingController.php - Main Controller
 *
 * Main Controller Articlerequest_Matching Module
 *
 * @category Controller
 * @package Articlerequest_Matching
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Articlerequest_Matching\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Articlerequest_Matching\Model\Articlerequest_Matching;
use OnePlace\Articlerequest_Matching\Model\Articlerequest_MatchingTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class Articlerequest_MatchingController extends CoreEntityController {
    /**
     * Articlerequest_Matching Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * Articlerequest_MatchingController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param Articlerequest_MatchingTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,Articlerequest_MatchingTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'articlerequest_Matching-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Articlerequest_Matching Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # You can just use the default function and customize it via hooks
        # or replace the entire function if you need more customization
        return $this->generateIndexView('articlerequest_Matching');
    }

    /**
     * Articlerequest_Matching Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * articlerequest_Matching-add-before (before show add form)
         * articlerequest_Matching-add-before-save (before save)
         * articlerequest_Matching-add-after-save (after save)
         */
        return $this->generateAddView('articlerequest_Matching');
    }

    /**
     * Articlerequest_Matching Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * articlerequest_Matching-edit-before (before show edit form)
         * articlerequest_Matching-edit-before-save (before save)
         * articlerequest_Matching-edit-after-save (after save)
         */
        return $this->generateEditView('articlerequest_Matching');
    }

    /**
     * Articlerequest_Matching View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * articlerequest_Matching-view-before
         */
        return $this->generateViewView('articlerequest_Matching');
    }
}
