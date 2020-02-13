<?php
/**
 * ExportController.php - Articlerequest_Matching Export Controller
 *
 * Main Controller for Articlerequest_Matching Export
 *
 * @category Controller
 * @package Articlerequest_Matching
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Articlerequest_Matching\Controller;

use Application\Controller\CoreController;
use Application\Controller\CoreExportController;
use OnePlace\Articlerequest_Matching\Model\Articlerequest_MatchingTable;
use Laminas\Db\Sql\Where;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\View\Model\ViewModel;


class ExportController extends CoreExportController
{
    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param Articlerequest_MatchingTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,Articlerequest_MatchingTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
    }


    /**
     * Dump Articlerequest_Matchings to excel file
     *
     * @return ViewModel
     * @since 1.0.0
     */
    public function dumpAction() {
        $this->layout('layout/json');

        # Use Default export function
        $aViewData = $this->exportData('Articlerequest_Matchings','articlerequest_Matching');

        # return data to view (popup)
        return new ViewModel($aViewData);
    }
}