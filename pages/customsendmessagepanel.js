/**
 * @author: César Bolaños [cbolanos]
 */

var customsendmessagepanel = new Ext.form.Panel({
    bodyStyle: 'padding: 5px 5px 0',
    frame: true,
    id: 'customsmssender',
    title: 'Env&iacuteo de Mensajes',
    width: 600,
    
    defaults: {
        anchor: '100%',
        msgTarget: 'side'
    },
    
    items: [{
        xtype: 'textfield',
        fieldLabel: 'Mensaje',
        labelWidth: 120,
        name: 'txtmessage'
    }, {
        xtype: 'textareafield',
        fieldLabel: 'N&uacutemeros',
        labelWidth: 120,
        name: 'txtnumber'
    }],

    buttons: [{
        text: 'Enviar'
    }, {
        text: 'Cancelar',
        handler: function() {
            this.up('form').getForm().reset();
        }
    }]
});