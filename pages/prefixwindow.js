/**
 * @author: César Bolaños [cbolanos]
 */

var claroprefixstore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['value'],
    storeId: 'claroprefixstore'
});

var claroprefixgrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    columns: [{
        dataIndex: 'value',
        sortable: true,
        text: 'Prefijo'
    }],
    store: claroprefixstore,
    title: 'Claro'
});

var movistarprefixstore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['value'],
    storeId: 'movistarprefixstore'
});

var movistarprefixgrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    columns: [{
        dataIndex: 'value',
        sortable: true,
        text: 'Prefijo'
    }],
    store: movistarprefixstore,
    title: 'Movistar'
});

var prefixwindow = new Ext.window.Window({
    height: 600,
    id : 'prefixwindow',
    items: [{
        xtype: 'panel',
        items: [claroprefixgrid, movistarprefixgrid],
        layout: 'accordion',
        margins:'5 0 5 5',
        region: 'center'
    }],
    layout: 'fit',
    title: 'Prefijos',
    width: 100
});