/**
 * @author: César Bolaños [cbolanos]
 */

var customsendmessagepanel = new Ext.form.Panel({
    bodyStyle: 'padding: 5px 5px 0',
    frame: true,
    id: 'customsmssender',
    title: 'Env&iacuteo de Mensajes',
    width: 900,
    
    defaults: {
        anchor: '100%',
        msgTarget: 'side'
    },
    
    items: [{
        xtype: 'textfield',
        fieldLabel: 'Mensaje',
        id: 'txtmessage',
        labelWidth: 120,
        name: 'txtmessage'
    }, {
        xtype: 'textareafield',
        fieldLabel: 'N&uacutemeros',
        height: 170,
        id: 'txtnumber',
        labelWidth: 120,
        name: 'txtnumber'
    }, {
        xtype: 'radio',
        boxLabel: 'Claro',
        checked: true,
        dock: 'top',
        id: 'claro',
        inputLabel: 'claro',
        name: 'company'
    }, {
        xtype: 'radio',
        dock: 'top',
        boxLabel: 'Movistar',
        id: 'movistar',
        inputLabel: 'movistar',
        name: 'company'
    }, {
        xtype: 'label',
        margin: '0 0 0 370',
        style: 'color: #FE0000',
        text: 'Nota: Los números telefónicos deben estar separados por coma y con una longitud estandar'
    }],

    buttons: [{
        text: 'Enviar',
        handler: function() {
            var message = Ext.getCmp('txtmessage').getValue();
            var number = Ext.getCmp('txtnumber').getValue();
            if (message == null || message == "" || number == null || number == "") {
                Ext.Msg.alert('Env&iacuteo de Mensajes', 'Debe ingresar el mensaje y los n&uacutemeros para el env&iacuteo de mensajes');
                return;
            }
            
            var numbers = number.split(',');
            console.log(numbers);
        }
    }, {
        text: 'Cancelar',
        handler: function() {
            this.up('form').getForm().reset();
        }
    }]
});