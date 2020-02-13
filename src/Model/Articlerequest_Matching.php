<?php
/**
 * Articlerequest_Matching.php - Articlerequest_Matching Entity
 *
 * Entity Model for Articlerequest_Matching
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

use Application\Model\CoreEntityModel;

class Articlerequest_Matching extends CoreEntityModel {
    public $label;

    /**
     * Articlerequest_Matching constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'articlerequest_Matching-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Articlerequest_Matching_ID']) ? $aData['Articlerequest_Matching_ID'] : 0;
        $this->label = !empty($aData['label']) ? $aData['label'] : '';

        $this->updateDynamicFields($aData);
    }
}