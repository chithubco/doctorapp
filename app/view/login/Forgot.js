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

Ext.define('App.view.login.Forgot', {
	extend: 'Ext.Viewport',
	requires: [
		'App.ux.combo.Languages'
	],

	initComponent: function(){
		var me = this;
		me.currSite = null;
		me.currLang = null;

		me.securityStore = Ext.create('App.store.chithub.securityquestions');
		// setting to show site field
		me.showSite = false;

		me.siteError = false;// window.site === false || window.site === '';

		/**
		 * The Copyright Notice Window
		 */
		me.winCopyright = Ext.create('widget.window', {
			id: 'winCopyright',
			title: 'Phone A Doctor Copyright Notice',
			bodyStyle: 'background-color: #ffffff; padding: 5px;',
			autoLoad: 'gpl-licence-en.html',
			closeAction: 'hide',
			width: 900,
			height: '75%',
			modal: false,
			resizable: true,
			draggable: true,
			closable: true,
			autoScroll: true
		});
		//[Added] : Line config to add a horizontal line
		var lineconfig = {
			xtype: 'box',
			autoEl:{
				tag: 'div',
				style:'line-height:1px; font-size: 1px;margin-bottom:4px',
				children: [{
					tag: 'img',
					src: '1pxLine.gif',
					height: '2px',
					width: '100%'
				}]
			}
		};
		/**
		 * Form Layout [Forgot Password]
		 */
		me.formForgot = Ext.create('Ext.form.FormPanel', {
			bodyStyle: 'background: #ffffff; padding:5px 5px 0',
			defaultType: 'textfield',
			waitMsgTarget: true,
			frame: false,
			border: false,
			width: 483,
			padding: '0 0 5 0',
			bodyPadding: '5 5 0 5',
			baseParams: {
				auth: 'true'
			},
			fieldDefaults: {
				msgTarget: 'side',
				labelWidth: 150
			},
			defaults: {
				anchor: '100%'
			},
			items: [
				{
					xtype: 'radio',
					name: 'selectOption',
					inputValue: 'email',
					checked: true,
					boxLabel: '<b>Use Email Address for Recovery</b>',
					scope: me,
					anchor: '100%'
				},
				{
					xtype: 'displayfield',
					fieldLabel: '',
					anchor: '100%'
				},
				{
					xtype: 'textfield',
					fieldLabel: 'Email Address',
					blankText: 'Enter your email address',
					name: 'authEmail',
					itemId: 'authEmail',
					regex:/^((([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z\s?]{2,5}){1,25})*(\s*?;\s*?)*)*$/,
					regexText:'This field must contain a valid email address',
					allowBlank: true,
					validationEvent: false,
					listeners: {
						scope: me,
						specialkey: me.onEnter
					}
				},
				{
					xtype: 'displayfield',
					itemId: 'blank',
					fieldLabel: '',
					anchor: '100%'
				},
				{
					xtype: 'radio',
					name: 'selectOption',
					inputValue: 'phone',
					boxLabel: '<b>Use Phone Number and Security Question & Answer for Recovery</b>',
					scope: me,
					anchor: '100%'
				},
				{
					xtype: 'textfield',
					blankText: 'Enter your Phone Number',
					inputType: 'text',
					name: 'authPhone',
					fieldLabel: 'Phone Number',
					minLengthText: 'Password must be at least 4 characters long.',
					validationEvent: false,
					allowBlank: true,
					minLength: 4,
					maxLength: 50,
					listeners: {
						scope: me,
						specialkey: me.onEnter
					}
				},
				{
					xtype: 'combo',
					id: 'authQuestion',
					name: 'authQuestion',
					triggerAction:  'all',
					forceSelection: true,
					editable:       false,
					allowBlank: true,
					fieldLabel:     'Security Question',
					mode: 'remote',
					emptyText:'Select a Question...',
					displayField:'question',
					valueField: 'question',
					store: me.securityStore
				},
				{
					xtype: 'textfield',
					blankText: 'Enter your Answer',
					inputType: 'text',
					name: 'authAnswer',
					fieldLabel: 'Security Answer',
					minLengthText: 'Answer must be at least 4 characters long.',
					validationEvent: false,
					allowBlank: true,
					minLength: 4,
					maxLength: 50,
					listeners: {
						scope: me,
						specialkey: me.onEnter
					}
				},
				lineconfig
			],
			buttons: [
				{
					text: 'Cancel',
					name: 'btn_cancel',
					scope: me,
					handler: me.cancelSubmit
				},'->',
				{
					text: 'Recover Password',
					name: 'btn_login',
					scope: me,
					handler: me.loginSubmit
				}
			]
		});


		/**
		 * The Logon Window
		 */
		me.winLogon = Ext.create('widget.window', {
			title: 'Phone-A-Doctor Logon',
			closeAction: 'hide',
			plain: true,
			modal: false,
			resizable: false,
			draggable: false,
			closable: false,
			width: 495,
			bodyStyle: 'background: #ffffff;',
			items: [
				{
					xtype: 'box',
					width: 483,
					height: 135,
					html: '<img src="resources/images/logon_header.png" />'
				},
				(me.siteError) ?
				{
					xtype: 'container',
					padding: 15,
					html: 'Sorry no site configuration file found. Please contact Support Desk'
				} : me.formForgot
			],
			listeners: {
				scope: me,
				afterrender: me.afterAppRender
			}
		}).show();

		//[Update] : Remove Demo Notice
		//me.notice1 = Ext.create('Ext.Container', {
		//	floating: true,
		//	cls: 'logout-warning-window',
		//	style: 'text-align:center; width:800',
		//	html: 'This demo version is 300% slower because files are not fully minified (compressed) or compiled.<br>' + 'Please allow about 15sec for the app to download. Compiled version loads between 3 - 5 seconds.',
		//	seconds: 10
		//}).show();
		//me.notice1.alignTo(Ext.getBody(), 't-t', [0, 10]);

		if(Ext.isIE){
			me.notice2 = Ext.create('Ext.Container', {
				floating: true,
				cls: 'logout-warning-window',
				style: 'text-align:center; width:800',
				html: '<span style="font-size: 18px;">WAIT!!! There is a known bug with Internet Explorer - <a href="http://gaiaehr.org:8181/browse/GAIAEH-119" target="_blank" style="color: white;">more info...</a></span><br>' + 'Please, access the application through any of these browsers... ' + '<span style="text-decoration: underline;"><a href="https://www.google.com/intl/en/chrome/" target="_blank" style="color: white;">Google Chrome</a></span>, ' + '<span style="text-decoration: underline;"><a href="http://www.mozilla.org/en-US/firefox/new/" target="_blank" style="color: white;">Firefox</a></span>, or ' + '<span style="text-decoration: underline;"><a href="http://www.opera.com/" target="_blank" style="color: white;">Opera</a></span>'
			}).show();
			me.notice2.alignTo(Ext.getBody(), 't-t', [0, 85]);
		}
		else if(!Ext.isChrome && !Ext.isOpera && !Ext.isGecko){
			me.notice2 = Ext.create('Ext.Container', {
				floating: true,
				cls: 'logout-warning-window',
				style: 'text-align:center; width:800',
				html: 'Phone-A-Doctor rely heavily on javascript and web 2.0 / ajax requests, although any browser will do the work<br>' + 'we strongly recommend to use any of the fastest browsers to day, <span style="text-decoration: underline;">' + '<span style="text-decoration: underline;"><a href="https://www.google.com/intl/en/chrome/" target="_blank" style="color: white;">Google Chrome</a></span>, ' + '<span style="text-decoration: underline;"><a href="http://www.mozilla.org/en-US/firefox/new/" target="_blank" style="color: white;">Firefox</a></span>, or ' + '<span style="text-decoration: underline;"><a href="http://www.opera.com/" target="_blank" style="color: white;">Opera</a></span>'
			}).show();
			me.notice2.alignTo(Ext.getBody(), 't-t', [0, 85]);
		}

		me.listeners = {
			resize: me.onAppResize
		};

		me.callParent(arguments);
	},
	/**
	 * when keyboard ENTER key press
	 * @param field
	 * @param e
	 */
	onEnter: function(field, e){
		if(e.getKey() == e.ENTER){
			this.loginSubmit();
		}
	},
	//[Update] : Cancel button to lead back to main page
	/**
	 * Form Cancel function
	 */
	cancelSubmit: function(){
		var me = this;

		window.location = './';
	},
	/**
	 * Form Submit/Logon function
	 */
	loginSubmit: function(){
		var me = this,
			formPanel = this.formForgot,
			form = formPanel.getForm(),
			params = form.getValues(),
			checkInMode = me.formForgot.query('checkbox')[0].getValue();

				Ext.Msg.show({
					title: 'Oops!',
					msg: 'Testing',
					buttons: Ext.Msg.OK,
					icon: Ext.Msg.ERROR
				});
	},
	/**
	 * gets the site combobox value and store it in currSite
	 * @param combo
	 * @param value
	 */
	onSiteSelect: function(combo, value){
		this.currSite = value[0].data.site;
	},

	onLangSelect: function(combo, value){
		this.currLang = value[0].data.value;
	},

	/**
	 * form rest function
	 */
	onFormReset: function(){
		var me = this,
			form = me.formForgot.getForm();

		form.setValues({
			site: window.site,
			authUser:'',
			authPass:'',
			lang: me.currLang
		});
		me.formForgot.getComponent('authUser').focus();
	},
	/**
	 * After form is render load store
	 */
	afterAppRender: function(){
		var me = this; //, langCmb = me.formForgot.getComponent('lang');

		if(!me.siteError){
			if(me.showSite){
				me.storeSites.load({
					scope: me,
					callback: function(records, operation, success){
						if(success === true){
							/**
							 * Lets add a delay to make sure the page is fully render.
							 * This is to compensate for slow browser.
							 */
							Ext.Function.defer(function(){
								me.currSite = records[0].data.site;
								if(me.showSite){
									me.formForgot.getComponent('site').setValue(this.currSite);
								}
							}, 100, this);
						}
						else{
							this.msg('Opps! Something went wrong...', 'No site found.');
						}
					}
				});
			}

			//langCmb.store.load({
			//	callback: function(){
			//		me.currLang = 'en_US';
			//		me.formForgot.getComponent('lang').setValue(me.currLang);
			//	}
			//});

			//Ext.Function.defer(function(){
			//	me.formForgot.getComponent('authEmail').inputEl.focus();
			//}, 200);
		}
	},
	/**
	 *  animated msg alert
	 * @param title
	 * @param format
	 * @param error
	 * @param persistent
	 */
	msg: function(title, format, error, persistent){
		var msgBgCls = (error === true) ? 'msg-red' : 'msg-green';
		this.msgCt = Ext.get('msg-div');
		this.msgCt.alignTo(document, 't-t');
		var s = Ext.String.format.apply(String, Array.prototype.slice.call(arguments, 1)),
			m = Ext.core.DomHelper.append(this.msgCt, {
				html: '<div class="flyMsg ' + msgBgCls + '"><h3>' + (title || '') + '</h3><p>' + s + '</p></div>'
			}, true);
		if(persistent === true) return m; // if persistent return the message element without the fade animation
		m.addCls('fadeded');
		Ext.create('Ext.fx.Animator', {
			target: m,
			duration: error ? 7000 : 2000,
			keyframes: {
				0: { opacity: 0 },
				20: { opacity: 1 },
				80: { opacity: 1 },
				100: { opacity: 0, height: 0 }
			},
			listeners: {
				afteranimate: function(){
					m.destroy();
				}
			}
		});
		return true;
	},

	onAppResize: function(){
		this.winLogon.alignTo(this, 'c-c');
		//this.notice1.alignTo(Ext.getBody(), 't-t', [0, 10]);
		if(this.notice2)
			this.notice2.alignTo(Ext.getBody(), 't-t', [0, 85]);
	}
});