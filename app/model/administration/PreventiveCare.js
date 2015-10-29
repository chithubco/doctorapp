/**
 GaiaEHR (Electronic Health Records)
 Copyright (C) 2013 Certun, LLC.

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.define('App.model.administration.PreventiveCare', {
	extend: 'Ext.data.Model',
	table: {
		name: 'preventivecare',
		comment: 'Preventive Care'
	},
	fields: [
		{name: 'id', type: 'int'},
		{name: 'pid', type: 'int'},
		{name: 'preventive_care_id', type: 'int'},
		{name: 'uid', type: 'int'},
		{name: 'description', type: 'string'},
		{name: 'age_start', type: 'string'},
		{name: 'age_end', type: 'string'},
		{name: 'sex', type: 'string'},
		{name: 'pregnant', type: 'bool'},
		{name: 'frequency', type: 'string'},
		{name: 'category_id', type: 'string'},
		{name: 'code', type: 'string'},
		{name: 'coding_system', type: 'string'},
		{name: 'dismiss', type: 'bool'},
		{name: 'frequency_type', type: 'string'},
		{name: 'reason', type: 'string'},
		{name: 'times_to_perform', type: 'string'},
		{name: 'doc_url1', type: 'string'},
		{name: 'doc_url2', type: 'string'},
		{name: 'doc_url3', type: 'string'},
		{name: 'active', type: 'bool'}
	]

});