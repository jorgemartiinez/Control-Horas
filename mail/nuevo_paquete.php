<?php session_start() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Alta nuevo paquete </title>
    <meta charset="utf-8">
    <meta name=GENERATOR content="MSHTML 9.00.8112.16443">
    <style type="text/css">
        <!--
        img { border:0; }
        img a{ border:hidden; }
        -->
    </style>
</head>

<body style="margin: 0; padding: 0; font-size:9px;">

<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr>
        <td>
            <table border="0" cellspacing="0" cellpadding="0" align="center" width="600" style="font-family:Arial, Helvetica, sans-serif; max-width:600px; font-size:12px; margin-top:20px; ">

                <tr style="background: #566676;">
                    <td style="width:300px; padding: 5px 0" align="center">
                        <?php if(isset($_SESSION['config']['logo']) && $_SESSION['config']['logo'] != ''){ ?>
                            <img src="<?=$GLOBALS['config']['rutaAbsoluta'].'/uploads/logo/'.$_SESSION['config']['logo'] ?>" alt="Logo Empresa" width="150">
                        <?php }?>
                    </td>
                    <td align="center" style="width:300px;">
                        <p style="color:#fff;  font-size:14px; ">
                            Control de <strong>horas de trabajo</strong>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <p style="border-bottom:1px dotted #000; border-width:1px; border-color:#000; width:600px; margin:5px"></p>
                    </td>
                </tr>

            </table>


            <table border="0" align="center" width="600" style="font-family:Arial, Helvetica, sans-serif; max-width:600px; font-size:18px; margin-top:10px;">

                <tr>
                    <td width="600" align="center"><strong>Nuevo pack horas</strong></td>
                    <td></td>
                </tr>
            </table>

            <table border="0" align="center" width="600" style="font-family:Arial, Helvetica, sans-serif; max-width:600px; font-size:18px; margin-top:20px;">

                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size:14px; line-height:1.2;">
                        ¡Hola <span style="color:#000;"><strong> <?php echo $toName ?></strong>!<br /><br />

                            Con este e-mail le confirmamos que ha adquirido un <strong>nuevo pack de horas</strong> correctamente. <br /><br />

                            Información sobre el <strong>nuevo paquete</strong>: <br/>
                            <strong>Horas:</strong> <?php echo $numHoras ?><br />
                            <strong>Caducidad:</strong> <?php echo $fechaCaducidad?><br /><br />
                            Le agradecemos su confianza en nuestro trabajo.<br /><br />

                            Saludos.<br />
                    </td>
                </tr>

            </table>

            <table border="0" align="center" width="600" style="margin-top:20px;">

                <tr>
                    <td colspan="2">
                        <p style="border-bottom:1px dotted #000; border-width:1px; border-color:#000; width:600px; margin 5px;"></p>
                    </td>
                </tr>

            </table>

            <table border="0" align="center" width="600" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; margin-top:2px;">

                <tr>
                    <td align="left" width="300"><a href="mailto: <?php if(isset($_SESSION['config'])){ if($_SESSION['config']['footer-email']!='empresa@email.com' ||$_SESSION['config']['footer-direccion']!='' ){echo $_SESSION['config']['footer-email'];}?>" style="color:#36a9e1;"> <?php if($_SESSION['config']['footer-email']!='empresa@email.com' ||$_SESSION['config']['footer-direccion']!='' ){echo $_SESSION['config']['footer-email'];}} ?></a></td>
                    <td align="right" style="color:#585757;"> <?php if(isset($_SESSION['config'])){ if($_SESSION['config']['footer-direccion']!='Dirección Empresa' ||$_SESSION['config']['footer-direccion']!='' ){echo $_SESSION['config']['footer-direccion'];}}?></td>
                </tr>

            </table>

    </tr>
    </td>
</table>

</body>
</html>