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

include_once(dirname(dirname(__FILE__)) . '/classes/Time.php');
include_once(dirname(__FILE__) . '/Person.php');
include_once(dirname(__FILE__) . '/User.php');
include_once(dirname(__FILE__) . '/ACL.php');

class Patient {
	/**
	 * @var MatchaHelper
	 */
	private $db;
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var
	 */
	private $patient = null;

	/**
	 * @var MatchaCUP
	 */
	private $p = null;
	/**
	 * @var MatchaCUP
	 */
	private $i = null;
	/**
	 * @var MatchaCUP
	 */
	private $d = null;
	/**
	 * @var MatchaCUP
	 */
	private $c = null;

	/**
	 * @var PoolArea
	 */
	//private $poolArea;
	function __construct($pid = null){
		$this->db = new MatchaHelper();
		$this->user = new User();
		$this->acl = new ACL();

		$this->setPatient($pid);
		return;
	}

	/**
	 * MATCHA CUPs (Sencha Models)
	 */
	private function setPatientModel(){
		if($this->p == null)
			$this->p = MatchaModel::setSenchaModel('App.model.patient.Patient');
	}

	private function setInsuranceModels(){
		if($this->i == null)
			$this->i = MatchaModel::setSenchaModel('App.model.patient.Insurance');
	}

	private function setDocumentModel(){
		if($this->d == null)
			$this->d = MatchaModel::setSenchaModel('App.model.patient.PatientDocuments');
	}

	private function setChartCheckoutModel(){
		if($this->c == null)
			$this->c = MatchaModel::setSenchaModel('App.model.patient.PatientChartCheckOut');
	}

	/**
	 * @param stdClass $params
	 * @return mixed
	 */
	public function getPatients(stdClass $params){
		$this->setPatientModel();
		return $this->p->load($params)->all();
	}

	/**
	 * @param stdClass $params
	 * @return mixed
	 */
	public function savePatient($params){
		$this->setPatientModel();
		$fullName = Person::fullname($params->fname, $params->mname, $params->lname);
		$params->qrcode = $this->createPatientQrCode($this->patient['pid'], $fullName);
		$this->patient = $this->p->save($params);
		$this->patient['fullname'] = $fullName;
		$this->createPatientDir($this->patient['pid']);
		return $this->patient;
	}

	/**
	 * @param stdClass $params
	 * @return mixed
	 */
	public function getInsurances(stdClass $params){
		$this->setInsuranceModels();
		return $this->i->load($params)->all();
	}

	/**
	 * @param stdClass $params
	 * @return mixed
	 */
	public function saveInsurance($params){
		$this->setInsuranceModels();
		return $this->i->save($params);
	}

	/**
	 * @param $pid
	 * @return mixed
	 */
	protected function setPatient($pid){
		if($pid != null && ($this->patient == null || $this->patient != $pid)){
			$this->setPatientModel();
			$this->patient = $this->p->load($pid)->one();
			$this->patient['pic'] = $this->patient['image'];
			$this->patient['age'] = $this->getPatientAge();
			//            $_SESSION['patient']['pid']  = $this->patient['pid'];
			//            $_SESSION['patient']['name'] = $this->getPatientFullName();
		}
	}

	/**
	 * @param $pid
	 * @return mixed
	 */
	public function unsetPatient($pid){
		if($pid != null)
			$this->patientChartInByPid($pid);
		//        $_SESSION['patient']['pid']  = null;
		//        $_SESSION['patient']['name'] = null;
		return;
	}

