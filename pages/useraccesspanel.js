/**
 * @author: César Bolaños [cbolanos]
 */

var useraccessstore = Ext.create('Ext.data.TreeStore', {
    autoLoad: false,
    storeId: 'useraccessstore'
})

useraccessstore.setRootNode({
    text: "Usuario",
    leaf: false,
    expanded: false
});

var profilestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['id', 'name', 'description'],
    storeId: 'profilestore'
});

var useraccesspanel = Ext.create('Ext.tree.Panel', {
    bbar: [{
        xtype: 'toolbar',
        height: 30,
        items: [{
            xtype: 'button',
            handler: function() {
                var newuser = new Ext.window.Window({
                    buttons: [{
                        text: 'Guardar',
                        handler: function() {
                            var username = Ext.getCmp('txtusername').getValue();
                            var name = Ext.getCmp('txtname').getValue();
                            var password = Ext.getCmp('txtpassword').getValue();
                            var repassword = Ext.getCmp('txtrepassword').getValue();
                            var profile = Ext.getCmp('cbxprofile').getValue();
                            
                            if (username != null) {
                                Ext.Ajax.request({
                                    method: 'GET',
                                    params: {
                                        username: username
                                    },
                                    success: function(o) {
                                        var response = Ext.decode(o.responseText);
                                        if (response.success == 'NOOK') {
                                            Ext.Msg.alert('Env&iacuteo de Mensajes', 'El nombre de usuario digitado ya se encuentra registrado en el sistema');
                                            return;
                                        }
                                    },
                                    url: '../phpcode/checkuserexist.php'
                                });
                            }
                            
                            if (password != null && repassword != null)
                                if (password != repassword) {
                                    Ext.Msg.alert('Env&iacuteo de Mensajes', 'Sus contrase&ntildeas deben ser iguales');
                                    return;
                                }
                            
                            if (username == null || name == null || password == null || repassword == null || profile == null) {
                                Ext.Msg.alert('Env&iacuteo de Mensajes', 'Todos los campos del formulario son requeridos para el registro');
                                return;
                            }
                            
                            Ext.Ajax.request({
                                failure: function(o) {
                                    Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en la inserci&oacuten del registro de usuario\nPor favor contacte al administrador del sistema');
                                },
                                method: 'GET',
                                params: {
                                    username: username,
                                    name: name,
                                    password: password,
                                    profile: profile
                                },
                                success: function(o) {
                                    var response = Ext.decode(o.responseText);
                                    if (response.success == 'OK') {
                                        newuser.hide();
                                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'Usuario registrado con &eacutexito');
                                        updateUserStore();
                                    }
                                },
                                url: '../phpcode/registeruser.php'
                            });
                        }
                    }, {
                        text: 'Cancelar',
                        handler: function() {
                            newuser.hide();
                        }
                    }],
                    height: 210,
                    items: [{
                        xtype: 'panel',
                        bodyPadding: 5,
                        fieldDefaults: {
                            msgTarget: 'side',
                            labelWidth: 120
                        },
                        items: [{
                            xtype: 'textfield',
                            allowBlank: false,
                            blankText: 'Este campo es requerido',
                            fieldLabel: 'Nombre de Usuario',
                            id: 'txtusername',
                            labelWidth: 150,
                            listeners: {
                                change: function(field, newValue, oldValue, eOpts) {
                                //                                    console.log('New value: ' + newValue + ' Old value: ' + oldValue);
                                }
                            },
                            width: 450
                        }, {
                            xtype: 'textfield',
                            allowBlank: false,
                            blankText: 'Este campo es requerido',
                            fieldLabel: 'Nombre Completo',
                            id: 'txtname',
                            labelWidth: 150,
                            width: 450
                        }, {
                            xtype: 'textfield',
                            allowBlank: false,
                            blankText: 'Este campo es requerido',
                            fieldLabel: 'Contrase&ntildea',
                            id: 'txtpassword',
                            inputType: 'password',
                            labelWidth: 150,
                            width: 450
                        }, {
                            xtype: 'textfield',
                            allowBlank: false,
                            blankText: 'Este campo es requerido',
                            fieldLabel: 'Re-ingrese Contrase&ntildea',
                            id: 'txtrepassword',
                            inputType: 'password',
                            labelWidth: 150,
                            width: 450
                        }, {
                            xtype: 'combobox',
                            allowBlank: false,
                            displayField: 'name',
                            fieldLabel: 'Perfil',
                            id: 'cbxprofile',
                            labelWidth: 150,
                            queryMode: 'local',
                            store: profilestore,
                            valueField: 'id',
                            width: 450
                        }]
                    }],
                    modal: true,
                    resizable: false,
                    title: 'Nuevo Usuario',
                    width: 475
                });
                
                newuser.show();
            },
            icon: '../img/useradd-16x16.png',
            tooltip: 'Nuevo usuario'
        }, {
            xtype: 'button',
            icon: '../img/useredit-16x16.png',
            tooltip: 'Editar usuario'
        }],
        width: 390
    }],
    height: 360,
    plugin: [{
        ptype: 'false'
    }],
    rootVisible: false,
    rowspan: 2,
    store: useraccessstore,
    useArrows: true,
    width: 395
});

