/**
 * @author: César Bolaños [cbolanos]
 */

var reportstore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['Fecha', 'Claro', 'Movistar'],
    storeId: 'reportstore'
});

var linechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'right'
    },
    shadow: true,
    store: reportstore,
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
            size: 4,
            radius: 4,
            'stroke-width': 0
        },
        xField: 'Fecha',
        yField: 'Claro'
    }, {
        type: 'line',
        axis: 'left',
        markerConfig: {
            type: 'circle',
            size: 4,
            radius: 4,
            'stroke-width': 0
        },        
        xField: 'Fecha',
        yField: 'Movistar'
    }]
})

var reportpanel = Ext.create('Ext.tab.Panel', {
    height: 400,
    items: [
    linechart,
    {
        bodyPadding: 10,
        title: 'Reporte # 2'
    }],
    width: 900
});