	/**
	 * @param $pid
	 * @return array
	 */
	public function getPatientDemographicDataByPid($pid){
		$this->setPatient($pid);
		return $this->patient;
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function getPatientDemographicData(stdClass $params){
		return $this->setPatient($params->pid);
	}

	/**
	 * @param $name
	 * @return array
	 */
	public function createNewPatientOnlyName($name){
		$params = new stdClass();
		$foo = explode(' ', $name);
		$params->fname = trim($foo[0]);
		$params->mname = '';
		$params->lname = '';
		if(count($foo) == 2){
			$params->lname = trim($foo[1]);
		} elseif(count($foo) >= 3){
			$params->mname = (isset($foo[1])) ? trim($foo[1]) : '';
			unset($foo[0], $foo[1]);
			$params->lname = '';
			foreach($foo as $fo){
				$params->lname .= $params->lname . ' ' . $fo . ' ';
			}
			$params->lname = trim($params->lname);
		}
		$params->create_uid = $_SESSION['user']['id'];
		$params->create_uid = $_SESSION['user']['id'];
		$params->create_date = Time::getLocalTime();
		$params->update_date = Time::getLocalTime();
		$patient = $this->savePatient($params);
		return array('success' => true, 'patient' => array('pid' => $patient['pid'], 'fullname' => $patient['fullname']));
	}

	/**
	 * @param stdClass $params
	 * @return mixed
	 */
	public function createNewPatient(stdClass $params){
		return $this->savePatient($params);
	}

	/**
	 * @param $pid int patient to set
	 * @internal param $pid
	 * @return mixed
	 */
	public function getPatientSetDataByPid($pid){

		include_once(dirname(__FILE__) . '/PoolArea.php');
		$this->setPatient($pid);
		$poolArea = new PoolArea();

		$area = $poolArea->getCurrentPatientPoolAreaByPid($this->patient['pid']);
		$chart = $this->patientChartOutByPid($this->patient['pid'], $area['area_id']);

		return array('patient' => array('pid' => $this->patient['pid'], 'name' => $this->getPatientFullName(), 'pic' => $this->patient['image'], 'sex' => $this->getPatientSex(), 'dob' => $this->getPatientDOB(), 'age' => $this->getPatientAge(), 'area' => $area['poolArea'], 'priority' => (empty($area) ? null : $area['priority']), 'rating' => (isset($this->patient['rating']) ? $this->patient['rating'] : 0)), 'chart' => array('readOnly' => $chart['read_only'] == '1', 'overrideReadOnly' => $this->acl->hasPermission('override_readonly'), 'outUser' => isset($chart['outChart']['uid']) ? $this->user->getUserFullNameById($chart['outChart']['uid']) : 0, 'outArea' => isset($chart['outChart']['pool_area_id']) ? $poolArea->getAreaTitleById($chart['outChart']['pool_area_id']) : 0,));
	}

	/**
	 * @return array
	 */
	public function getPatientAge(){
		return $this->getPatientAgeByDOB($this->patient['DOB']);
	}

	/**
	 * @param $dob
	 * @internal param $birthday
	 * @return array
	 */
	public function getPatientAgeByDOB($dob){
		if($this->patient['DOB'] != '0000-00-00 00:00:00'){
			$today = new DateTime(date('Y-m-d'));
			$t = new DateTime(date($dob));
			$age['days'] = $t->diff($today)->d;
			$age['months'] = $t->diff($today)->m;
			$age['years'] = $t->diff($today)->y;
			if($age['years'] >= 2){
				$ageStr = $age['years'] . ' yr(s)';
			} else{
				if($age['years'] >= 1){
					$ageStr = 12 + $age['months'] . ' mo(s)';
				} else{
					if($age['months'] >= 1){
						$ageStr = $age['months'] . ' mo(s) and ' . $age['days'] . ' day(s)';
					} else{
						$ageStr = $age['days'] . ' day(s)';
					}
				}
			}
			return array('DMY' => $age, 'str' => $ageStr);
		} else{
			return array('DMY' => array('years' => 0, 'months' => 0, 'days' => 0), 'str' => '<span style="color:red">Age</span>');
		}
	}

	/**
	 * @param stdClass $params
	 * @return object
	 */
	public function setPatientRating(stdClass $params){
		$this->setPatientModel();
		return $this->p->save($params);
	}

	public function createPatientQrCode($pid, $fullname){
		$data = '{"name":"' . $fullname . '","pid":' . $pid . ',"ehr": "GaiaEHR"}';
		include($_SESSION['root'] . '/lib/phpqrcode/qrlib.php');
		ob_start();
		QRCode::png($data, false, 'Q', 2, 2);
		$imageString = base64_encode(ob_get_contents());
		ob_end_clean();
		return 'data:image/jpeg;base64,'.$imageString;
	}

	/**
	 * @return string
	 */
	public function getPatientFullName(){
		return Person::fullname($this->patient['fname'], $this->patient['mname'], $this->patient['lname']);
	}

	/**
	 * @param $pid
	 * @return string
	 */
	public function getPatientFullNameByPid($pid){
		$this->db->setSQL("SELECT fname,mname,lname FROM patient WHERE pid = '$pid'");
		$p = $this->db->fetchRecord();
		return Person::fullname($p['fname'], $p['mname'], $p['lname']);
	}

	/**
	 * @param $pid
	 * @return string
	 */
	public function getPatientFullAddressByPid($pid){
		$this->db->setSQL("SELECT address,city,state,zipcode FROM patient WHERE pid = '$pid'");
		$p = $this->db->fetchRecord();
		return Person::fulladdress($p['address'], null, $p['city'], $p['state'], $p['zipcode']);
	}

	/**
	 * @param \stdClass $params
	 * @internal param $search
	 * @internal param $start
	 * @internal param $limit
	 * @return array
	 * @TODO: The search must be case-insensitive
	 */
	public function patientLiveSearch(stdClass $params){
		$this->db->setSQL("SELECT pid,pubpid,fname,lname,mname,DOB,SS
                             FROM patient
                            WHERE fname  LIKE '$params->query%'
                               OR lname  LIKE '$params->query%'
                               OR mname  LIKE '$params->query%'
                               OR pubpid LIKE '$params->query%'
                               OR pid 	 LIKE '$params->query%'
                               OR SS 	 LIKE '%$params->query'");
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_CLASS) as $row){
			$row->fullname = Person::fullname($row->fname, $row->mname, $row->lname);
			unset($row->fname, $row->mname, $row->lname);
			array_push($rows, $row);
		}
		$total = count($rows);
		$rows = array_slice($rows, $params->start, $params->limit);
		return array('totals' => $total, 'rows' => $rows);
	}

