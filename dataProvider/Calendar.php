<?php
/**
 *GaiaEHR (Electronic Health Records)
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

include_once(dirname(__FILE__) . '/Person.php');
include_once(dirname(__FILE__) . '/../classes/Time.php');

class Calendar {
	/**
	 * @var MatchaHelper
	 */
	private $db;
	/**
	 * @var MatchaCUP
	 */
	private $u = null;

	/**
	 * Creates the MatchaHelper instance
	 */
	function __construct(){
		$this->db = new MatchaHelper();
		return;
	}

	/**
	 * MATCHA CUPs (Sencha Models)
	 */
	private function setPatientModel(){
		if($this->u == null)
			$this->u = MatchaModel::setSenchaModel('App.model.administration.User');
	}

	/**
	 *
	 * getCalendars function
	 * Calendars = Providers or Users configured to be in the calendar
	 *
	 * @return array
	 */
	public function getCalendars(){
		$this->setPatientModel();
		$color = -4;
		$rows = array();
		foreach($this->u->load(array('calendar' => 1, 'active' => 1))->all() as $row){
			if($color > 32)
				$color = $color - 30;
			$color = $color + 5;
			$cla_user = array();
			$cla_user['id'] = $row['id'];
			$cla_user['title'] = $row['title'] . ' ' . $row['lname'];
			$cla_user['color'] = strval($color);
			array_push($rows, $cla_user);
		}
		return $rows;

	}

	/**
	 * Events are the patient appointments
	 *
	 * @param stdClass $params
	 * @return array
	 */
	public function getEvents(stdClass $params){

		$sql = ("SELECT * FROM calendar_events WHERE start BETWEEN '" . $params->startDate . " 00:00:00' AND '" . $params->endDate . " 23:59:59' ");
		$this->db->setSQL($sql);
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row){
			$row['id'] = intval($row['id']);
			$row['calendarId'] = intval($row['user_id']);
			$row['category'] = intval($row['category']);
			$row['facility'] = intval($row['facility']);
			$row['billing_facility'] = intval($row['billing_facillity']);
			$row['patient_id'] = intval($row['patient_id']);

			$sql = ("SELECT * FROM patient WHERE pid= '" . $row['patient_id'] . "'");
			$this->db->setSQL($sql);
			foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $urow){
				$row['title'] = Person::fullname($urow['fname'], $urow['mname'], $urow['lname']);
			}
			array_push($rows, $row);
		}
		//print_r(json_encode(array('success'=>true, 'message'=>'Loaded data',
		// 'data'=>$rows)));    }
		return array('success' => true, 'message' => 'Loaded data', 'data' => $rows);
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function addEvent(stdClass $params){
		$row = array();
		$row['user_id'] = $params->calendarId;
		$row['category'] = $params->category;
		$row['facility'] = $params->facility;
		$row['billing_facillity'] = $params->billing_facility;
		$row['patient_id'] = $params->patient_id;
		$row['title'] = $params->title;
		$row['status'] = $params->status;
		$row['start'] = $params->start;
		$row['end'] = $params->end;
		$row['rrule'] = $params->rrule;
		$row['loc'] = $params->loc;
		$row['notes'] = $params->notes;
		$row['url'] = $params->url;
		$row['ad'] = $params->ad;

		$this->db->setSQL($this->db->sqlBind($row, 'calendar_events', 'I'));
		$this->db->execLog();

		return array('success' => true, 'message' => 'Loaded data', 'data' => $params);
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function updateEvent(stdClass $params){

		$row['user_id'] = $params->calendarId;
		$row['category'] = $params->category;
		$row['facility'] = $params->facility;
		$row['billing_facillity'] = $params->billing_facility;
		$row['patient_id'] = $params->patient_id;
		$row['title'] = $params->title;
		$row['status'] = $params->status;
		$row['start'] = $params->start;
		$row['end'] = $params->end;
		$row['rrule'] = $params->rrule;
		$row['loc'] = $params->loc;
		$row['notes'] = $params->notes;
		$row['url'] = $params->url;
		$row['ad'] = $params->ad;

		$this->db->setSQL($this->db->sqlBind($row, 'calendar_events', 'U', array('id' => $params->id)));
		$this->db->execLog();
		return array('success' => true);
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function deleteEvent(stdClass $params){
		$this->db->setSQL("DELETE FROM calendar_events WHERE id='$params->id'");
		$this->db->execLog();
		return array('success' => true);
	}

	public function getPatientFutureEvents(stdClass $params){
		return $this->getPatientFutureEventsByPid($params->pid);
	}

	public function getPatientFutureEventsByPid($pid){
		$date = Time::getLocalTime();
		$tomorrow = date('Y-m-d 0000:00:00', strtotime($date . ' + 1 days'));
		$this->db->setSQL("SELECT * FROM calendar_events WHERE patient_id = '$pid' AND start >= '$tomorrow'");
		return $this->db->fetchRecords(PDO::FETCH_ASSOC);
	}

}
