<?php
/**
 * MatchingController.php - Main Controller
 *
 * Main Controller for Contact Address Plugin
 *
 * @category Controller
 * @package Articlerequest\Matching
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Articlerequest\Matching\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Articlerequest\Model\ArticlerequestTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Sql\Select;


class MatchingController extends CoreEntityController {
    /**
     * Contact Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * ContactController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ContactTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,ArticlerequestTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'articlerequest-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function attachMatchingForm($oItem = false) {

        $aPartialData = [
            'aMatchingResults'=>$this->getMatchingResults($oItem),
            'aViewCriterias' =>$this->getMatchingCriterias(),
        ];
        /**
        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'contactaddress-single']);
        $aFields = [
            'address-base' => CoreEntityController::$aCoreTables['core-form-field']->select(['form' => 'contactaddress-single']),
        ];

        # Try to get adress table
        try {
            $oAddressTbl = CoreEntityController::$oServiceManager->get(AddressTable::class);
        } catch(\RuntimeException $e) {
            //echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }

        if(!isset($oAddressTbl)) {
            return [];
        }

        $aAddresses = [];
        $oPrimaryAddress = false;
        if($oItem) {
            # load contact addresses
            $oAddresses = $oAddressTbl->fetchAll(false, ['contact_idfs' => $oItem->getID()]);
            # get primary address
            if (count($oAddresses) > 0) {
                $bFirst = true;
                foreach ($oAddresses as $oAddr) {
                    if($bFirst) {
                        $oPrimaryAddress = $oAddr;
                    } else {
                        $aAddresses[] = $oAddr;
                    }
                    $bFirst = false;
                }
            }
        } **/

        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'matching_data'=> $aPartialData
            ]
        ];
    }

    public function getMatchingResults($oArticleRequest) {
        if($oArticleRequest->article_idfs != 0) {
            return [];
        }

        $sCriteriaLinkMode = 'AND';

        # Init Article Table
        if(!array_key_exists('article',CoreEntityController::$aCoreTables)) {
            CoreEntityController::$aCoreTables['article'] = new TableGateway('article',CoreEntityController::$oDbAdapter);
        }
        # Init Tags Table
        if(!array_key_exists('core-tag',CoreEntityController::$aCoreTables)) {
            CoreEntityController::$aCoreTables['core-tag'] = new TableGateway('core_tag',CoreEntityController::$oDbAdapter);
        }
        # Init Entity Tags Table
        if(!array_key_exists('core-entity-tag',CoreEntityController::$aCoreTables)) {
            CoreEntityController::$aCoreTables['core-entity-tag'] = new TableGateway('core_entity_tag',CoreEntityController::$oDbAdapter);
        }
        # Init Entity Tags Table
        if(!array_key_exists('core-entity-tag-entity',CoreEntityController::$aCoreTables)) {
            CoreEntityController::$aCoreTables['core-entity-tag-entity'] = new TableGateway('core_entity_tag_entity',CoreEntityController::$oDbAdapter);
        }

        try {
            $oArticleResultTbl = CoreEntityController::$oServiceManager->get(\OnePlace\Article\Model\ArticleTable::class);
        } catch(\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Could not load entity table needed for matching'
            ));
        }

        # Init Empty List
        $aMatchedArticles = [];
        $aFieldMatchingSkipList = ['state_idfs'=>true];

        $aCriterias = $this->getMatchingCriterias();

        $oFieldsDB = CoreEntityController::$aCoreTables['core-form-field']->select(['form'=>'articlerequest-single']);
        # Match Articles by selected field values of request
        $aMatchingCrits = [];
        foreach($oFieldsDB as $oFieldReq) {
            # skip request related fields - we only want those that are linked / correspond to article
            if(array_key_exists($oFieldReq->fieldkey,$aFieldMatchingSkipList)) {
                continue;
            }
            $oField = CoreEntityController::$aCoreTables['core-form-field']->select(['form'=>'article-single','fieldkey'=>$oFieldReq->fieldkey]);
            if(count($oField) == 0 && $oFieldReq->type == 'multiselect') {
                $oField = CoreEntityController::$aCoreTables['core-form-field']->select(['form'=>'article-single','fieldkey'=>$oFieldReq->fieldkey.'_idfs']);

                $oTag = CoreEntityController::$aCoreTables['core-tag']->select(['tag_key'=>str_replace(['_idfs'],[''],$oFieldReq->fieldkey)]);
                if(count($oTag) > 0) {
                    $oTag = $oTag->current();

                    $oCategorySel = new Select(CoreEntityController::$aCoreTables['core-entity-tag-entity']->getTable());
                    $oCategorySel->join(['cet'=>'core_entity_tag'],'cet.Entitytag_ID = core_entity_tag_entity.entity_tag_idfs');
                    $oCategorySel->where(['entity_idfs'=>$oArticleRequest->getID(),'cet.tag_idfs = '.$oTag->Tag_ID,'entity_type'=>'articlerequest']);
                    $oMyCats = CoreEntityController::$aCoreTables['core-entity-tag']->selectWith($oCategorySel);

                    $oFieldReq->oValues = $oMyCats;
                }
            }
            if(count($oField) > 0) {
                $oField = $oField->current();

                switch($oField->type) {
                    case 'select':
                        $aSingleMatches = [];
                        if(isset($oFieldReq->oValues)) {
                            //echo 'go multimatch single';
                            foreach($oFieldReq->oValues as $oVal) {
                                $iVal = $oVal->Entitytag_ID;
                                $aSingleMatches = $this->matchByAttribute($oField->fieldkey,'single',$oArticleRequest,$iVal);
                                $aMatchedArticles = array_merge($aMatchedArticles,$aSingleMatches);
                            }
                        } else {
                            $aSingleMatches = $this->matchByAttribute($oField->fieldkey,'single',$oArticleRequest);
                            $aMatchedArticles = array_merge($aMatchedArticles,$aSingleMatches);
                        }
                        if(count($aSingleMatches) > 0) {
                            if(!array_key_exists($oField->fieldkey,$aMatchingCrits)) {
                                $aMatchingCrits[$oField->fieldkey] = [];
                            }
                            foreach($aSingleMatches as $oMatch) {
                                $aMatchingCrits[$oField->fieldkey][$oMatch->getID()] = true;
                            }
                        }
                        break;
                    case 'multiselect':
                        //echo 'match by '.$oField->fieldkey;
                        $aMultiMatches = $this->matchByAttribute(str_replace(['ies'],['y'],$oField->fieldkey),'multi',$oArticleRequest);
                        $aMatchedArticles = array_merge($aMatchedArticles,$aMultiMatches);
                        //echo 'result: '.count($aMultiMatches);
                        if(count($aMultiMatches) > 0) {
                            if(!array_key_exists($oField->fieldkey,$aMultiMatches)) {
                                $aMatchingCrits[$oField->fieldkey] = [];
                            }
                            foreach($aMultiMatches as $oMatch) {
                                $aMatchingCrits[$oField->fieldkey][$oMatch->getID()] = true;
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        # sort matchings by id to prevent duplicates from different matchings
        $aMatchingsByID = [];
        foreach($aMatchedArticles as $oSortMatch) {
            $aMatchingsByID[$oSortMatch->getID()] = $oSortMatch;
        }

        # if and link is active, show only articles that match ALL criterias
        if($sCriteriaLinkMode == 'AND') {
            foreach ($aMatchingsByID as $oTempMatch) {
                foreach (array_keys($aMatchingCrits) as $sMatchCrit) {
                    if (!array_key_exists($oTempMatch->getID(), $aMatchingCrits[$sMatchCrit])) {
                        unset($aMatchingsByID[$oTempMatch->getID()]);
                    }
                }
            }
        }

        # apply final matchings
        $aMatchedArticles = $aMatchingsByID;

        # enforce state on articles
        if (isset(CoreEntityController::$aGlobalSettings['articlerequest-enforce-state'])) {
            if (count($aMatchedArticles) > 0) {
                # Check if state tag is present
                $sTagKey = 'state';
                $oTag = CoreEntityController::$aCoreTables['core-tag']->select(['tag_key' => $sTagKey]);
                if (count($oTag) > 0) {
                    # check if enforce state option for request is active
                    $sState = CoreEntityController::$aGlobalSettings['articlerequest-enforce-state'];
                    if ($sState != '') {
                        # enforce state for results
                        $aEnforcedMatches = [];
                        $oTag = $oTag->current();
                        $oEntityTag = CoreEntityController::$aCoreTables['core-entity-tag']->select(['tag_value' => $sState, 'tag_idfs' => $oTag->Tag_ID]);

                        # check if state exists for entity
                        if (count($oEntityTag) > 0) {
                            $oEntityTag = $oEntityTag->current();
                            # compare state for all matches, only add matching
                            foreach (array_keys($aMatchedArticles) as $sMatchKey) {
                                $oMatch = $aMatchedArticles[$sMatchKey];
                                if ($oMatch->getSelectFieldID('state_idfs') == $oEntityTag->Entitytag_ID) {
                                    $aEnforcedMatches[] = $oMatch;
                                }
                            }
                        }
                        # return curated results
                        $aMatchedArticles = $aEnforcedMatches;
                    }
                }
            }
        }

        return $aMatchedArticles;
    }

    private function matchByAttribute($sTagKey,$sTagLinkType = 'multi',$oArticleRequest,$iMatchVal = 0) {
        try {
            $oArticleResultTbl = CoreEntityController::$oServiceManager->get(\OnePlace\Article\Model\ArticleTable::class);
        } catch(\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Could not load entity table needed for matching'
            ));
        }
        $aMatchedArticles = [];
        # Match Article by Category - only if category tag is found
        $oTag = CoreEntityController::$aCoreTables['core-tag']->select(['tag_key'=>str_replace(['_idfs'],[''],$sTagKey)]);
        if(count($oTag)) {
            $oTag = $oTag->current();
            # 1. Get all Categories linked to this request
            $oMyCats = (object)[];
            if($sTagLinkType == 'multi') {
                //echo 'match by multi tag ',$oTag->tag_key;
                $oCategorySel = new Select(CoreEntityController::$aCoreTables['core-entity-tag-entity']->getTable());
                $oCategorySel->join(['cet'=>'core_entity_tag'],'cet.Entitytag_ID = core_entity_tag_entity.entity_tag_idfs');
                $oCategorySel->where(['entity_idfs'=>$oArticleRequest->getID(),'cet.tag_idfs = '.$oTag->Tag_ID,'entity_type'=>'articlerequest']);
                $oMyCats = CoreEntityController::$aCoreTables['core-entity-tag']->selectWith($oCategorySel);

                //echo 'before count '.count($oMyCats);
                if(count($oMyCats) > 0) {
                    //echo 'got entity tags :'.count($oMyCats).',';
                    # Loop over all matched categories
                    foreach($oMyCats as $oMyCat) {
                        # Find article with the same category
                        $oMatchedArtsByCat = CoreEntityController::$aCoreTables['core-entity-tag-entity']->select(['entity_tag_idfs'=>$oMyCat->Entitytag_ID,'entity_type'=>'article']);
                        //echo 'match by et :'.$oMyCat->tag_value.' count:'.count($oMatchedArtsByCat);
                        if(count($oMatchedArtsByCat) > 0) {
                            foreach($oMatchedArtsByCat as $oMatchRow) {
                                $oMatchObj = $oArticleResultTbl->getSingle($oMatchRow->entity_idfs);
                                $oMatchObj->sMatchedBy = $sTagKey;
                                $aMatchedArticles[$oMatchObj->getID()] = $oMatchObj;
                            }
                        }
                    }
                }
            } else {
                $iMatchVal = ($iMatchVal != 0) ? $iMatchVal : $oArticleRequest->getSelectFieldID($sTagKey);
                if($iMatchVal != 0) {
                    $oMatchedArtsBySingle = $oArticleResultTbl->fetchAll(false, [$sTagKey => $iMatchVal]);
                    if (count($oMatchedArtsBySingle) > 0) {
                        foreach ($oMatchedArtsBySingle as $oMatchObj) {
                            $oMatchObj->sMatchedBy = $sTagKey;
                            $aMatchedArticles[$oMatchObj->getID()] = $oMatchObj;
                        }
                    }
                }
            }
        }

        return $aMatchedArticles;
    }

    public function getMatchingCriterias() {
        $aMatchingCriterias = [];

        # Init Criterias Table
        if(!array_key_exists('article-request-criteria',CoreEntityController::$aCoreTables)) {
            CoreEntityController::$aCoreTables['article-request-criteria'] = new TableGateway('articlerequest_criteria',CoreEntityController::$oDbAdapter);
        }

        $oCriteriasFromDB = CoreEntityController::$aCoreTables['article-request-criteria']->select();
        foreach($oCriteriasFromDB as $oCrit) {
            $aMatchingCriterias[$oCrit->criteria_entity_key] = (array)$oCrit;
        }

        return $aMatchingCriterias;
    }

    public function successAction() {
        $aInfo = explode('-',$this->params()->fromRoute('id','0-0'));
        $iRequestID = $aInfo[0];
        $iArticleID = $aInfo[1];

        # Check license
        if(!$this->checkLicense('articlerequest')) {
            $this->flashMessenger()->addErrorMessage('You have no active license for articlerequest');
            $this->redirect()->toRoute('home');
        }

        try {
            $oArticleTable = CoreEntityController::$oServiceManager->get(\OnePlace\Article\Model\ArticleTable::class);
        } catch(\RuntimeException $e) {
            echo 'could not load article table';
            return false;
        }

        # check if state tag is active
        $oTag = CoreEntityController::$aCoreTables['core-tag']->select(['tag_key'=>'state']);
        if(count($oTag) > 0) {
            $oTagState = $oTag->current();
            # check if we find success state tag for article request
            $oEntityTagRequest = CoreEntityController::$aCoreTables['core-entity-tag']->select(['tag_value'=>'success','tag_idfs'=>$oTagState->Tag_ID,'entity_form_idfs'=>'articlerequest-single']);
            if(count($oEntityTagRequest) > 0) {
                $oEntityTagSuccess = $oEntityTagRequest->current();
                $this->oTableGateway->updateAttribute('state_idfs',$oEntityTagSuccess->Entitytag_ID,'Articlerequest_ID',$iRequestID);
                $this->oTableGateway->updateAttribute('article_idfs',$iArticleID,'Articlerequest_ID',$iRequestID);
            }
            # check if we find sold state tag for article
            $oEntityTagArticle = CoreEntityController::$aCoreTables['core-entity-tag']->select(['tag_value'=>'sold','tag_idfs'=>$oTagState->Tag_ID,'entity_form_idfs'=>'article-single']);
            if(count($oEntityTagArticle) > 0) {
                $oEntityTagSold = $oEntityTagArticle->current();
                $oArticleTable->updateAttribute('state_idfs',$oEntityTagSold->Entitytag_ID,'Article_ID',$iArticleID);
            }
        }

        # Display Success Message and View New Articlerequest
        $this->flashMessenger()->addSuccessMessage('Articlerequest successfully closed');
        return $this->redirect()->toRoute('articlerequest',['action'=>'view','id'=>$iRequestID]);
    }
}