	private function createPatientDir($pid){
		$path = $_SESSION['site']['path'] . '/patients/' . $pid;
		if(!file_exists($path)){
			if(mkdir($path, 0777, true)){
				chmod($path, 0777);
				return true;
			} else{
				return false;
			}
		} else{
			return true;
		}
	}

	//    public function createDefaultPhotoId($pid)
	//    {
	//        $newImg = $_SESSION['site']['path'] . '/patients/' . $pid . '/patientPhotoId.jpg';
	//        copy($_SESSION['root'] . '/resources/images/icons/patientPhotoId.jpg', $newImg);
	//        return;
	//    }

	public function getPatientAddressById($pid){
		$this->db->setSQL("SELECT * FROM patient WHERE pid = '$pid'");
		$p = $this->db->fetchRecord();
		$address = $p['address'] . ' <br>' . $p['city'] . ',  ' . $p['state'] . ' ' . $p['country'];
		return $address;
	}

	public function getPatientArrivalLogWarningByPid($pid){
		$this->db->setSQL("SELECT pid
							 FROM patient
							WHERE pid = '$pid'
							  AND (sex IS NULL
							  OR DOB IS NULL)");
		$alert = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return !empty($alert);
	}

	public function addPatientNoteAndReminder(stdClass $params){
		$data = get_object_vars($params);
		unset($data['id'], $data['message']);
		$data2 = $data;
		$data['body'] = $data['new_reminder'];
		$data2['body'] = $data['new_note'];
		unset($data['new_note'], $data['new_reminder'], $data2['new_note'], $data2['new_reminder']);
		$this->db->setSQL($this->db->sqlBind($data2, 'patient_reminders', 'I'));
		$this->db->execLog();
		$this->db->setSQL($this->db->sqlBind($data, 'patient_notes', 'I'));
		$this->db->execLog();
		if($this->db->lastInsertId == 0){
			return array('success' => false);
		} else{
			return array('success' => true);
		}
	}

	public function addPatientNotes(stdClass $params){
		unset($params->id);
		$data = get_object_vars($params);
		unset($data['user_name']);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_notes', 'I'));
		$this->db->execLog();
		$params->id = $this->db->lastInsertId;
		$params->user_name = $this->user->getUserNameById($params->uid);
		return $params;
	}

	public function addPatientReminders(stdClass $params){
		unset($params->id);
		$data = get_object_vars($params);
		unset($data['user_name']);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_reminders', 'I'));
		$this->db->execLog();
		$params->id = $this->db->lastInsertId;
		$params->user_name = $this->user->getUserNameById($params->uid);
		return $params;
	}

	public function updatePatientNotes(stdClass $params){
		$data = get_object_vars($params);
		unset($data['id'], $data['user_name']);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_notes', 'U', array('id' => $params->id)));
		$this->db->execLog();
		return $params;
	}

	public function updatePatientReminders(stdClass $params){
		$data = get_object_vars($params);
		unset($data['id'], $data['user_name']);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_reminders', 'U', array('id' => $params->id)));
		$this->db->execLog();
		return $params;

	}

	public function getPatientNotes(stdClass $params){
		$reminders = array();
		$this->db->setSQL("SELECT * FROM patient_notes WHERE pid = '$params->pid'");
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row){
			$row['user_name'] = $this->user->getUserNameById($row['uid']);
			$reminders[] = $row;
		}
		return $reminders;
	}

