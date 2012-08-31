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

var useraccesspanel = Ext.create('Ext.tree.Panel', {
    bbar: [{
        xtype: 'toolbar',
        height: 30,
        items: [{
            xtype: 'button',
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
            xtype: 'checkbox'
        //            inputValue: true
        },
        flex: 50,
        text: 'Acceso'
    }],
    height: 178,
    store: menustore,
    title: 'Accesos',
    width: 478
});

var profilestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'description'],
    storeId: 'profilestore'
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