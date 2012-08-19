<!DOCTYPE html>
<?php
/**
 * @author: César Bolaños [cbolanos]
 */
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
    header('Location: ./pages/dashboard.php');
    exit();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="js/ext-all.js" type="text/javascript"></script>
        <link href="js/resources/css/ext-all.css" rel="stylesheet" type="text/css"></link>
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
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
                                            method: 'GET',
                                            title: 'Inicio de Sesión',
                                            url: 'phpcode/login.php',
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
                                                    id: 'user',
                                                    name: 'user'
                                                },{
                                                    allowBlank: false,
                                                    blankText: 'Este campo es requerido',
                                                    fieldLabel: 'Contraseña',
                                                    id: 'password',
                                                    inputType: 'password',
                                                    name: 'password'
                                                }],

                                            buttons: [{
                                                    text: 'Acceder',
                                                    handler: function() {
                                                        var form = this.up('form').getForm();
                                                        if (form.isValid()) {
                                                            var user = Ext.getCmp('user');
                                                            var password = Ext.getCmp('password');
                                                            if (user.isValid() && password.isValid()) {
                                                                form.submit({
                                                                    params: {
                                                                        user: user.getValue(),
                                                                        password: password.getValue()
                                                                    },
                                                                    failure: function(form, action) {
                                                                        Ext.Msg.alert('Env&iacuteo de Mensajes', 'Usuario y/o contrase&ntildea incorrectos');
                                                                    },
                                                                    success: function(form, action) {
                                                                        window.location.href = './pages/dashboard.php';
                                                                    }
                                                                });   
                                                            } else {
                                                                user.reset();
                                                                password.reset();
                                                            }
                                                        }
                                                    }
                                                },{
                                                    text: 'Cancelar',
                                                    handler: function() {
                                                        this.up('form').getForm().reset();
                                                    }
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
