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

Ext.define('App.store.administration.Services',
{
	model : 'App.model.administration.Services',
	extend : 'Ext.data.Store',
	proxy :
	{
		type : 'direct',
		api :
		{
			read : DataManager.getServices,
			create : DataManager.addService,
			update : DataManager.updateService
		},
		reader :
		{
			totalProperty : 'totals',
			root : 'rows'
		},
		extraParams :
		{
			code_type : this.code_type,
			query : this.query,
			active : this.active
		}
	},
	autoSync : true,
	remoteSort : true,
	autoLoad : false
}); 