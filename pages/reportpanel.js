/**
 * @author: César Bolaños [cbolanos]
 */

/**
 * Line
 */
// Line store
var linestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['Fecha', 'Claro', 'Movistar', 'Total'],
    storeId: 'linestore'
});

// Line grid
var linegrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        dataIndex: 'Fecha',
        flex: 220,
        text: 'Fecha'
    }, {
        align: 'center',
        dataIndex: 'Claro',
        flex: 220,
        text: 'Mensajes Claro'
    }, {
        align: 'center',
        dataIndex: 'Movistar',
        flex: 220,
        text: 'Mensajes Movistar'
    }, {
        align: 'center',
        dataIndex: 'Total',
        flex: 220,
        text: 'Total de Mensajes'
    }],
    store: linestore
});

// Line chart
var linechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'right'
    },
    shadow: true,
    store: linestore,
    axes: [{
        type: 'Numeric',
        fields: ['Claro', 'Movistar'],
        grid: {
            odd: {
                fill: '#ddd',
                opacity: 1,
                stroke: '#bbb',
                'stroke-width': 0.5
            }
        },
        minimum: 0,
        minorTickSteps: 1,
        position: 'left',
        title: 'Cantidad de Mensajes'
    }, {
        type: 'Category',
        fields: ['Fecha'],
        position: 'bottom',
        title: 'Período'
    }],
    series: [{
        type: 'line',
        axis: 'left',
        markerConfig: {
            type: 'cross',
            'fill': '#fe0000',
            size: 4,
            radius: 4
        },
        style: {
            fill: '#fe0000',
            stroke: '#fe0000',
            'stroke-width': 2,
            opacity: 0.2
        },
        xField: 'Fecha',
        yField: 'Claro'
    }, {
        type: 'line',
        axis: 'left',
        markerConfig: {
            type: 'circle',
            'fill': '#7dc042',
            size: 4,
            radius: 4
        },        
        style: {
            fill: '#7dc042',
            stroke: '#7dc042',
            'stroke-width': 2,
            opacity: 0.2
        },
        xField: 'Fecha',
        yField: 'Movistar'
    }]
});

/**
 * Pie
 */
// Pie store
var piestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'value'],
    storeId: 'piestore'
});

// Pie chart
var piechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'right'
    },
    series: [{
        donut: false,
        field: 'value',
        highlight: {
            segment: {
                margin: 30
            }
        },
        label: {
            contrast: true,
            display: 'rotate',
            field: 'name',
            font: '18px Arial'
        },
        showInLegend: true,
        colorSet: ['#fe0000', '#7dc042'],
        tips: {
            height: 28,
            renderer: function(storeItem, item) {
                var total = 0;
                piestore.each(function(rec) {
                    total += rec.get('value');
                });
                this.setTitle(storeItem.get('name') + ': ' + Math.round(storeItem.get('value') / total * 100) + '%');
            },
            trackMouse: true,
            width: 100
        },
        type: 'pie'
    }],
    shadow: true,
    store: piestore
});

/**
* Bar
*/
// Bar store
var barstore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['Usuario', 'Nombre', 'Claro', 'Movistar', 'Total'],
    storeId: 'barstore'
});

// Mini pie store
var minipiestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'value'],
    storeId: 'minipiestore'
});

// Pie chart
var minipiechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'bottom'
    },
    series: [{
        donut: false,
        field: 'value',
        highlight: {
            segment: {
                margin: 50
            }
        },
        label: {
            contrast: true,
            display: 'rotate',
            field: 'name',
            font: '18px Arial'
        },
        showInLegend: true,
        colorSet: ['#fe0000', '#7dc042'],
        tips: {
            height: 28,
            renderer: function(storeItem, item) {
                var total = 0;
                minipiestore.each(function(rec) {
                    total += rec.get('value');
                });
                console.log(total);
                this.setTitle(storeItem.get('name') + ': ' + Math.round(storeItem.get('value') / total * 100) + '%');
            },
            trackMouse: true,
            width: 100
        },
        type: 'pie'
    }],
    shadow: true,
    store: minipiestore
});

// Bar grid
var bargrid = Ext.create('Ext.grid.Panel', {
    autoScroll: true,
    clearOnPageLoad: true,
    collapsible: false,
    columns: [{
        align: 'center',
        dataIndex: 'Usuario',
        text: 'Usuario'
    }, {
        align: 'center',
        dataIndex: 'Nombre',
        flex: 150,
        text: 'Nombre del Usuario'
    }, {
        align: 'center',
        dataIndex: 'Claro',
        text: 'Mensajes Claro'
    }, {
        align: 'center',
        dataIndex: 'Movistar',
        text: 'Mensajes Movistar'
    }, {
        align: 'center',
        dataIndex: 'Total',
        text: 'Total de Mensajes'
    }],
    height: 335,
    listeners: {
        selectionchange: function(model, records) {
            var record = records[0];
            var json = [{
                name: 'Claro',
                value: record.get('Claro')
            }, {
                name: 'Movistar',
                value: record.get('Movistar')
            }];
            minipiestore.loadData(json);
        }
    },
    margin: '0 5 0 0',
    store: barstore,
    width: 510
});

// Bar chart
var barchart = Ext.create('Ext.chart.Chart', {
    animate: true,
    flex: 1,
    shadow: true,
    store: barstore,
    axes: [{
        type: 'Numeric',
        position: 'left',
        fields: ['Total'],
        minimum: 0,
        hidden: true
    }, {
        type: 'Category',
        position: 'bottom',
        fields: ['Usuario'],
        label: {
            font: '9px Arial',
            rotate: {
                degrees: 270
            }
        }
    }], 
    series: [{
        type: 'column',
        axis: 'left',
        highlight: true,
        style: {
            fill: '#456d9f'
        },
        highlightCfg: {
            fill: '#a2b5ca'
        },
        label: {
            contrast: true,
            display: 'insideEnd',
            field: 'Total',
            color: '#000',
            orientation: 'horizontal',
            'text-anchor': 'middle'
        },
        xField: ['Usuario'],
        yField: ['Total']
    }]
});

var reportpanel = Ext.create('Ext.tab.Panel', {
    height: 400,
    id: 'report',
    items: [{
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [linegrid],
        layout: 'fit',
        title: 'Datos Gráfico # 1'
    },{
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [linechart],
        layout: 'fit',
        title: 'Gráfico # 1'
    }, {
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [piechart],
        layout: 'fit',
        title: "Gráfico # 2"
    }, {
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [bargrid, {
            xtype: 'panel',
            bodyPadding: 5,
            height: 335,
            items: [minipiechart],
            layout: 'fit',
            title: 'Mensajes Envíados',
            width: 365
        }],
        layout: 'hbox',
        title: "Datos Gráfico # 3"
    }, {
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [barchart],
        layout: 'fit',
        title: 'Gráfico # 3'
    }],
    width: 900
});