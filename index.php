<!DOCTYPE html>
<?php
/**
 * @author: César Bolaños [cbolanos]
 */
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="js/ext-all.js" type="text/javascript"></script>
        <link href="js/resources/css/ext-all.css" rel="stylesheet" type="text/css"></link>
    </head>
    <body>
        <div align="center">
            <table>
                <tr>
                    <td align="center">
                        <form action="" id="login" method="post" name="login">
                            <div align="center" id="loginform">
                                <script type="text/javascript">
                                    Ext.onReady(function() {
                                        Ext.QuickTips.init();
                                        
                                        var loginform = Ext.create('Ext.form.Panel', {
                                            bodyStyle: 'padding:5px 5px 0',
                                            frame: true,
                                            title: 'Inicio de Sesión',
                                            width: 350,
                                            fieldDefaults: {
                                                msgTarget: 'side',
                                                labelWidth: 120
                                            },
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%'
                                            },
                                            
                                            items: [{
                                                allowBlank: false,
                                                blankText: 'Este campo es requerido',
                                                fieldLabel: 'Nombre de Usuario',
                                                name: 'first'
                                            },{
                                                allowBlank: false,
                                                blankText: 'Este campo es requerido',
                                                fieldLabel: 'Contraseña',
                                                name: 'last'
                                            }],

                                            buttons: [{
                                                text: 'Acceder'
                                            },{
                                                text: 'Cancelar'
                                            }]
                                        });
                                        
                                        loginform.render('loginform');
                                    });
                                </script>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
