<?php
/**
 * ApiController.php - Articlerequest_Matching Api Controller
 *
 * Main Controller for Articlerequest_Matching Api
 *
 * @category Controller
 * @package Application
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Articlerequest_Matching\Controller;

use Application\Controller\CoreApiController;
use OnePlace\Articlerequest_Matching\Model\Articlerequest_MatchingTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class ApiController extends CoreApiController {
    protected $sApiName;

    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param Articlerequest_MatchingTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,Articlerequest_MatchingTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'articlerequest_Matching-single';
        $this->sApiName = 'Articlerequest_Matching';
    }
}
