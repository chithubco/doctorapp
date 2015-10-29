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

class ServiceCodes
{
	private $db;

	function __construct()
	{
		$this->db = new MatchaHelper();
		return;
	}

	/**
	 * CPT CODES SECTION!!!
	 */
	/**
	 * @param stdClass $params
	 * @return array|stdClass
	 */
	public function getCptCodes(stdClass $params)
	{
		if ($params->filter === 0)
		{
			$record = $this->getCptRelatedByEidIcds($params->eid);
		}
		elseif ($params->filter === 1)
		{
			$record = $this->getCptUsedByPid($params->pid);
		}
		elseif ($params->filter === 2)
		{
			$record = $this->getCptUsedByClinic($params->pid);
		}
		else
		{
			$record = $this->getCptByEid($params->eid);
		}
		return $record;
	}

	public function addCptCode(stdClass $params)
	{
		$data = get_object_vars($params);
		unset($data['code_text'], $data['code_text_medium']);
		foreach ($data as $key => $val)
		{
			if ($val == null || $val == '')
			{
				unset($data[$key]);
			}
		}
		$this->db->setSQL($this->db->sqlBind($data, 'encounter_services', 'I'));
		$this->db->execLog();
		$params->id = $this->db->lastInsertId;
		return array(
			'totals' => 1,
			'rows' => $params
		);
	}

	public function updateCptCode(stdClass $params)
	{
		$data = get_object_vars($params);
		unset($data['id'], $data['eid'], $data['code'], $data['code_text'], $data['code_text_medium']);
		$params->id = intval($params->id);
		$this->db->setSQL($this->db->sqlBind($data, 'encounter_services', 'U', "id='$params->id'"));
		$this->db->execLog();
		return array(
			'totals' => 1,
			'rows' => $params
		);
	}

