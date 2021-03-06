<?php
/**
 * GaiaEHR (Electronic Health Records)
 * Copyright (C) 2013 Certun, LLC.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$API = array(
    /**
     * Accounting Billing Functions
     */
    'AccVoucher' => array(
        'methods' => array(
            'getVoucher' => array(
                'len' => 1
            ),
            'addVoucher' => array(
                'len' => 1
            ),
            'updateVoucher' => array(
                'len' => 1
            ),
            'destroyVoucher' => array(
                'len' => 1
            ),
            'getVoucherLines' => array(
                'len' => 1
            ),
            'addVoucherLine' => array(
                'len' => 1
            ),
            'updateVoucherLine' => array(
                'len' => 1
            ),
            'destroyVoucherLine' => array(
                'len' => 1
            ),
	        'getVisitCheckOutCharges' => array(
		        'len' => 1
	        )

        )
    ),
    'Procedures' => array(
        'methods' => array(
            'loadProcedures' => array(
                'len' => 1
            ),
            'saveProcedure' => array(
                'len' => 1
            ),
            'destroyProcedure' => array(
                'len' => 1
            )
        )
    ),
    'CupTest' => array(
        'methods' => array(
            'cuptest' => array(
                'len' => 1
            )
        )
    ),
    'AccAccount' => array(
        'methods' => array(

        )
    ),

	'Modules' => array(
		'methods' => array(
			'getAllModules' => array(
				'len' => 0
			),
			'getActiveModules' => array(
				'len' => 0
			),
			'getEnabledModules' => array(
				'len' => 0
			),
			'getDisabledModules' => array(
				'len' => 0
			),
			'getModuleByName' => array(
				'len' => 1
			),
			'updateModule' => array(
				'len' => 1
			)
		)
	),

	'Emergency' => array(
		'methods' => array(
			'createNewEmergency' => array(
				'len' => 0
            )
        )
	),

	'Snippets' => array(
		'methods' => array(
			'getSoapSnippetsByCategory' => array(
				'len' => 1
            ),
			'addSoapSnippets' => array(
				'len' => 1
            ),
			'updateSoapSnippets' => array(
				'len' => 1
            ),
			'deleteSoapSnippets' => array(
				'len' => 1
            )
        )
	),

	'Orders' => array(
		'methods' => array(
			'getPatientOrders' => array(
				'len' => 1
            ),
			'addPatientOrder' => array(
				'len' => 1
            ),
			'updatePatientOrder' => array(
				'len' => 1
            ),
			'deletePatientOrder' => array(
				'len' => 1
            ),
			'getOrderResults' => array(
				'len' => 1
            ),
			'addOrderResults' => array(
				'len' => 1
            ),
			'updateOrderResults' => array(
				'len' => 1
            ),
			'deleteOrderResults' => array(
				'len' => 1
			),
			'getOrderResultObservations' => array(
				'len' => 1
            ),
			'addOrderResultObservations' => array(
				'len' => 1
            ),
			'updateOrderResultObservations' => array(
				'len' => 1
            ),
			'deleteOrderResultObservations' => array(
				'len' => 1
            )
		)
	),

	'Referrals' => array(
		'methods' => array(
			'getPatientReferrals' => array(
				'len' => 1
            ),
			'getPatientReferral' => array(
				'len' => 1
            ),
			'addPatientReferral' => array(
				'len' => 1
            ),
			'updatePatientReferral' => array(
				'len' => 1
            ),
			'deletePatientReferral' => array(
				'len' => 1
            ),
		)
	),

	'DiagnosisCodes' => array(
		'methods' => array(
			'ICDCodeSearch' => array(
				'len' => 1
			),
			'liveCodeSearch' => array(
				'len' => 1
			),
			'getICDByEid' => array(
				'len' => 1
			)
		)
	),

	'ExternalDataUpdate' => array(
		'methods' => array(
			'updateCodesWithUploadFile' => array(
				'formHandler' => true,
				'len' => 0
			),
			'getCodeFiles' => array(
				'len' => 1
			),
			'updateCodes' => array(
				'len' => 1
			),
			'getCurrentCodesInfo' => array(
				'len' => 0
			)
		)
	),
	/**
	 * Encounter Functions
	 */
	'Encounter' => array(
		'methods' => array(
			'checkOpenEncountersByPid' => array(
				'len' => 1
			),
			'getEncounters' => array(
				'len' => 1
			),
			'getEncounter' => array(
				'len' => 1
			),
			'getEncounterSummary' => array(
				'len' => 1
			),
			'updateEncounter' => array(
				'len' => 1
			),
			'updateEncounterPriority' => array(
				'len' => 1
			),
			'getVitals' => array(
				'len' => 1
			),
			'addVitals' => array(
				'len' => 1
			),
			'updateVitals' => array(
				'len' => 1
			),
			'createEncounter' => array(
				'len' => 1
			),
			'updateSoapById' => array(
				'len' => 1
			),
			'getEncounterIcdxCodes' => array(
				'len' => 1
			),
			'updateEncounterIcdxCodes' => array(
				'len' => 1
			),
			'updateReviewOfSystemsChecksById' => array(
				'len' => 1
			),
			'updateReviewOfSystemsById' => array(
				'len' => 1
			),
			'updateDictationById' => array(
				'len' => 1
			),
			'getProgressNoteByEid' => array(
				'len' => 1
			),
			'closeEncounter' => array(
				'len' => 1
			),
			'getEncounterEventHistory' => array(
				'len' => 1
			),
			'getEncounterCodes' => array(
				'len' => 1
			),
			'getEncounterCptDxTree' => array(
				'len' => 1
			),
			'addEncounterCptDxTree' => array(
				'len' => 1
			),
			'updateEncounterCptDxTree' => array(
				'len' => 1
			),
			'removeEncounterCptDxTree' => array(
				'len' => 1
			),
			'checkoutAlerts' => array(
				'len' => 1
			),
			'checkForAnOpenedEncounterByPid' => array(
				'len' => 1
			),
			'getEncounterFollowUpInfoByEid' => array(
				'len' => 1
			),
			'getEncounterMessageByEid' => array(
				'len' => 1
			),
			'onSaveItemsToReview' => array(
				'len' => 1
			),
			'getSoapHistory' => array(
				'len' => 1
			),
			'updateEncounterHCFAOptions' => array(
				'len' => 1
			),
			'onReviewAllItemsToReview' => array(
				'len' => 1
			),
			'getEncountersByDate' => array(
				'len' => 1
			),
			'getTodayEncounters' => array(
				'len' => 0
			)
		)
	),
	/*
	 * Floor Plans function
	 */
	'FloorPlans' => array(
		'methods' => array(
			'getFloorPlans' => array(
				'len' => 0
			),
			'createFloorPlan' => array(
				'len' => 1
			),
			'updateFloorPlan' => array(
				'len' => 1
			),
			'removeFloorPlan' => array(
				'len' => 1
			),
			'getFloorPlanZones' => array(
				'len' => 1
			),
			'createFloorPlanZone' => array(
				'len' => 1
			),
			'updateFloorPlanZone' => array(
				'len' => 1
			),
			'removeFloorPlanZone' => array(
				'len' => 1
			),
			'setPatientToZone' => array(
				'len' => 1
			),
			'unSetPatientZoneByPatientZoneId' => array(
				'len' => 1
			),
			'getPatientsZonesByFloorPlanId' => array(
				'len' => 1
			),
			'unSetPatientFromZoneByPid' => array(
				'len' => 1
			)
		)
	),
	'VectorGraph' => array(
		'methods' => array(
			'getGraphData' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Calendar Functions
	 */
	'Calendar' => array(
		'methods' => array(
			'getCalendars' => array(
				'len' => 0
			),
			'getEvents' => array(
				'len' => 1
			),
			'addEvent' => array(
				'len' => 1
			),
			'updateEvent' => array(
				'len' => 1
			),
			'deleteEvent' => array(
				'len' => 1
			),
			'getPatientFutureEvents' => array(
				'len' => 1
			),
		)
	),
	/**
	 * Messages Functions
	 */
	'Messages' => array(
		'methods' => array(
			'getMessages' => array(
				'len' => 1
			),
			'deleteMessage' => array(
				'len' => 1
			),
			'sendNewMessage' => array(
				'len' => 1
			),
			'replyMessage' => array(
				'len' => 1
			),
			'updateMessage' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Security Functions
	 */
	'Question' => array(
		'methods' => array(
			'getQuestions' => array(
				'len' => 1
			),
			'updateQuestion' => array(
				'len' => 1
			),
			'addQuestion' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Fees Functions
	 */
	'Fees' => array(
		'methods' => array(
			'getFilterEncountersBillingData' => array(
				'len' => 1
			),
			'getEncountersByPayment' => array(
				'len' => 1
			),
			'addPayment' => array(
				'len' => 1
			),
			'getPatientBalance' => array(
				'len' => 1
			),
			'getPaymentsBySearch' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Facilities Functions
	 */
	'Facilities' => array(
		'methods' => array(
			'getFacilities' => array(
				'len' => 1
			),
			'addFacility' => array(
				'len' => 1
			),
			'updateFacility' => array(
				'len' => 1
			),
			'deleteFacility' => array(
				'len' => 1
			),
			'getFacility' => array(
				'len' => 1
			),
			'setFacility' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Medical Functions
	 */
	'Medical' => array(
		'methods' => array(
			'getImmunizationsList' => array(
				'len' => 0
			),
			'getPatientImmunizations' => array(
				'len' => 1
			),
			'addPatientImmunization' => array(
				'len' => 1
			),
			'updatePatientImmunization' => array(
				'len' => 1
			),
			'getPatientAllergies' => array(
				'len' => 1
			),
			'addPatientAllergies' => array(
				'len' => 1
			),
			'updatePatientAllergies' => array(
				'len' => 1
			),
			'getMedicalIssues' => array(
				'len' => 1
			),
			'addMedicalIssues' => array(
				'len' => 1
			),
			'updateMedicalIssues' => array(
				'len' => 1
			),
			'getPatientSurgery' => array(
				'len' => 1
			),
			'addPatientSurgery' => array(
				'len' => 1
			),
			'updatePatientSurgery' => array(
				'len' => 1
			),
			'getPatientDental' => array(
				'len' => 1
			),
			'addPatientDental' => array(
				'len' => 1
			),
			'updatePatientDental' => array(
				'len' => 1
			),
			'getPatientMedications' => array(
				'len' => 1
			),
			'addPatientMedications' => array(
				'len' => 1
			),
			'updatePatientMedications' => array(
				'len' => 1
			),
			'deletePatientMedications' => array(
				'len' => 1
			),
			'getMedicationLiveSearch' => array(
				'len' => 1
			),
			'getPatientLabsResults' => array(
				'len' => 1
			),
			'addPatientLabsResult' => array(
				'len' => 1
			),
			'updatePatientLabsResult' => array(
				'len' => 1
			),
			'deletePatientLabsResult' => array(
				'len' => 1
			),
			'signPatientLabsResultById' => array(
				'len' => 1
			),
			'reviewMedicalWindowEncounter' => array(
				'len' => 1
			),
			'getLabsLiveSearch' => array(
				'len' => 1
			),
			'reviewAllMedicalWindowEncounter' => array(
				'len' => 1
			),
			'getEncounterReviewByEid' => array(
				'len' => 1
			),
			'getSurgeriesLiveSearch' => array(
				'len' => 1
			),
			'getCDTLiveSearch' => array(
				'len' => 1
			),
			'getPatientsMedicalSummaryGrouped' => array(
				'len' => 1
			),
			'sendVXU' => array(
				'len' => 1
			)
		)
	),
	 /**
	 * AddressBook Functions
	 */
	'AddressBook' => array(
		'methods' => array(
			'getAddresses' => array(
				'len' => 1
			),
			'addContact' => array(
				'len' => 1
			),
			'updateAddress' => array(
				'len' => 1
			)
		)
	),
	'Rxnorm' => array(
		'methods' => array(
			'getRXNORMLiveSearch' => array(
				'len' => 1
			),
			'getRXNORMList' => array(
				'len' => 1
			),
			'getRXNORMAllergyLiveSearch' => array(
				'len' => 1
			),
			'getMedicationAttributesByCODE' => array(
				'len' => 1
			)
		)
	),
	'Medications' => array(
		'methods' => array(
			'getMedications' => array(
				'len' => 1
			),
			'addMedications' => array(
				'len' => 1
			),
			'removeMedications' => array(
				'len' => 1
			),
			'updateMedications' => array(
				'len' => 1
			)
		)
	),
	'Immunizations' => array(
		'methods' => array(
			'getMvx' => array(
				'len' => 1
			),
			'getMvxForCvx' => array(
				'len' => 1
			),
			'getImmunizationLiveSearch' => array(
				'len' => 1
			)
		)
	),	'Xrays' => array(
		'methods' => array(
			'getXrays' => array(
				'len' => 1
			),
			'getXraysLiveSearch' => array(
				'len' => 1
			)
		)
	),
	'Laboratories' => array(
		'methods' => array(
			'getLabObservations' => array(
				'len' => 1
			),
			'addLabObservation' => array(
				'len' => 1
			),
			'updateLabObservation' => array(
				'len' => 1
			),
			'removeLabObservation' => array(
				'len' => 1
			),
			'getActiveLaboratoryTypes' => array(
				'len' => 1
			),
			'indexLoincPanels' => array(
				'len' => 0
			),
			'getLabLoincLiveSearch' => array(
				'len' => 1
			),
			'getRadLoincLiveSearch' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Practice Functions
	 */
	'Practice' => array(
		'methods' => array(
			'getPharmacies' => array(
				'len' => 0
			),
			'addPharmacy' => array(
				'len' => 1
			),
			'updatePharmacy' => array(
				'len' => 1
			),
			'getLaboratories' => array(
				'len' => 0
			),
			'addLaboratory' => array(
				'len' => 1
			),
			'updateLaboratory' => array(
				'len' => 1
			),
			'getInsurances' => array(
				'len' => 0
			),
			'addInsurance' => array(
				'len' => 1
			),
			'updateInsurance' => array(
				'len' => 1
			),
			'getInsuranceNumbers' => array(
				'len' => 1
			),
			'getX12Partners' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Globals Functions
	 */
	'Globals' => array(
		'methods' => array(
			'setGlobals' => array(
				'len' => 0
			),
			'getGlobals' => array(
				'len' => 0
			),
			'getAllGlobals' => array(
				'len' => 0
			),
			'updateGlobals' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Lists Functions
	 */
	'Lists' => array(
		'methods' => array(
			'getOptions' => array(
				'len' => 1
			),
			'addOption' => array(
				'len' => 1
			),
			'updateOption' => array(
				'len' => 1
			),
			'deleteOption' => array(
				'len' => 1
			),
			'sortOptions' => array(
				'len' => 1
			),
			'getLists' => array(
				'len' => 1
			),
			'addList' => array(
				'len' => 1
			),
			'updateList' => array(
				'len' => 1
			),
			'deleteList' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Office Notes Functions
	 */
	'OfficeNotes' => array(
		'methods' => array(
			'getOfficeNotes' => array(
				'len' => 1
			),
			'addOfficeNotes' => array(
				'len' => 1
			),
			'updateOfficeNotes' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Social History Functions
	 */
	'SocialHistory' => array(
		'methods' => array(
			'getSocialHistories' => array(
				'len' => 1
			),
			'getSocialHistory' => array(
				'len' => 1
			),
			'addSocialHistory' => array(
				'len' => 1
			),
			'updateSocialHistory' => array(
				'len' => 1
			),
			'destroySocialHistory' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Prescriptions Functions
	 */
	'Prescriptions' => array(
		'methods' => array(
			'getPrescriptions' => array(
				'len' => 1
			),
			'addPrescription' => array(
				'len' => 1
			),
			'updatePrescription' => array(
				'len' => 1
			),
			'getPrescriptionMedications' => array(
				'len' => 1
			),
			'addPrescriptionMedication' => array(
				'len' => 1
			),
			'updatePrescriptionMedication' => array(
				'len' => 1
			),
			'getSigCodesByQuery' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Services Functions
	 */
	'DataManager' => array(
		'methods' => array(
			'getServices' => array(
				'len' => 1),
			'addService' => array(
				'len' => 1
			),
			'updateService' => array(
				'len' => 1
			),
			'liveCodeSearch' => array(
				'len' => 1
			),
			'getCptCodes' => array(
				'len' => 1
			),
			'addCptCode' => array(
				'len' => 1
			),
			'updateCptCode' => array(
				'len' => 1
			),
			'deleteCptCode' => array(
				'len' => 1
			),
			'getActiveProblems' => array(
				'len' => 1
			),
			'addActiveProblems' => array(
				'len' => 1
			),
			'removeActiveProblems' => array(
				'len' => 1
			),
			'getMedications' => array(
				'len' => 1
			),
			'addMedications' => array(
				'len' => 1
			),
			'removeMedications' => array(
				'len' => 1
			),
			'updateMedications' => array(
				'len' => 1
			),
			'getAllLabObservations' => array(
				'len' => 1
			),
			'getLabObservations' => array(
				'len' => 1
			),
			'addLabObservation' => array(
				'len' => 1
			),
			'updateLabObservation' => array(
				'len' => 1
			),
			'removeLabObservation' => array(
				'len' => 1
			),
			'getActiveLaboratoryTypes' => array(
				'len' => 0
			)
		)
	),
	'Services' => array(
		'methods' => array(
			'getServices' => array(
				'len' => 1
			),
			'addService' => array(
				'len' => 1
			),
			'updateService' => array(
				'len' => 1
			),
			'liveCodeSearch' => array(
				'len' => 1
			),
			'getCptCodes' => array(
				'len' => 1
			),
			'addCptCode' => array(
				'len' => 1
			),
			'updateCptCode' => array(
				'len' => 1
			),
			'deleteCptCode' => array(
				'len' => 1
			),
			'getActiveProblems' => array(
				'len' => 1
			),
			'addActiveProblems' => array(
				'len' => 1
			),
			'removeActiveProblems' => array(
				'len' => 1
			),
			'getMedications' => array(
				'len' => 1
			),
			'addMedications' => array(
				'len' => 1
			),
			'removeMedications' => array(
				'len' => 1
			),
			'updateMedications' => array(
				'len' => 1
			),
			'getAllLabObservations' => array(
				'len' => 1
			),
			'getLabObservations' => array(
				'len' => 1
			),
			'addLabObservation' => array(
				'len' => 1
			),
			'updateLabObservation' => array(
				'len' => 1
			),
			'removeLabObservation' => array(
				'len' => 1
			),
			'getActiveLaboratoryTypes' => array(
				'len' => 0
			),
			'getQuickAccessCheckOutServices' => array(
				'len' => 0
			)
		)
	),
	/**
	 * Preventive Care Functions
	 */
	'PreventiveCare' => array(
		'methods' => array(
			'getServices' => array(
				'len' => 1
			),
			'addService' => array(
				'len' => 1
			),
			'updateService' => array(
				'len' => 1
			),
			'liveCodeSearch' => array(
				'len' => 1
			),
			'getCptCodes' => array(
				'len' => 1
			),
			'addCptCode' => array(
				'len' => 1
			),
			'updateCptCode' => array(
				'len' => 1
			),
			'deleteCptCode' => array(
				'len' => 1
			),
			'getActiveProblems' => array(
				'len' => 1
			),
			'addActiveProblems' => array(
				'len' => 1
			),
			'removeActiveProblems' => array(
				'len' => 1
			),
			'getMedications' => array(
				'len' => 1
			),
			'addMedications' => array(
				'len' => 1
			),
			'removeMedications' => array(
				'len' => 1
			),
			'updateMedications' => array(
				'len' => 1
			),
			'getRelations' => array(
				'len' => 1
			),
			'addRelations' => array(
				'len' => 1
			),
			'removeRelations' => array(
				'len' => 1
			),
			'getImmunizationsCheck' => array(
				'len' => 1
			),
			'getPreventiveCareCheck' => array(
				'len' => 1
			),
			'activePreventiveCareAlert' => array(
				'len' => 1
			),
			'addPreventivePatientDismiss' => array(
				'len' => 1
			),
			'getGuideLinesByCategory' => array(
				'len' => 1
			),
			'addGuideLine' => array(
				'len' => 1
			),
			'updateGuideLine' => array(
				'len' => 1
			),
			'getGuideLineActiveProblems' => array(
				'len' => 1
			),
			'addGuideLineActiveProblems' => array(
				'len' => 1
			),
			'removeGuideLineActiveProblems' => array(
				'len' => 1
			),
			'getGuideLineMedications' => array(
				'len' => 1
			),
			'addGuideLineMedications' => array(
				'len' => 1
			),
			'removeGuideLineMedications' => array(
				'len' => 1
			),
			'getGuideLineLabs' => array(
				'len' => 1
			),
			'addGuideLineLabs' => array(
				'len' => 1
			),
			'removeGuideLineLabs' => array(
				'len' => 1
			),
			'updateGuideLineLabs' => array(
				'len' => 1
			),
			'getPreventiveCareDismissPatientByEncounterID' => array(
				'len' => 1
			),
			'getPreventiveCareDismissedAlertsByPid' => array(
				'len' => 1
			),
			'updatePreventiveCareDismissedAlertsByPid' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Form layout Engine Functions
	 */
	'FormLayoutEngine' => array(
		'methods' => array(
			'getFields' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Pool Area Functions
	 */
	'PoolArea' => array(
		'methods' => array(
			'getPatientsArrivalLog' => array(
				'len' => 1
			),
			'addPatientArrivalLog' => array(
				'len' => 1
			),
			'updatePatientArrivalLog' => array(
				'len' => 1
			),
			'removePatientArrivalLog' => array(
				'len' => 1
			),
			'getPoolAreaPatients' => array(
				'len' => 1
			),
			'sendPatientToPoolArea' => array(
				'len' => 1
			),
			'getActivePoolAreas' => array(
				'len' => 0
			),
			'getFacilityActivePoolAreas' => array(
				'len' => 0
			),
			'getPatientsByPoolAreaAccess' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Form layout Builder Functions
	 */
	'FormLayoutBuilder' => array(
		'methods' => array(
			'getFormDataTable' => array(
				'len' => 1
			),
			'getForms' => array(
				'len' => 1
			),
			'getParentFields' => array(
				'len' => 1
			),
			'getFormFieldsTree' => array(
				'len' => 1
			),
			'createFormField' => array(
				'len' => 1
			),
			'updateFormField' => array(
				'len' => 1
			),
			'removeFormField' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Form layout Builder Functions
	 */
	'CCR' => array(
		'methods' => array(
			'createCCR' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Patient Functions
	 */
	'Patient' => array(
		'methods' => array(
			'getPatients' => array(
				'len' => 1
			),
			'savePatient' => array(
				'len' => 1
			),
			'getInsurances' => array(
				'len' => 1
			),
			'saveInsurance' => array(
				'len' => 1
			),
			'createNewPatient' => array(
				'len' => 1
			),
			'patientLiveSearch' => array(
				'len' => 1
			),
			'getPatientSetDataByPid' => array(
				'len' => 1
			),
			'unsetPatient' => array(
				'len' => 1
			),
			'getPatientDemographicData' => array(
				'len' => 1
			),
			'updatePatientDemographicData' => array(
				'len' => 1
			),
			'addPatientNoteAndReminder' => array(
				'len' => 1
			),
			'getPatientReminders' => array(
				'len' => 1
			),
			'getPatientNotes' => array(
				'len' => 1
			),
			'getPatientDocuments' => array(
				'len' => 1
			),
			'getPatientDocumentsByEid' => array(
				'len' => 1
			),
			'getMeaningfulUserAlertByPid' => array(
				'len' => 1
			),
			'getPatientInsurancesCardsUrlByPid' => array(
				'len' => 1
			),
			'getPatientDisclosures' => array(
				'len' => 1
			),
			'createPatientDisclosure' => array(
				'len' => 1
			),
			'updatePatientDisclosure' => array(
				'len' => 1
			),
			'addPatientReminders' => array(
				'len' => 1
			),
			'updatePatientReminders' => array(
				'len' => 1
			),
			'addPatientNotes' => array(
				'len' => 1
			),
			'updatePatientNotes' => array(
				'len' => 1
			),
			'setPatientRating' => array(
				'len' => 1
			)
		)
	),
	/**
	 * User Functions
	 */
	'User' => array(
		'methods' => array(
			'getUsers' => array(
				'len' => 1
			),
			'getUser' => array(
				'len' => 1
			),
			'addUser' => array(
				'len' => 1
			),
			'updateUser' => array(
				'len' => 1
			),
			'updatePassword' => array(
				'len' => 1
			),
			'usernameExist' => array(
				'len' => 1
			),
			'getCurrentUserData' => array(
				'len' => 0
			),
			'getCurrentUserBasicData' => array(
				'len' => 0
			),
			'updateMyAccount' => array(
				'len' => 1
			),
			'verifyUserPass' => array(
				'len' => 1
			),
			'getProviders' => array(
				'len' => 0
			),
			'getActiveProviders' => array(
				'len' => 0
			),
			'getUserFullNameById' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Authorization Procedures Functions
	 */
	'authProcedures' => array(
		'methods' => array(
			'login' => array(
				'len' => 1
			),
			'ckAuth' => array(
				'len' => 0
			),
			'doForget' => array( //[New] Added ::
				'len' => 1
			),
			'passwordRecovery' => array( //[New] Added ::
				'len' => 1
			),//
			'doSetPID' => array( //[New] Added ::
				'len' => 1
			),
			'recoverPassword' => array( //[New] Added ::
				'len' => 1
			),
			'doCreateEncounter' => array( //[New] Added ::
				'len' => 1
			),
			'unAuth' => array(
				'len' => 0
			),
			'getSites' => array(
				'len' => 0
			)
		)
	),
	/**
	 * Comobo Boxes Data Functions
	 */
	'CombosData' => array(
		'methods' => array(
			'getOptionsByListId' => array(
				'len' => 1
			),
			'getTimeZoneList' => array(
				'len' => 1
			),
			'getActivePharmacies' => array(
				'len' => 0
			),
			'getUsers' => array(
				'len' => 0
			),
			'getLists' => array(
				'len' => 0
			),
			'getFacilities' => array(
				'len' => 0
			),
			'getActiveFacilities' => array(
				'len' => 0
			),
			'getBillingFacilities' => array(
				'len' => 0
			),
			'getRoles' => array(
				'len' => 0
			),
			'getCodeTypes' => array(
				'len' => 0
			),
			'getCalendarCategories' => array(
				'len' => 0
			),
			'getFloorPlanAreas' => array(
				'len' => 0
			),
			'getAuthorizations' => array(
				'len' => 0
			),
			'getSeeAuthorizations' => array(
				'len' => 0
			),
			'getTaxIds' => array(
				'len' => 0
			),
			'getFiledXtypes' => array(
				'len' => 0
			),
			'getPosCodes' => array(
				'len' => 0
			),
			'getAllergyTypes' => array(
				'len' => 0
			),
			'getAllergiesByType' => array(
				'len' => 1
			),
			'getTemplatesTypes' => array(
				'len' => 1
			),
			'getActiveInsurances' => array(
				'len' => 0
			),
			'getThemes' => array(
				'len' => 0
			)
		)),
	/**
	 * Navigation Function
	 */
	'Navigation' => array(
		'methods' => array(
			'getNavigation' => array(
				'len' => 0
			)
		)
	),
	/**
	 * Navigation Function
	 */
	'Roles' => array(
		'methods' => array(
			'getRolePerms' => array(
				'len' => 0
			),
			'updateRolePerm' => array(
				'len' => 1
			),
			'getRolesData' => array(
				'len' => 0
			),
			'saveRolesData' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Navigation Function
	 */
	'ACL' => array(
		'methods' => array(
			'getAllUserPermsAccess' => array(
				'len' => 0
			),
			'hasPermission' => array(
				'len' => 1
			),
			'emergencyAccess' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Navigation Function
	 */
	'AuditLog' => array(
		'methods' => array(
			'getLogs' => array(
				'len' => 1
			),
            'setLog' => array(
                'len' => 1
            )
		)
	),
	'Documents' => array(
		'methods' => array(
			'updateDocumentsTitle' => array(
				'len' => 1
			)
		)
	),
	/**
	 * Document Handler functions
	 */
	'DocumentHandler' => array(
		'methods' => array(
			'uploadDocument' => array(
				'formHandler' => true,
				'len' => 1
			),
			'getDocumentsTemplates' => array(
				'len' => 1
			),
			'addDocumentsTemplates' => array(
				'len' => 1
			),
			'updateDocumentsTemplates' => array(
				'len' => 1
			),
			'getHeadersAndFootersTemplates' => array(
				'len' => 1
			),
			'getDefaultDocumentsTemplates' => array(
				'len' => 1
			),
			'createDocument' => array(
				'len' => 1
			),
			'createDocumentDoctorsNote' => array(
				'len' => 1
			),
			'checkDocHash' => array(
				'len' => 1
			)
		)
	),
	'File' => array(
		'methods' => array(
			'savePatientBase64Document' => array(
				'len' => 1
			)
		)
	),
	'CronJob' => array(
		'methods' => array(
			'run' => array(
				'len' => 0
			)
		)
	),
	'i18nRouter' => array(
		'methods' => array(
			'getTranslation' => array(
				'len' => 0
			),
			'getDefaultLanguage' => array(
				'len' => 0
			),
			'getAvailableLanguages' => array(
				'len' => 0
			)
		)
	),
	'SiteSetup' => array(
		'methods' => array(
			'checkDatabaseCredentials' => array(
				'len' => 1
			),
			'checkRequirements' => array(
				'len' => 0
			),
			'setSiteDirBySiteId' => array(
				'len' => 1
			),
			'createDatabaseStructure' => array(
				'len' => 1
			),
			'loadDatabaseData' => array(
				'len' => 1
			),
			'createSiteAdmin' => array(
				'len' => 1
			),
			'createSConfigurationFile' => array(
				'len' => 1
			),
			'loadCode' => array(
				'len' => 1
			)
		)
	),
	'Applications' => array(
		'methods' => array(
			'getApplications' => array(
				'len' => 1
			),
			'addApplication' => array(
				'len' => 1
			),
			'updateApplication' => array(
				'len' => 1
			),
			'deleteApplication' => array(
				'len' => 1
			)
		)
	),
	'HL7Messages' => array(
		'methods' => array(
			'getMessages' => array(
				'len' => 1
			),
			'getMessage' => array(
				'len' => 1
			),
			'getMessageById' => array(
				'len' => 1
			),
			'getRecipients' => array(
				'len' => 1
			),
			'sendVXU' => array(
				'len' => 1
			)
		)
	),
	'Encryption' => array(
		'methods' => array(
			'Encrypt' => array(
				'len' => 1
			),
			'Decrypt' => array(
				'len' => 1
			)
		)
	),
	'Test' => array(
		'methods' => array(
			't1' => array(
				'len' => 0
			),
			't2' => array(
				'len' => 1
			)
		)
	)
);
