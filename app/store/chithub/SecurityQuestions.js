//[Feature]: Added for security questions

Ext.define('App.store.chithub.securityquestions', {
    extend: 'Ext.data.Store',
    model     : 'App.model.chithub.securityquestions',
    autoLoad  : true,
});