	public function deleteCptCode(stdClass $params)
	{
		$this->db->setSQL("SELECT status FROM encounter_services WHERE id = '$params->id'");
		$cpt = $this->db->fetchRecord();
		if ($cpt['status'] == 0)
		{
			$this->db->setSQL("DELETE FROM encounter_services WHERE id ='$params->id'");
			$this->db->execLog();
		}
		return array(
			'totals' => 1,
			'rows' => $params
		);
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getCptRelatedByEidIcds($eid)
	{
		$this->db->setSQL("SELECT DISTINCT cpt.code, cpt.code_text
                             FROM cpt_codes as cpt
                       RIGHT JOIN cpt_icd as ci ON ci.cpt = cpt.code
                        LEFT JOIN encounter_dx as eci ON eci.code = ci.icd
                            WHERE eci.eid = '$eid'");
		$records = array();
		foreach ($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row)
		{
			if ($row['code'] != null || $row['code'] != '')
			{
				$records[] = $row;
			}
		}
		return array(
			'totals' => count($records),
			'rows' => $records
		);
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getCptByEid($eid)
	{
		$this->db->setSQL("SELECT DISTINCT ecc.*, cpt.code, cpt.code_text, cpt.code_text_medium, cpt.code_text_short
                             FROM encounter_services AS ecc
                        left JOIN cpt_codes AS cpt ON ecc.code = cpt.code
                            WHERE ecc.eid = '$eid' ORDER BY ecc.id ASC");
		$records = $this->db->fetchRecords(PDO::FETCH_ASSOC);
		return array(
			'totals' => count($records),
			'rows' => $records
		);
	}

	/**
	 * @param $pid
	 * @return array
	 */
	public function getCptUsedByPid($pid)
	{
		$this->db->setSQL("SELECT DISTINCT cpt.code, cpt.code_text, cpt.code_text_medium, cpt.code_text_short
                             FROM encounter_services AS ecc
                        left JOIN cpt_codes AS cpt ON ecc.code = cpt.code
                        LEFT JOIN encounters AS e ON ecc.eid = e.eid
                            WHERE e.pid = '$pid'
                         ORDER BY e.service_date DESC");
		$records = $this->db->fetchRecords(PDO::FETCH_ASSOC);
		return array(
			'totals' => count($records),
			'rows' => $records
		);
	}

	/**
	 * @return array
	 */
	public function getCptUsedByClinic()
	{
		$this->db->setSQL("SELECT DISTINCT cpt.code, cpt.code_text, cpt.code_text_medium, cpt.code_text_short
                             FROM encounter_services AS ecc
                        left JOIN cpt_codes AS cpt ON ecc.code = cpt.code
                         ORDER BY cpt.code DESC");
		$records = $this->db->fetchRecords(PDO::FETCH_ASSOC);
		return array(
			'totals' => count($records),
			'rows' => $records
		);
	}

	public function liveCodeSearch(stdClass $params)
	{
		/*
		 * define $code_table
		 */
		if ($params->code_type == 'cpt')
		{
			$code_table = 'cpt_codes';
		}
		else
		{
			$code_table = 'hcpcs_codes';
		}
		/**
		 * brake the $params->query coming form sencha using into an array using "commas"
		 * example:
		 * $params->query = '123.24, 123.4, 142.0, head skin '
		 * $Str = array(
		 *      [0] => 123.34,
		 *      [1] => 123.4,
		 *      [2] => 142.0,
		 *      [3] => 'head skin '
		 * )
		 */
		$Str = explode(',', $params->query);
		/**
		 * get the las value and trim white spaces
		 * $queryStr = 'head skin'
		 */
		$queryStr = trim(end(array_values($Str)));
		/**
		 * break the $queryStr into an array usin white spaces
		 * $queries = array(
		 *      [0] => 'head',
		 *      [1] => 'skin'
		 * )
		 */
		$queries = explode(' ', $queryStr);
		//////////////////////////////////////////////////////////////////////////////////
		////////////   NO TOCAR  /////////   NO TOCAR  /////////   NO TOCAR
		// /////////////
		//////////////////////////////////////////////////////////////////////////////////
		//        $sql = "SELECT * FROM codes WHERE ";
		//        foreach($queries as $query){
		//            $sql .= "(code_text LIKE '%$query%' OR code_text_short LIKE
		// '%$query%' OR code LIKE '$query%' OR related_code LIKE '$query%') AND ";
		//        }
		//        $sql .= "code_type = '2'";
		//
		//        //print $sql;
		//
		//        $this->db->setSQL($sql);
		//        $records = $this->db->fetchRecords(PDO::FETCH_ASSOC);
		///////////////////////////////////////////////////////////////////////////////////
		/**
		 * start empty array to store the records to return
		 */
		$records = array();
		/**
		 * start empty array to store the ids of the records already in $records
		 */
		$idHaystack = array();
		/**
		 * loop for every word in $queries
		 */
		foreach ($queries as $query)
		{
			$this->db->setSQL("SELECT *
                                 FROM $code_table
                                WHERE (code_text      LIKE '%$query%'
                                   OR code            LIKE '$query%')
                             ORDER BY code ASC");
			/**
			 * loop for each sql record as $row
			 */
			foreach ($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row)
			{
				/**
				 * if the id of the IDC9 code is in $idHaystack increase its ['weight'] by 1
				 */
				if (array_key_exists($row['id'], $idHaystack))
				{
					$records[$row['id']]['weight']++;
					/**
					 * else add the code ID to $idHaystack
					 * then add ['weight'] with a value of 1
					 * finally add the $row to $records
					 */
				}
				else
				{
					$idHaystack[$row['id']] = true;
					$row['weight'] = 1;
					$records[$row['id']] = $row;
				}
			}
		}
		function cmp($a, $b)
		{
			if ($a['weight'] === $b['weight'])
			{
				return 0;
			}
			else
			{
				return $a['weight'] < $b['weight'] ? 1 : -1;
				// reverse order
			}
		}

		usort($records, 'cmp');
		$total = count($records);
		$records = array_slice($records, $params->start, $params->limit);
		return array(
			'totals' => $total,
			'rows' => $records
		);
	}

	public function getServiceCodeByCodeAndCodeType($code, $codeType){
		$codeTable = $codeType == 'HCPCS' ? 'hcpcs_codes' : 'cpt_codes';
		$this->db->setSQL("SELECT * FROM $codeTable WHERE `code` = '$code' LIMIT 1");
		$record = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		return isset($record['code_text']) ? $record['code_text'] : '';
	}

}