var menustore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'access'],
    storeId: 'menustore'
});

var menugrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        dataIndex: 'name',
        flex: 120,
        text: 'Nombre'
    }, {
        align: 'center',
        dataIndex: 'access',
        editor: {
            xtype: 'checkbox',
            inputValue: true
        },
        flex: 50,
        text: 'Acceso'
    }],
    height: 178,
    store: menustore,
    title: 'Accesos',
    width: 478
});

var profilegrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    bbar: [{
        xtype: 'toolbar',
        height: 30,
        items: [{
            xtype: 'button',
            icon: '../img/profileadd-16x16.png',
            tooltip: 'Nuevo perfil'
        }],
        width: 478
    }],
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        dataIndex: 'name',
        flex: 30,
        text: 'Nombre'
    }, {
        align: 'center',
        dataIndex: 'description',
        flex: 120,
        text: 'Descripción'
    }],
    listeners: {
        selectionchange: function(model, records) {
            var record = records[0];
            if (record == null)
                return;
            
            Ext.Ajax.request({
                failure: function(o) {
                    Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en la obtenci&oacuten de los menues\nPor favor contacte al administrador del sistema');
                },
                method: 'GET',
                params: {
                    profile: record.get('name')
                },
                success: function(o) {
                    var response = Ext.decode(o.responseText);
                    if (response.datas.length == 0) {
                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'No se encontraron los menues previamente definidos\nPor favor contacte al administrador del sistema');
                        return;
                    }
                    
                    menustore.loadData(response.datas);
                },
                url: '../phpcode/menureader.php'
            });
        }
    },
    height: 170,
    store: profilestore,
    title: 'Perfiles',
    width: 478
});

var rightpanel = Ext.create('Ext.panel.Panel', {
    bodyPadding: 5,
    height: 360,
    items: [profilegrid, menugrid],
    layout: 'vbox',
    width: 490
});

var accessespanel = Ext.create('Ext.panel.Panel', {
    bodyPadding: 5,
    height: 400,
    items: [useraccesspanel, rightpanel],
    layout: {
        type: 'table', 
        columns: 2
    },
    title: 'Usuarios -> Perfiles -> Accessos',
    width: 900
});

function updateUserStore() {
    if (useraccessstore.getRootNode().hasChildNodes())
        useraccessstore.getRootNode().removeAll();
    
    Ext.Ajax.request({
        failure: function(o) {
            Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en la obtenci&oacuten de accesos\nPor favor contacte al administrador del sistema');
        },
        method: 'GET',
        success: function(o) {
            var response = Ext.decode(o.responseText);
            if (response.items.length == 0) {
                Ext.Msg.alert('Env&iacuteo de Mensajes', 'No se encontraron usuarios y access previamente definidos\nPor favor contacte al administrador del sistema');
                return;
            }
                                
            useraccessstore.getRootNode().appendChild(response.items);
            useraccessstore.getRootNode().expand(true);
        },
        url: '../phpcode/accessesreader.php'
    });
}