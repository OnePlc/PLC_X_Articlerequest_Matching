<?php
/**
 * Articlerequest_MatchingTable.php - Articlerequest_Matching Table
 *
 * Table Model for Articlerequest_Matching
 *
 * @category Model
 * @package Articlerequest_Matching
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Articlerequest_Matching\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class Articlerequest_MatchingTable extends CoreEntityTable {

    /**
     * Articlerequest_MatchingTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'articlerequest_Matching-single';
    }

    /**
     * Get Articlerequest_Matching Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'Articlerequest_Matching_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save Articlerequest_Matching Entity
     *
     * @param Articlerequest_Matching $oArticlerequest_Matching
     * @return int Articlerequest_Matching ID
     * @since 1.0.0
     */
    public function saveSingle(Articlerequest_Matching $oArticlerequest_Matching) {
        $aDefaultData = [
            'label' => $oArticlerequest_Matching->label,
        ];

        return $this->saveSingleEntity($oArticlerequest_Matching,'Articlerequest_Matching_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Articlerequest_Matching
     * @since 1.0.0
     */
    public function generateNew() {
        return new Articlerequest_Matching($this->oTableGateway->getAdapter());
    }
}