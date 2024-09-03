<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <title>Nabella Welcome Email</title>
    <style>
        /* Basic Reset */
        body, p, h1, h2, h3 {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            font-family: 'Helvetica', 'Arial', sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse;
            width: 80%;
        }

        img {
            display: block;
            border: 0;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        /* Global Styles */
        .es-wrapper {
            background-color: #ffffff;
            width: 100%;
            height: 100%;
            padding: 0;
        }

        .es-content-body, .es-footer-body {
            background-color: #ffffff;
        }

        .es-header {
            background-color: transparent;  
            width: 80%;
            text-align: center;
        }

        .es-header-body, .es-footer-body {
            background-color: transparent;
        }

        .es-button {
            display: inline-block;
            background: #bf2b62;
            border-radius: 20px;
            color: #ffffff;
            font-family: 'Roboto', 'Arial', sans-serif;
            font-size: 17px;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            border: 0;
        }

        h1, h2, h3 {
            font-family: 'Roboto', 'Helvetica Neue', 'Arial', sans-serif;
            color: #333333;
            line-height: 120%;
        }

        p, ul, ol, a {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 150%;
            color: #333333;
            text-decoration: none;
        }

        .es-footer-body p {
            color: #ffffff;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 30px;
                text-align: center;
            }

            h2 {
                font-size: 26px;
                text-align: center;
            }

            h3 {
                font-size: 20px;
                text-align: center;
            }

            p, ul li, ol li, a {
                line-height: 150%;
                font-size: 14px;
            }

            table{
                width: 100%;
            }

            .es-adapt-td {
                display: block;
                width: 100%;
            }

            .adapt-img {
                width: 100%;
                height: auto;
            }
        }

    </style>
</head>

<body>
    <div class="es-wrapper">
        <table class="es-header" align="center">
            <tr>
                <td align="center">
                    <table class="es-header-body" align="center" >
                        <tr>
                            <td align="center">
                                <a href="https://viewstripo.email" target="_blank">
                                    <img src="https://www.solracdev.online/assets/img/logo_nabella.png" alt="Nabella Logo" width="154">
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="es-content" align="center">
            <tr>
                <td align="center">
                    <table class="es-content-body" align="center"  style="background-color: #fcfcfc; border-radius: 3px;">
                        <tr>
                            <td align="left" style="padding: 30px 20px 10px;">
                                <h2>Hi {{ $user->name }}</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 10px 20px;">
                                <p>
                                We recieved a request to reset your password. If you did not request a password reset, please ignore this email.<br>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 20px;">
                                <table width="100%" style="background-color: #ffffff; border: 1px solid #efefef; border-radius: 3px;">
                                    <tr>
                                        <td align="center" style="padding: 20px 15px;">
                                            <p>For resetting your password, please click the button below:</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding: 20px;">
                                            <a href="{{ route('reset') }}" class="es-button">Reset Password</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="es-content" align="center">
            <tr>
                <td align="center">
                    <table class="es-content-body" align="center"  style="background-color: #fff4f7;">
                        <tr>
                            <td align="center" style="padding: 20px 10px 5px; background-color: #0e8d9d;">
                                <h3 style="color: #ffffff;">Let's get social</h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 10px; background-color: #0e8d9d;">
                                <table class="es-social" align="center">
                                    <tr>
                                        <td align="center" style="padding-right: 10px;">
                                            <a href="https://viewstripo.email" target="_blank">
                                                <img src="https://stripo.email/static/assets/img/social-icons/logo-white/facebook-logo-white.png" alt="Facebook" width="32">
                                            </a>
                                        </td>
                                        <td align="center" style="padding-right: 10px;">
                                            <a href="https://viewstripo.email" target="_blank">
                                                <img src="https://stripo.email/static/assets/img/social-icons/logo-white/instagram-logo-white.png" alt="Instagram" width="32">
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="https://viewstripo.email" target="_blank">
                                                <img src="https://stripo.email/static/assets/img/social-icons/logo-white/youtube-logo-white.png" alt="YouTube" width="32">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="es-footer" align="center">
            <tr>
                <td align="center">
                    <table class="es-footer-body" align="center"  style="background-color: #666666;">
                        <tr>
                            <td align="center" style="padding: 20px; background-color: #0e8d9d;">
                                <p>Nabella App</p>
                                <p>192 Winding Creek Dr, Troutman, NC 28166</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>