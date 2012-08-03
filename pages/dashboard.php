<!DOCTYPE html>
<?php
/**
 * @author: César Bolaños [cbolanos]
 */
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
                    centerpanel.doLayout();
                    centerpanel.forceComponentLayout();
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
                            <a href="#"><span>Reportes</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Administración</span></a>
                        </li>
                    </ul>
                </div>
                <div id="user">
                    <ul>
                        <li>
                            <a href="#"><span>César Bolaños</span></a>
                            <ul style="display: none;">
                                <li>
                                    <a href="#"><span>Salir</span></a>
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