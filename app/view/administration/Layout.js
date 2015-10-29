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

Ext.define('App.view.administration.Layout', {
    extend: 'App.ux.RenderPanel',
    id: 'panelLayout',
    pageTitle: i18n('layout_form_editor'),
    pageLayout: 'border',
    initComponent: function(){
        var me = this;

        me.currForm = null;
        me.currField = null;

	    /**
	     *
	     * @type {App.store.administration.LayoutTree}
	     */
        me.fieldsGridStore = Ext.create('App.store.administration.LayoutTree');

        /**
         * Xtype Combobox store
         */
        me.fieldXTypesStore = Ext.create('App.store.administration.XtypesComboModel');

        /**
         * Forms grid store (left grid)
         */
        me.formsGridStore = Ext.create('App.store.administration.FormsList');

        /**
         * Field available on this form as parent items (fieldset / fieldcontainer )
         * use to get the "Child of" combobox data
         */
        me.parentFieldsStore = Ext.create('App.store.administration.ParentFields');

        /**
         * This are the select lists available to use for comboboxes
         * this lists can be created an modified at "Lists" administration panel.
         */
        me.selectListoptionsStore = Ext.create('App.store.administration.FormListOptions');

        /**
         * This grid only available if the field is a Combobox
         */
        me.selectListGrid = Ext.create('Ext.grid.Panel', {
            store: me.selectListoptionsStore,
            collapseMode: 'mini',
            height:200,
            split: true,
            border: false,
            titleCollapse: false,
            hideCollapseTool: true,
            collapsible: true,
            collapsed: true,
            columns: [
                {
                    text: i18n('name'),
                    flex: 1,
                    sortable: false,
                    dataIndex: 'option_name'
                },
                {
                    text: i18n('value'),
                    flex: 1,
                    sortable: false,
                    dataIndex: 'option_value'
                }
            ]
        });

        /**
         * form to create and modified the fields
         */
        me.fieldForm = Ext.create('Ext.form.Panel', {
            flex:2,
            border: false,
            autoScroll: true,
            fieldDefaults: {
                msgTarget: 'side',
                labelWidth: 100
            },
            defaults: {
                anchor: '100%'
            },
            items: [
                {
                    fieldLabel: i18n('type'),
                    xtype: 'combo',
                    name: 'xtype',
                    displayField: 'name',
                    valueField: 'value',
                    allowBlank: false,
                    editable: false,
                    store: me.fieldXTypesStore,
                    queryMode: 'local',
                    margin: '5 5 5 10',
                    itemId: 'xtype',
                    listeners: {
                        scope: me,
                        change: me.onXtypeChange
                    }
                },
                {
                    fieldLabel: i18n('child_of'),
                    xtype: 'combo',
                    name: 'parentId',
                    displayField: 'name',
                    valueField: 'value',
                    editable: false,
                    hideTrigger: true,
	                allowBlank: false,
                    store: me.parentFieldsStore,
                    queryMode: 'local',
                    margin: '5 5 5 10',
                    emptyText: 'None',
                    itemId: 'parentFields',
                    listeners: {
                        scope: me,
                        expand: me.onParentFieldsExpand
                    }
                },
                {
                    xtype: 'fieldset',
                    itemId: 'aditionalProperties',
                    title: i18n('aditional_properties'),
                    margin: '0 5 5 5',
                    defaults: {
                        anchor: '100%'
                    },
                    items: [
                        {
                            fieldLabel: i18n('title'),
                            xtype: 'textfield',
                            name: 'title',
                            itemId: 'title',
                            allowBlank: false,
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('field_label'),
                            xtype: 'textfield',
                            name: 'fieldLabel',
                            itemId: 'fieldLabel',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('box_label'),
                            xtype: 'textfield',
                            name: 'boxLabel',
                            itemId: 'boxLabel',
                            allowBlank: false,
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('label_width'),
                            xtype: 'textfield',
                            name: 'labelWidth',
                            itemId: 'labelWidth',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('hide_label'),
                            xtype: 'checkbox',
                            name: 'hideLabel',
                            itemId: 'hideLabel',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('empty_text'),
                            xtype: 'textfield',
                            name: 'emptyText',
                            itemId: 'emptyText',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('layout'),
                            xtype: 'textfield',
                            name: 'layout',
                            itemId: 'layout',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('name'),
                            xtype: 'textfield',
                            name: 'name',
                            itemId: 'name',
                            allowBlank: false,
                            hidden: true,
	                        listeners:{
		                        scope:me,
		                        change: me.onNameValueChange
	                        }
                        },
                        {
                            fieldLabel: i18n('input_value'),
                            xtype: 'textfield',
                            name: 'inputValue',
                            itemId: 'inputValue',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('width'),
                            xtype: 'textfield',
                            name: 'width',
                            itemId: 'width',
                            emptyText: 'ei. 5 for 5px',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('height'),
                            xtype: 'textfield',
                            name: 'height',
                            itemId: 'height',
                            emptyText: 'ei. 5 for 5px',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('anchor'),
                            xtype: 'textfield',
                            name: 'anchor',
                            itemId: 'anchor',
                            emptyText: 'ei. 100%',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('flex'),
                            xtype: 'checkbox',
                            name: 'flex',
                            itemId: 'flex',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('collapsible'),
                            xtype: 'checkbox',
                            name: 'collapsible',
                            itemId: 'collapsible',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('checkbox_toggle'),
                            xtype: 'checkbox',
                            name: 'checkboxToggle',
                            itemId: 'checkboxToggle',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('collapsed'),
                            xtype: 'checkbox',
                            name: 'collapsed',
                            itemId: 'collapsed',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('margin'),
                            xtype: 'textfield',
                            name: 'margin',
                            itemId: 'margin',
                            emptyText: 'ei. 5 5 5 5',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('column_width'),
                            xtype: 'textfield',
                            name: 'columnWidth',
                            itemId: 'columnWidth',
                            emptyText: 'ei. .5',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('is_required'),
                            xtype: 'checkbox',
                            name: 'allowBlank',
                            itemId: 'allowBlank',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('value'),
                            xtype: 'textfield',
                            name: 'value',
                            itemId: 'value',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('max_value'),
                            xtype: 'textfield',
                            name: 'maxValue',
                            itemId: 'maxValue',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('min_value'),
                            xtype: 'textfield',
                            name: 'minValue',
                            itemId: 'minValue',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('max_value'),
                            xtype: 'timefield',
                            name: 'maxValue',
                            itemId: 'timeMaxValue',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('min_value'),
                            xtype: 'timefield',
                            name: 'minValue',
                            itemId: 'timeMinValue',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('grow'),
                            xtype: 'checkbox',
                            name: 'grow',
                            itemId: 'grow',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('grow_min'),
                            xtype: 'textfield',
                            name: 'growMin',
                            itemId: 'growMin',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('grow_max'),
                            xtype: 'textfield',
                            name: 'growMax',
                            itemId: 'growMax',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('increment'),
                            xtype: 'textfield',
                            name: 'increment',
                            itemId: 'increment',
                            hidden: true
                        },
                        {
                            fieldLabel: i18n('list_options'),
                            xtype: 'mitos.listscombo',
                            name: 'list_id',
                            itemId: 'list_id',
                            hidden: true,
                            allowBlank: false,
                            listeners: {
                                scope: me,
                                change: me.onSelectListSelect
                            }
                        }
                    ]
                }
            ]
        });

        /**
         * this container holds the form and the select list grid.
         * remember that the select list grid only shows if
         * the field xtype is a combobox
         */
        me.formContainer = Ext.create('Ext.panel.Panel', {
            title: i18n('field_configuration'),
            border: true,
            split: true,
            width: 390,
            region: 'east',
            layout: {
                type:'vbox',
                align:'stretch'
            },
            bodyStyle: 'background-color:#fff!important',
            items: [
	            me.fieldForm,
	            me.selectListGrid
            ],
            buttons:[
                {
                    text: i18n('delete'),
                    iconCls: 'icoDeleteBlack',
                    scope: me,
                    handler: me.onFieldDelete
                },
                {
                    text: i18n('reset'),
                    iconCls: 'icoReload',
                    scope: me,
                    handler: me.onFormReset
                },
                {
                    text: i18n('save'),
                    iconCls: 'save',
                    scope: me,
                    handler: me.onFieldSave
                }
            ],
            dockedItems: [
                {
                    xtype: 'toolbar',
                    items: [
                        '->',
                        {
                            text: i18n('add_new'),
                            iconCls: 'icoAddRecord',
                            scope: me,
                            handler: me.onFormReset
                        },
                        '-',
                        {
                            text: i18n('add_child'),
                            iconCls: 'icoAddRecord',
                            itemId: 'addChild',
                            disabled: true,
                            scope: me,
                            handler: me.onAddChild
                        },
                        '-',
                        {
                            text: i18n('form_preview'),
                            iconCls: 'icoPreview',
                            enableToggle: true,
                            listeners: {
                                scope: me,
                                toggle: me.onFormPreview
                            }
                        }
                    ]
                }
            ]
        });

        /**
         * This is the fields associated with the current Form selected
         */
        me.fieldsGrid = Ext.create('Ext.tree.Panel', {
            store: me.fieldsGridStore,
            region: 'center',
            border: true,
            sortable: false,
            rootVisible: false,
            title: i18n('field_editor_demographics'),
            viewConfig: {
                plugins: {
                    ptype: 'treeviewdragdrop',
	                expandDelay:0,
                    allowParentInsert: false
                },
                listeners: {
                    scope: me,
                    drop: me.onDragDrop,
	                itemkeydown: me.onFieldKeyDown
                }
            },
            columns: [
                {
                    xtype: 'treecolumn',
                    text: i18n('field_type'),
                    sortable: false,
                    dataIndex: 'xtype',
                    width: 200,
                    align: 'left'
                },
                {
                    text: i18n('title'),
                    sortable: false,
                    dataIndex: 'title',
                    width: 100,
                    align: 'left'
                },
                {
                    text: i18n('label'),
                    sortable: false,
                    dataIndex: 'fieldLabel',
                    flex: 1,
                    align: 'left'
                }
            ],
            listeners: {
                scope: me,
	            selectionchange: me.onFieldsGridSelectionChange
            }
        });

        /**
         * Form grid will show the available forms to modified.
         * the user will not have the options to create
         * forms, just to modified the fields of existing forms.
         */
        me.formsGrid = Ext.create('Ext.grid.Panel', {
            title: i18n('form_list'),
            region: 'west',
            store: me.formsGridStore,
            width: 200,
            border: true,
            split: true,
            hideHeaders: true,
            columns: [
                {
                    dataIndex: 'id',
                    hidden: true
                },
                {
                    flex: 1,
                    sortable: true,
                    dataIndex: 'name'
                }
            ],
            listeners: {
                scope: me,
                itemclick: me.onFormGridItemClick
            }
        });

        /**
         * this panel will render the current form to preview
         * all the changes done.
         */
        me.fromPreview = Ext.create('Ext.form.Panel', {
            region: 'south',
            height: 300,
            collapsible: true,
            titleCollapse: false,
            hideCollapseTool: true,
            collapsed: true,
            border: true,
            split: true,
            collapseMode: 'header',
            bodyStyle: 'padding: 5px',
            layout: 'anchor',
            fieldDefaults: {
                msgTarget: 'side'
            },
            tools: [
                {
                    itemId: 'refresh',
                    type: 'refresh',
                    scope: me,
                    handler: me.previewFormRender
                }
            ]
        });
        me.pageBody = [
	        me.fieldsGrid,
	        me.formsGrid,
	        me.formContainer,
	        me.fromPreview
        ];
        me.callParent(arguments);
    },

    /**
     * if the form is valid send the POST request
     */
    onFieldSave: function(){
        var me = this,
            form = me.fieldForm.getForm(),
            record = form.getRecord(),
            store = me.fieldsGridStore,
            parentNode = store.getNodeById(record.data.parentId) || store.getRootNode(),
            values = form.getValues();

        if(form.isValid()){

            values.form_id = record.data.form_id;
            values.leaf = (values.xtype != 'fieldcontainer' && values.xtype != 'fieldset');
            record.set(values);

            if(record.data.id == ''){
	            parentNode.appendChild(record);
            }

            me.fieldsGridStore.sync({
               success:function(batch, options){
                   me.previewFormRender();
                   me.loadCurrFormParentField();

	               say(batch);
	               say(options);

                   // this is the quick way to apply the return changes to the model
	               if(record.data.id == ''){
		               say(batch.proxy.reader.rawData.id);
		               record.set({ id: batch.proxy.reader.rawData.id });
		               record.commit();
	               }

	               me.fieldsGrid.getSelectionModel().select(record);
                   me.msg('Sweet!', i18n('record_saved'));
               },
               failure:function(batch){

	               record.remove();

	               me.msg('Oops!', batch.proxy.reader.rawData.message, true);
                   me.loadFieldsGrid();
               }
           });
        }
    },

	/**
	 * Delete Field logic
	 * @param record
	 */
	deleteField:function(record){
		var me = this;

		say(record.childNodes);

		if(record.childNodes.length > 0){
			me.msg(i18n('oops'), i18n('children_fields_must_be_remove_first'), true);
			return;
		}

		Ext.Msg.show({
			title: i18n('please_confirm') + '...',
			icon: Ext.MessageBox.QUESTION,
			msg: i18n('delete_this_field'),
			buttons: Ext.Msg.YESNO,
			scope: this,
			fn: function(btn){
				if(btn == 'yes'){
					record.remove();
					me.fieldsGridStore.sync({
						success:function(){
							me.previewFormRender();
							me.msg('Sweet!', i18n('record_removed'));
						},
						failure:function(batch){
							me.msg('Oops!', batch.proxy.reader.rawData.message, true);
							me.loadFieldsGrid();
						}
					});
				}
			}
		});
	},

	/**
	 *
	 * @param view
	 * @param record
	 * @param item
	 * @param idex
	 * @param e
	 */
	onFieldKeyDown:function(view, record, item, idex, e){
		if(e.getKey() == e.DELETE){
			this.deleteField(record);
		}
	},

    /**
     *
     */
    onFieldDelete: function(){
        var me = this,
	        form = me.fieldForm.getForm(),
	        record = form.getRecord();

	    me.deleteField(record);
    },

    /**
     *
     * @param node
     * @param data
     * @param overModel
     */
    onDragDrop: function(node, data, overModel){
        var me = this;

        me.fieldsGridStore.sync({
            success:function(){
                me.previewFormRender();
                me.msg('Sweet!', 'Field Updated');
            },
            failure:function(batch){
                Ext.Msg.alert('Oops!', batch.proxy.reader.rawData.error);
                me.loadFieldsGrid();
            }
        });
    },

    /**
     * This is to reset the Form and load
     * a new Model with the currForm id
     */
    onFormReset: function(){
        var me = this,
            formPanel = me.fieldForm,
            form = formPanel.getForm(),
            selection = me.fieldsGrid.getSelectionModel(),
	        record = Ext.create('App.model.administration.LayoutTree', {
		        form_id: me.currForm,
		        parentId: 'root'
	        });

	    selection.deselectAll();

        form.reset();
        form.loadRecord(record);
    },

	onNameValueChange:function(field, value){
		field.setDisabled(field.up('form').getForm().getRecord().data.id != 0);
	},

    /**
     *
     * load a new model with the form_id and parentId values.
     * This is the easy way to add a child to a fieldset or fieldcontainer.
     */
    onAddChild: function(){
        var me = this,
            formPanel = me.fieldForm,
            form = formPanel.getForm(),
            row = me.fieldsGrid.getSelectionModel();

        row.deselectAll();
        form.reset();

        form.loadRecord(
            Ext.create('App.model.administration.LayoutTree',{
                form_id: me.currForm,
                parentId: me.currField
            })
        );
    },

    /**
     *
     * This will load the current field data to the form,
     * set the currField, and enable the Add Child btn if
     * the field allows child items (fieldset or fieldcontainer)
     *
     * @param sm
     * @param records
     */
    onFieldsGridSelectionChange: function(sm, records){
        var me = this,
            formPanel = me.fieldForm,
            form = formPanel.getForm();

	    if(records.length > 0){
		    form.loadRecord(records[0]);
		    me.currField = records[0].data.id;
		    if(records[0].data.xtype == 'fieldset' || records[0].data.xtype == 'fieldcontainer'){
			    me.formContainer.down('toolbar').getComponent('addChild').enable();
		    }else{
			    me.formContainer.down('toolbar').getComponent('addChild').disable();
		    }
		    formPanel.el.unmask();
	    }else{
		    me.onFormReset();
	    }
    },

    /**
     *
     * @param DataView
     * @param record
     */
    onFormGridItemClick: function(DataView, record){
        var me = this;

        me.currForm = record.get('id');
        me.fieldsGrid.setTitle(i18n('field_editor') + ' (' + record.get('name') + ')');
        me.loadFieldsGrid();
        me.onFormReset();
    },

    /**
     *
     * This will load the Select List options. This Combobox shows only when
     * a Type of Combobox is selected
     *
     * @param combo
     * @param value
     */
    onSelectListSelect: function(combo, value){
        var me = this;

        me.selectListoptionsStore.load({
            params: {
                list_id: value
            }
        });
    },

    /**
     *
     * This is to handle a error when loading a combobox store.
     *
     * @param combo
     */
    onParentFieldsExpand: function(combo){
        combo.picker.loadMask.destroy();
    },

    /**
     * onXtypeChange will search the combo value and enable/disable
     * the fields appropriate for the xtype selected
     *
     * @param combo
     * @param value
     */
    onXtypeChange: function(combo, value){
        var me = this;

        if(value == 'combobox'){
            me.selectListGrid.setTitle(i18n('select_list_options'));
            me.selectListGrid.expand();
            me.selectListGrid.enable();
        }else{
            me.selectListGrid.setTitle('');
            me.selectListGrid.collapse();
            me.selectListGrid.disable();
        }

        /**
         *
         * @param searchStr
         */
        Array.prototype.find = function(searchStr){
            var returnArray = false;

            for(var i = 0; i < this.length; i++){
                if(typeof (searchStr) == 'function'){
                    if(searchStr.test(this[i])){
                        if(!returnArray){
                            returnArray = [];
                        }
                        returnArray.push(i);
                    }
                }else{
                    if(this[i] === searchStr){
                        if(!returnArray){
                            returnArray = [];
                        }
                        returnArray.push(i);
                    }
                }
            }

            return returnArray;
        };

        var addProp = me.fieldForm.getComponent('aditionalProperties');
        var is = addProp.items.keys;

        /**
         *
         * @param items
         */
        function enableItems(items){
            for(var i = 0; i < is.length; i++){
                if(!items.find(is[i])){
                    addProp.getComponent(is[i]).hide();
                    addProp.getComponent(is[i]).disable();
                }else{
                    addProp.getComponent(is[i]).show();
                    addProp.getComponent(is[i]).enable();
                }
            }
        }

        var items;
        if(value == 'fieldset'){
            items = ['title', 'collapsible', 'collapsed', 'checkboxToggle', 'margin', 'columnWidth', 'layout'];
        }else if(value == 'fieldcontainer'){
            items = ['fieldLabel', 'labelWidth', 'hideLabel', 'width', 'layout', 'margin', 'columnWidth'];
        }else if(value == 'combobox'){
            items = ['name', 'width', 'emptyText', 'fieldLabel', 'hideLabel', 'labelWidth', 'margin', 'allowBlank', 'list_id'];
        }else if(value == 'checkbox'){
            items = ['name', 'width', 'boxLabel', 'inputValue', 'fieldLabel', 'hideLabel', 'labelWidth', 'margin'];
        }else if(value == 'textfield'){
            items = ['name', 'width', 'anchor', 'emptyText', 'fieldLabel', 'hideLabel', 'labelWidth', 'allowBlank', 'margin'];
        }else if(value == 'textareafield'){
            items = ['name', 'width', 'anchor', 'height', 'emptyText', 'fieldLabel', 'hideLabel', 'labelWidth', 'allowBlank', 'grow', 'growMin', 'growMax', 'margin'];
        }else if(value == 'numberfield'){
            items = ['name', 'width', 'value', 'emptyText', 'maxValue', 'minValue', 'increment', 'fieldLabel', 'labelWidth', 'hideLabel', 'margin'];
        }else if(value == 'timefield'){
            items = ['name', 'width', 'value', 'emptyText', 'timeMaxValue', 'timeMinValue', 'increment', 'fieldLabel', 'labelWidth', 'hideLabel', 'margin'];
        }else if(value == 'radiofield'){
            items = ['name', 'width', 'boxLabel', 'labelWidth', 'hideLabel', 'margin', 'inputValue'];
        }else if(value == 'datefield' || value == 'mitos.datetime'){
            items = ['name', 'width', 'value', 'layout', 'emptyText', 'fieldLabel', 'labelWidth', 'hideLabel', 'allowBlank', 'margin'];
        }else{
            items = ['name', 'width', 'emptyText', 'fieldLabel', 'labelWidth', 'hideLabel', 'margin'];
        }
        enableItems(items);
    },

    /**
     *
     * On toggle down/true expand the preview panel and re-render the form
     *
     * @param btn
     * @param toggle
     */
    onFormPreview: function(btn, toggle){
        var me = this;

        if(toggle === true){
            me.fromPreview.expand(false);
            me.previewFormRender();
        }else{
            me.fromPreview.collapse(false);
        }
    },

    /**
     *
     *  this function re-render the preview form
     */
    previewFormRender: function(){
        var me = this,
	        form = this.fromPreview;

        if(form.collapsed !== true){
            form.el.mask();
            me.getFormItems(form, me.currForm, function(){
                form.el.unmask();
            });
        }

    },

    /**
     *
     *  re-load the fields grid (main TreeGrid)
     *  check if a form is selected, if not the select the first choice
     *  save the form id inside this.currForm and load the grid and the
     *  parent fields of this form.
     *
     *  parentFieldsStore is use to create the child of select list
     */
    loadFieldsGrid: function(){
        var me = this;

        me.fieldsGridStore.load({
            params: {
                currForm: me.currForm
            }
        });

        me.loadCurrFormParentField();
        me.previewFormRender();
        me.fieldsGrid.doLayout()
    },

    loadCurrFormParentField:function(){
	    var me = this;
	    me.parentFieldsStore.load({ params:{ currForm: me.currForm } });
    },

    /**
     * This function is called from Viewport.js when
     * this panel is selected in the navigation panel.
     * place inside this function all the functions you want
     * to call every this panel becomes active
     */
    onActive: function(callback){
        var me = this,
	        sm = me.formsGrid.getSelectionModel();

        if(me.currForm === null){
            me.formsGridStore.load({
	            filters:[
		            {
			            property:'active',
			            value:1
		            }
	            ],
                callback:function(records){
	                sm.select(records[0]);
	                me.currForm = records[0].data.id;
	                me.loadFieldsGrid();
	                me.onFormReset();
                }
            });
        }

        callback(true);
    }
}); 