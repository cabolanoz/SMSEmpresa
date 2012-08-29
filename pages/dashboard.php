<!DOCTYPE html>
<?php
/**
 * @author: César Bolaños [cbolanos]
 */
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['password'])) {
    header('Location: ../index.php');
    exit();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../css/menustyle.css" rel="stylesheet" type="text/css"/>
        <link href="../js/resources/css/ext-all.css" rel="stylesheet" type="text/css"/>
        <script src="../js/ext-all.js" type="text/javascript"></script>
        <script src="../js/ext-all-debug.js" type="text/javascript"></script>
        <script src="../js/bootstrap.js" type="text/javascript"></script>
        <script src="welcomepanel.js" type="text/javascript"></script>
        <script src="sendmessagepanel.js" type="text/javascript"></script>
        <script src="customsendmessagepanel.js" type="text/javascript"></script>
        <script src="reportpanel.js" type="text/javascript"></script>
        <script type="text/javascript">
            function updateBodyPanel(val) {
                Ext.onReady(function() {
                    var centerpanel = Ext.getCmp('centerpanel');
                    centerpanel.removeAll(false);
                    if (val == 'home')
                        centerpanel.add(welcomepanel);
                    else if (val == 'claro') {
                        sendmessagepanel.setTitle("Env&iacuteo de Mensajes - Claro");
                        centerpanel.add(sendmessagepanel);
                    } else if (val == 'movistar') {
                        sendmessagepanel.setTitle("Env&iacuteo de Mensajes - Movistar");
                        centerpanel.add(sendmessagepanel);
                    } else if (val == 'custom')
                        centerpanel.add(customsendmessagepanel);
                    else if (val == 'report')
                        centerpanel.add(reportpanel);
                    centerpanel.doLayout();
                    centerpanel.forceComponentLayout();
                });
            }
            
            function showFloatableWindow() {
                Ext.onReady(function() {
                    Ext.create('Ext.window.Window', {
                        bodyPadding: 10,
                        buttons: [{
                                text: 'Ejecutar',
                                handler: function() {
                                    var begdate = Ext.getCmp('begdate');
                                    var enddate = Ext.getCmp('enddate');
                                    var isdaily = Ext.getCmp('daily').getValue() ? true : false;
                                    if (begdate.getValue() == null || enddate.getValue() == null) {
                                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'Debe seleccionar las fechas para la consulta');
                                        return;
                                    }
                                    
                                    if (enddate.getValue() < begdate.getValue()) {
                                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'La fecha de fin no puede ser menor que la fecha de inicio');
                                        return;
                                    }
                                    
                                    Ext.getCmp('reportwindow').close();
                                    Ext.Ajax.request({
                                        failure: function(o) {
                                            Ext.Msg.alert('Env&iacuteo de Mensajes', 'Ha ocurrido un error en la ejecuci&oacuten del reporte\nPor favor contacte al administrador del sistema');
                                        },
                                        method: 'GET',
                                        params: {
                                            firstdate: begdate.getRawValue(),
                                            seconddate: enddate.getRawValue(),
                                            isdaily: isdaily
                                        },
                                        success: function(o) {
                                            var response = Ext.decode(o.responseText);
                                            if (response.linedata.length == 0 || response.piedata.length == 0 || response.bardata.length == 0) {
                                                Ext.Msg.alert('Env&iacuteo de Mensajes', 'Sus criterios de selecci&oacuten no contienen resultados');
                                                return;
                                            }
                                            
                                            Ext.getCmp('report').setTitle('Del ' + begdate.getRawValue() + ' al ' + enddate.getRawValue());                                            
                                            Ext.data.StoreManager.lookup('linestore').loadData(response.linedata);
                                            Ext.data.StoreManager.lookup('piestore').loadData(response.piedata);
                                            Ext.data.StoreManager.lookup('barstore').loadData(response.bardata);
                                            
                                            updateBodyPanel('report');
                                        },
                                        url: '../phpcode/executereport.php'
                                    });
                                }
                            }, {
                                text: 'Cancelar',
                                handler: function() {
                                    Ext.getCmp('reportwindow').hide();
                                }
                            }],
                        height: 195,
                        id: 'reportwindow',
                        items: [{
                                xtype: 'datefield',
                                allowBlank: false,
                                fieldLabel: 'Desde',
                                format: 'd/m/Y',
                                id: 'begdate',
                                value: new Date()
                            }, {
                                xtype: 'datefield',
                                allowBlank: false,
                                fieldLabel: 'Hasta',
                                format: 'd/m/Y',
                                id: 'enddate',
                                value: new Date()
                            }, {
                                xtype: 'menuseparator' 
                            }, {
                                xtype: 'label',
                                text: 'Tipo de Reporte'
                            }, {
                                xtype: 'radio',
                                boxLabel: 'Diario',
                                checked: true,
                                id: 'daily',
                                inputLabel: 'daily',
                                name: 'reporttype'
                            }, {
                                xtype: 'radio',
                                boxLabel: 'Mensual',
                                id: 'monthly',
                                inputLabel: 'monthly',
                                name: 'reporttype'
                            }],
                        modal: true,
                        resizable: false,
                        title: 'Criterios del Reporte',
                        width: 288
                    }).show();
                });
            }
        </script>
        <title></title>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="user">
                    <li><a href="#"><?php echo $_SESSION['username'] ?></a></li>
                    <li><a href="../phpcode/logout.php">Salir</a></li>
                </div>
                <div id="corpse">
                    <script type="text/javascript">
                        Ext.onReady(function() {
                            var centerpanel = Ext.create('Ext.Panel', {
                                height: 400,
                                id: 'centerpanel',
                                items: [welcomepanel],
                                layout: 'fit',
                                region: 'center',
                                renderTo: 'corpse',
                                width: 900
                            });
                        });
                    </script>
                </div>
                <div id="nav">
                    <div class="catnav">	       
                        <ul class="nav">
                            <li><a href="javascript:onClick=updateBodyPanel('home')">Inicio</a></li>
                            <li><a href="#">Env&iacute;o de Mensajes</a>
                                <ul>
                                    <li><a href="javascript:onClick=updateBodyPanel('claro')">Claro</a></li>
                                    <li><a href="javascript:onClick=updateBodyPanel('movistar')">Movistar</a></li>
                                    <li><a href="javascript:onClick=updateBodyPanel('custom')">Personalizado</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Prefijos</a></li>
                            <li><a href="javascript:onClick=showFloatableWindow()">Reportes</a></li>
                            <li><a href="#">Administraci&oacute;n</a></li>   
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>