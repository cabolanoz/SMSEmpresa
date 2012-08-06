/**
 * @author: César Bolaños [cbolanos]
 */

Ext.onReady(function() {
    Ext.Loader.setConfig({
        enabled: true
    });
    Ext.Loader.setPath('Ext.ux.exporter', '../ux/exporter');

    Ext.require([
        'Ext.ux.exporter.Exporter',
        'Ext.ux.exporter.Base64',
        'Ext.ux.exporter.Button',
        'Ext.ux.exporter.Formatter',
        'Ext.ux.exporter.excelFormatter.Workbook',
        'Ext.ux.exporter.excelFormatter.Worksheet',
        'Ext.ux.exporter.excelFormatter.Cell',
        'Ext.ux.exporter.excelFormatter.Style',
        'Ext.ux.exporter.excelFormatter.ExcelFormatter',
        'Ext.ux.exporter.csvFormatter.CsvFormatter'
        ]);
});

var store = Ext.create('Ext.data.Store', {
    storeId: 'telephoneStore',
    fields: ['id', 'phone', 'message'],
    autoLoad: false,
    pageSize: 12,
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'items'
        }
    }
});

var gridpanel = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        flex: 10,
        dataIndex: 'id',
        text: '#'
    }, {
        align: 'center',
        flex: 20,
        dataIndex: 'phone',
        text: 'Tel&eacutefono'
    }, {
        align: 'center',
        flex: 200,
        dataIndex: 'message',
        text: 'Mensaje'
    }],
    dockedItems: [{
        xtype: 'pagingtoolbar',
        afterPageText: 'de {0}',
        beforePageText: 'P&aacutegina',
        dock: 'bottom',
        store: store
    }],
    height: 336,
    id: "gridpanel",
    store: store,
    tbar: [{
        xtype: 'filefield',
        buttonConfig: {
            icon: '../img/search-16x16.png'
        },
        buttonOnly: true,
        buttonText: 'Seleccionar Archivo',
        emptyText: 'Seleccione un archivo',
        hideLabel: true,
        listeners: {
            'change': function(fb, v) {
                var form = this.up('form').getForm();
                if (form.isValid()) {
                    form.submit({
                        success: function(fp, o) {
                            var response = Ext.decode(o.response.responseText);
                            Ext.data.StoreManager.lookup('telephoneStore').loadData(response.datas);
                        },
                        url: '../phpcode/filereader.php',
                        waitMsg: 'Leyendo mensaje (s)...'
                    });
                }
            }
        },
        name: 'txtfile',
        widht: 400
    }, {
        xtype: 'button',
        handler: function() {
            if (!isStoreEmpty()) {
                Ext.Ajax.request({
                   method: 'GET',
                   params: {
                       a: getStoreContent()
                   },
                   url: '../phpcode/excelexporter.php'
                });
            } else
                Ext.Msg.alert('Env&iacuteo de Mensajes', 'No hay datos para la exportaci&oacuten');
        },
        icon: '../img/excel-16x16.png',
        text: 'Exportar a Excel'
    }]
});

var sendmessagepanel = new Ext.form.Panel({
    frame: true,
    height: 400,
    id: 'sendmessage',
    title: 'Env&iacuteo de Mensajes',
    width: 900,

    defaults: {
        anchor: '100%',
        msgTarget: 'side'
    },

    items: [gridpanel],

    buttons: [{
        text: 'Enviar',
        handler: function() {
            if (!isStoreEmpty()) {
                Ext.create('Ext.window.Window', {
                    items: [{
                        xtype: 'button',
                        cls: 'claro-icon',
                        handler: function() {
                        //                            sendMessageRequest(content, 'claro');
                        },
                        height: 50,
                        text: 'Claro',
                        width: 188
                    }, {
                        xtype: 'button',
                        cls: 'movistar-icon',
                        handler: function() {
                            sendMessageRequest(getStoreContent(), 'movistar');
                        },
                        height: 50,
                        text: 'Movistar',
                        width: 188
                    }],
                    id: 'companytypewindow',
                    layout: 'fit',
                    modal: true,
                    title: 'Env&iacuteo de Mensajes',
                    width: 48
                }).show();
            } else
                Ext.Msg.alert('Env&iacuteo de Mensajes', 'No hay datos para el env&iacuteo de mensajes');
        }
    }, {
        text: 'Cancelar',
        handler: function() {
            this.up('form').getForm().reset();
            if (!isStoreEmpty())
                store.removeAll(false);
        }
    }]
});

function isStoreEmpty() {
    var store = Ext.getCmp('gridpanel').getStore();
    if (store.count() > 0)
        return false;
    else
        return true;
}

function getStoreContent() {
    var content = '';
    store.each(function(record) {
        content = content + '|' + record.get('phone') + '->' + record.get('message');
    });
    return content;
}

function sendMessageRequest(content, company) {
    Ext.getCmp('companytypewindow').hide();
    Ext.Ajax.request({
        failure: function(o) {
            Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en el env&iacuteo de los mensajes\nPor favor contacte al administrador del sistema');
        },
        method: 'GET',
        params: {
            company_type: company,
            datas: content  
        },
        success: function(o) {
            var response = Ext.decode(o.responseText);
            if (response.datas.length == 0) {
                Ext.Msg.alert('Env&iacuteo de Mensajes', 'Mensajes env&iacuteados con &eacutexito');
            } else {
                console.log(response.datas.length);
            }
        },
        url: '../phpcode/messagesender.php'
    });
}