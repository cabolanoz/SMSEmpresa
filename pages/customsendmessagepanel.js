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
            
            var content = '';
            var numbers = number.split(',');
            for (var i = 0; i < numbers.length; i++)
                if (numbers[i] != null && numbers[i] != '')
                    content = content + '|' + Ext.String.trim(numbers[i]) + '->' + (message + i);
            
            var company = Ext.getCmp('claro').getValue() ? 'claro' : 'movistar';
            
            var waitMsg = Ext.Msg.wait('Enviando mensaje (s)...');
            
            Ext.Ajax.request({
                failure: function(o) {
                    waitMsg.hide();
                    Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en el env&iacuteo de los mensajes\nPor favor contacte al administrador del sistema');
                },
                method: 'GET',
                params: {
                    company_type: company,
                    datas: content  
                },
                success: function(o) {
                    waitMsg.hide();
                    var response = Ext.decode(o.responseText);
                    if (response.datas.length == 0) {
                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'Mensajes env&iacuteados con &eacutexito');
                        Ext.getCmp('txtmessage').setValue('');
                        Ext.getCmp('txtnumber').setValue('');
                    }
                },
                url: '../phpcode/messagesender.php'
            });
        }
    }, {
        text: 'Cancelar',
        handler: function() {
            this.up('form').getForm().reset();
        }
    }]
});