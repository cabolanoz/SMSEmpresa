/**
 * @author: César Bolaños [cbolanos]
 */

var reportstore = Ext.create('Ext.data.Store', {
    autoLoad: false,
    fields: ['company', 'date', 'quantity'],
    storeId: 'reportstore'
});

var linechart = Ext.create('Ext.chart.Chart', {
    animate: true,
    legend: {
        position: 'right'
    },
    store: reportstore,
    axes: [{
        fields: ['quantity'],
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
        title: 'Cantidad de Mensajes',
        type: 'Numeric'
    }, {
        fields: ['company', 'date'],
        position: 'bottom',
        title: 'Período',
        type: 'Category'
    }],
    series: [{
        axis: 'left',
        type: 'line',
        xField: 'date',
        yField: 'quantity'
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