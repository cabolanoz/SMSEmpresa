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
        <link href="../js/resources/css/ext-all.css" rel="stylesheet" type="text/css"/>
        <script src="../js/ext-all.js" type="text/javascript"></script>
        <script src="../js/ext-all-debug.js" type="text/javascript"></script>
        <script src="../js/bootstrap.js" type="text/javascript"></script>
        <script src="welcomepanel.js" type="text/javascript"></script>
        <script src="sendmessagepanel.js" type="text/javascript"></script>
        <script src="reportpanel.js" type="text/javascript"></script>
        <script src="../ux/exporter/Exporter.js" type="text/javascript"></script>
        <script src="../ux/exporter/Button.js" type="text/javascript"></script>
        <script src="../ux/exporter/downloadify.min.js" type="text/javascript"></script>
        <script src="../ux/exporter/swfobject.js" type="text/javascript"></script>
        <script type="text/javascript">
            function updateBodyPanel(val) {
                Ext.onReady(function() {
                    var centerpanel = Ext.getCmp('centerpanel');
                    centerpanel.removeAll(false);
                    if (val == 0)
                        centerpanel.add(welcomepanel);
                    else if (val == 1)
                        centerpanel.add(sendmessagepanel);
                    else if (val == 2)
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
                                            seconddate: enddate.getRawValue()
                                        },
                                        success: function(o) {
                                            var response = Ext.decode(o.responseText);
                                            if (response.datas.length == 0) {
                                                Ext.Msg.alert('Env&iacuteo de Mensajes', 'Sus criterios de selecci&oacuten no contienen resultados');
                                                return;
                                            }
                                            
                                            updateBodyPanel(2);
                                        },
                                        url: '../phpcode/executereport.php'
                                    });
                                }
                            }, {
                                text: 'Cancelar',
                                handler: function() {
                                    Ext.getCmp('reportwindow').close();
                                }
                            }],
                        height: 132,
                        id: 'reportwindow',
                        items: [{
                                xtype: 'datefield',
                                allowBlank: false,
                                anchor: '150%',
                                fieldLabel: 'Desde',
                                format: 'd/m/Y',
                                id: 'begdate',
                                value: new Date()
                            }, {
                                xtype: 'datefield',
                                allowBlank: false,
                                anchor: '150%',
                                fieldLabel: 'Hasta',
                                format: 'd/m/Y',
                                id: 'enddate',
                                value: new Date()
                            }],
                        modal: true,
                        resizable: false,
                        title: 'Criterios del Reporte',
                        width: 290
                    }).show();
                });
            }
        </script>
        <title></title>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="nav">
                    <ul>
                        <li class="item_active">
                            <a href="javascript:onClick=updateBodyPanel(0)"><span>Inicio</span></a>
                        </li>
                        <li>
                            <a href="javascript:onClick=updateBodyPanel(1)"><span>Env&iacuteo de Mensajes</span></a>
                        </li>
                        <li>
                            <a href="javascript:onClick=showFloatableWindow()"><span>Reportes</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Administración</span></a>
                        </li>
                    </ul>
                </div>
                <div id="user">
                    <ul class="pureCssMenu pureCssMenum">
                        <li class="pureCssMenui">
                            <a class="pureCssMenui" href="#"><span><?php echo $_SESSION['username'] ?></span></a>
                            <ul class="pureCssMenum">
                                <li class="pureCssMenui">
                                    <a class="pureCssMenui" href="../phpcode/logout.php">Salir</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="bar"></div>
            <div id="corpse">
                <script type="text/javascript">
                    Ext.onReady(function() {
                        var centerpanel = Ext.create('Ext.Panel', {
                            height: 400,
                            id: 'centerpanel',
                            items: [welcomepanel],
                            region: 'center',
                            renderTo: 'corpse',
                            width: 900
                        });
                    });
                </script>
            </div>
        </div>
    </body>
</html>