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
            tooltip: 'Agregar usuario'
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

var profilestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'description'],
    storeId: 'profilestore'
});

var profilegrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        dataIndex: 'name',
        text: 'Nombre'
    }, {
        align: 'center',
        dataIndex: 'description',
        text: 'Descripción'
    }],
    store: profilestore
});

var rightpanel = Ext.create('Ext.panel.Panel', {
    bodyPadding: 5,
    height: 360,
    items: [profilegrid, {
        xtype: 'grid',
        columns: [{
            header: 'Column One'
        }],
        flex: 1,
        store: Ext.create('Ext.data.ArrayStore', {}),
        title: 'Accesos',
        width: 478
    }],
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