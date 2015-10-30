<?php
/**
 * GaiaEHR (Electronic Health Records)
 * Copyright (C) 2012 Ernesto Rodriguez
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


class Question {
	/**
	 * @var MatchaHelper
	 */
	private $db;
	function __construct(){
		$this->db = new MatchaHelper();

		return;
	}

	/*********************************************
	 * METHODS USED BY SENCHA                    *
	 *********************************************/
	/**
	 * @return mixed
	 */
	/*************************************************************************************************************/

	/**
	 * @return array
	 */
	public function getQuestions(stdClass $params){
		$questions = array();

		$sql = "SELECT * FROM security_question";
		$this->db->setSQL($sql);

		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row){
			$questions[] = $row;
		}

		$total = count($questions);
		return array('totals' => $total, 'questions' => $questions);
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function addQuestion($params){
		$data = get_object_vars($params);

//		$this->db->setSQL($this->db->sqlBind($data, 'questions', 'U', array('question' => $params->question)));
//		$this->db->execLog();
//		return array('success' => true, 'data' => $data);
		return array("success" => true, 'question' => $params);
	}

	/**
	 * @param $params
	 * @return array
	 */
	public function updateQuestion($params){
		return array("success" => true, 'question' => $params);
	}

}

