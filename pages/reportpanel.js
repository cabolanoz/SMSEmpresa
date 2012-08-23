/**
 * @author: César Bolaños [cbolanos]
 */

var linestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['Fecha', 'Claro', 'Movistar'],
    storeId: 'linestore'
});

var linechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'right'
    },
    shadow: true,
    store: linestore,
    theme: 'Category1',
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

var piestore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['name', 'value'],
    storeId: 'piestore'
});

var piechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    insetPadding: 60,
    legend: {
        position: 'right'
    },
    series: [{
        donut: false,
        field: 'value',
        highlight: {
            segment: {
                margin: 20
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

var reportpanel = Ext.create('Ext.tab.Panel', {
    height: 400,
    id: 'report',
    items: [{
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [linechart],
        layout: 'fit',
        title: 'Reporte # 1'
    }, {
        xtype: 'panel',
        bodyPadding: 5,
        height: 400,
        items: [piechart],
        layout: 'fit',
        title: "Reporte # 2"
    }],
    width: 900
});