	public function getPatientReminders(stdClass $params){
		$reminders = array();
		$this->db->setSQL("SELECT * FROM patient_reminders WHERE pid = '$params->pid'");
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row){
			$row['user_name'] = $this->user->getUserNameById($row['uid']);
			$reminders[] = $row;
		}
		return $reminders;
	}

	///////////////////////////////////////////////////////
	public function getDOBByPid($pid){
		$this->db->setSQL("SELECT DOB FROM patient WHERE pid = '$pid'");
		$p = $this->db->fetchRecord();
		return $p['DOB'];
	}

	public function getPatientDOB(){
		return $this->patient['DOB'];
	}

	public function getPatientDOBByPid($pid){
		$this->db->setSQL("SELECT DOB
                           FROM patient
                           WHERE pid ='$pid'");
		$patient = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return $patient['DOB'];
	}

	public function getPatientAgeByPid($pid){
		$this->db->setSQL("SELECT DOB FROM patient WHERE pid ='$pid'");
		$p = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return $this->getPatientAgeByDOB($p['DOB']);
	}

	/**
	 * @return array
	 */
	public function getPatientSex(){
		return $this->patient['sex'];
	}

	/**
	 * @param $pid
	 * @return array
	 */
	public function getPatientSexByPid($pid){
		$this->db->setSQL("SELECT sex
                           FROM patient
                           WHERE pid ='$pid'");
		$p = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return $p['sex'];
	}

	public function getPatientSexIntByPid($pid){
		return (strtolower($this->getPatientSexByPid($pid)) == 'female' ? 1 : 2);
	}

	public function getPatientPregnantStatusByPid($pid){
		$this->db->setSQL("SELECT * FROM encounters WHERE pid ='$pid' ORDER BY eid desc ");
		$p = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return $p['review_pregnant'];
	}

	public function getPatientActiveProblemsById($pid, $tablexx, $columnName){
		$this->db->setSQL("SELECT $columnName FROM $tablexx WHERE pid ='$pid'");
		$records = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $rec){
			if(!isset($rec['end_date']) || $rec['end_date'] != null || $rec['end_date'] != '0000-00-00 00:00:00'){
				$records[] = $rec;
			}
		}
		return $records;
	}

	public function getPatientDocuments(stdClass $params){
		$this->setDocumentModel();
		$docs = $this->d->load($params)->all();
		if(isset($docs['data'])){
			foreach($docs['data'] AS $index => $row){
				$docs['data'][$index]['user_name'] = $this->user->getUserNameById($row['uid']);
			}
		}
		return $docs;
	}

	public function getPatientInsurancesCardsUrlByPid($pid){
		$records = array();
		$this->db->setSQL("SELECT url
                           FROM patient_documents
                           WHERE pid='$pid'
                           AND  docType='Primary Insurance'
                           ORDER BY id DESC");
		$records['Primary'] = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$this->db->setSQL("SELECT url
                           FROM patient_documents
                           WHERE pid='$pid'
                           AND  docType='Secondary Insurance'
                           ORDER BY id DESC");
		$records['Secondary'] = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$this->db->setSQL("SELECT url
                           FROM patient_documents
                           WHERE pid='$pid'
                           AND  docType='Tertiary Insurance'
                           ORDER BY id DESC");
		$records['Tertiary'] = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return $records;
	}

	public function getMeaningfulUserAlertByPid(stdClass $params){
		$record = array();
		$this->db->setSQL("SELECT `language`,
                                  race,
                                  ethnicity,
                                  fname,
                                  lname,
                                  sex,
                                  DOB
                           FROM patient
                           WHERE pid = '$params->pid'");
		$patientdata = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		foreach($patientdata as $key => $val){
			$val = ($val == null || $val == '') ? false : true;
			$record[] = array('name' => $key, 'val' => $val);
		}
		return $record;
	}

	public function addPatientNoteByPid($pid, $body, $eid = null){
		$data['pid'] = $pid;
		$data['uid'] = $_SESSION['user']['id'];
		$data['date'] = Time::getLocalTime();
		$data['body'] = $body;
		$data['eid'] = $eid;
		$this->db->setSQL($this->db->sqlBind($data, 'patient_notes', 'I'));
		$this->db->execLog();
		return;
	}

	public function addPatientReminderByPid($pid, $body, $eid = null){
		$data['pid'] = $pid;
		$data['uid'] = $_SESSION['user']['id'];
		$data['date'] = Time::getLocalTime();
		$data['body'] = $body;
		$data['eid'] = $eid;
		$this->db->setSQL($this->db->sqlBind($data, 'patient_reminders', 'I'));
		$this->db->execLog();
		return;
	}

	public function getPatientPhotoSrc(){
		return $this->patient['image'];
	}

	public function getPatientPhotoSrcIdByPid($pid){
		$this->setPatientModel();
		$patient = $this->p->load($pid)->one();
		return $patient['image'];
	}

	//******************************************************************************************************************
	// patient charts
	//******************************************************************************************************************
	public function patientChartOutByPid($pid, $pool_area_id){
		$this->setChartCheckoutModel();
		$outChart = $this->isPatientChartOutByPid($pid);
		$data['pid'] = $pid;
		$data['uid'] = $_SESSION['user']['id'];
		$data['chart_out_time'] = Time::getLocalTime();
		$data['pool_area_id'] = $pool_area_id;
		$data['read_only'] = $outChart === false ? '0' : '1';
		$this->db->setSQL($this->db->sqlBind($data, 'patient_chart_checkout', 'I'));
		$this->db->execLog();
		$data['outChart'] = $outChart;
		return $data;
	}

	public function patientChartInByPid($pid){
		$this->setChartCheckoutModel();
		$chart_in_time = Time::getLocalTime();
		$this->db->setSQL("UPDATE patient_chart_checkout
								  SET chart_in_time = '$chart_in_time'
								WHERE pid = '$pid'
								  AND uid =  {$_SESSION['user']['id']}
								  AND chart_in_time IS NULL");
		$this->db->execLog();
	}

	public function patientChartInByUserId($uid){
		$this->setChartCheckoutModel();
		$chart_in_time = Time::getLocalTime();
		$this->db->setSQL("UPDATE patient_chart_checkout SET chart_in_time = '$chart_in_time' WHERE uid = '$uid' AND chart_in_time IS NULL");
		$this->db->execLog();
	}

	public function isPatientChartOutByPid($pid){
		$this->setChartCheckoutModel();
		$this->db->setSQL("SELECT id, uid, pool_area_id FROM patient_chart_checkout WHERE pid = '$pid' AND chart_in_time IS NULL");
		$chart = $this->db->fetchRecord();
		if(empty($chart)){
			return false;
		} else{
			return $chart;
		}
	}

	//**************************************************************************************************
	// Disclosures
	//**************************************************************************************************
	public function getPatientDisclosures(stdClass $params){
		$this->db->setSQL("SELECT * FROM patient_disclosures WHERE pid = '$params->pid'");
		return $this->db->fetchRecords();
	}

	public function createPatientDisclosure(stdClass $params){
		unset($params->id);
		$params->active = 1;
		$data = get_object_vars($params);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_disclosures', 'I'));
		$this->db->execLog();
		$params->id = $this->db->lastInsertId;
		return $params;
	}

	public function updatePatientDisclosure(stdClass $params){
		$data = get_object_vars($params);
		unset($data['id']);
		$this->db->setSQL($this->db->sqlBind($data, 'patient_disclosures', 'U', array('id' => $params->id)));
		$this->db->execLog();
		return $params;
	}


	//**************************************************************************************************
	// Insurance
	//**************************************************************************************************
	public function getPatientPrimaryInsuranceByPid($pid){
		$this->db->setSQL("SELECT * FROM patient_insurances WHERE pid = '$pid' AND type = '1' ORDER BY subscriberDob ASC");
		$rec = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		if(!empty($rec)){
			return $rec;
		} else{
			return false;
		}
	}

	public function getPatientSecondaryInsuranceByPid($pid){
		$this->db->setSQL("SELECT * FROM patient_insurances WHERE pid = '$pid' AND type = '1' ORDER BY subscriberDob DESC");
		$rec = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		if(!empty($rec)){
			return $rec;
		} else{
			return false;
		}
	}

	public function getPatientTertiaryInsuranceByPid($pid){
		$this->db->setSQL("SELECT * FROM patient_insurances WHERE pid = '$pid' AND type = '2' ORDER BY subscriberDob DESC");
		$rec = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		if(!empty($rec)){
			return $rec;
		} else{
			return false;
		}
	}

}

//$p = new Patient();
//print '<pre>';
//print_r($p->getPatientTertiaryInsuranceByPid(1));
//print $p->getPatientAppointmentsByPid(1);
