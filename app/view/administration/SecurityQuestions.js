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

Ext.define('App.view.administration.SecurityQuestions', {
    extend: 'App.ux.RenderPanel',
    id: 'panelSecurityQuestions',
    pageTitle: 'Security Questions',
    uses: ['App.ux.GridPanel', 'App.ux.window.Window'],
    initComponent: function(){
        var me = this;
        // *************************************************************************************
        // My Security Questions Data Store
        // *************************************************************************************
        me.securityStore = Ext.create('App.store.chithub.securityquestions');

        // *************************************************************************************
        // Security Questions Grid Panel
        // *************************************************************************************
        me.SecurityGrid = Ext.create('Ext.grid.Panel', {
            store: me.securityStore,
            columns: [
                {
                    text: 'Security Question',
                    flex: 1,
                    sortable: true,
                    dataIndex: 'question'
                }
            ],
            plugins: Ext.create('App.ux.grid.RowFormEditing', {
                autoCancel: false,
                errorSummary: false,
                clicksToEdit: 1,
                formItems: [
                    {
                        xtype: 'container',
                        layout: 'column',
                        defaults: {
                            xtype: 'container',
                            columnWidth: 0.5,
                            padding: 5,
                            layout: 'anchor',
                            defaultType: 'textfield'
                        },
                        items: [
                            {
                                defaults: {
                                    anchor: '100%'
                                },
                                items: [
                                    {
                                        fieldLabel: 'Security Question',
                                        name: 'question',
                                        allowBlank: false
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }),
            tbar: Ext.create('Ext.PagingToolbar', {
                pageSize: 30,
                store: me.securityStore,
                displayInfo: true,
                plugins: Ext.create('Ext.ux.SlidingPager', {
                    }),
                items: ['-', {
                    text: 'Add New Question',
                    iconCls: 'save',
                    scope: me,
                    handler: me.addQuestion
                }]

            })
        });
        me.pageBody = [me.SecurityGrid];
        me.callParent(arguments);
    },

    addQuestion: function(){
        var me = this,
	        grid = me.SecurityGrid,
	        store = grid.store;

	    grid.editingPlugin.cancelEdit();
        store.insert(0, {
        });
        grid.editingPlugin.startEdit(0, 0);
    },

    /**
     * This function is called from Viewport.js when
     * this panel is selected in the navigation panel.
     * place inside this function all the functions you want
     * to call every this panel becomes active
     */
    onActive: function(callback){
        this.securityStore.load();
        callback(true);
    }
});
