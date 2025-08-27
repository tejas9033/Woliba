<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Woliba Wellness Invite</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f4f7fa;
                margin: 0;
                padding: 0;
                color: #333;
            }

            .email-wrapper {
                max-width: 650px;
                margin: auto;
                background-color: #ffffff;
                /* padding: 40px; */
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            }

            h2 {
                color: #2c3e50;
            }

            .cta-button {
                display: inline-block;
                padding: 14px 28px;
                background-color: orangered;
                color: #fff !important;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
                margin: 20px 0;
            }

            .footer {
                font-size: 14px;
                color: #777;
                margin-top: 30px;
            }

            .store-buttons img {
                height: 70px;
                margin-right: 10px;
            }

            .social-icons {
                display: flex;
                gap: 10px;
                margin-top: 10px;
            }

            .social-icons div {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: white;
                text-align: center;
            }

            .social-icons img {
                width: 30px;
                height: 30px;
            }

            .social-icons img:hover {
                transform: scale(1.05);
            }
        </style>
    </head>

    <body>
        <div class="email-wrapper">
            <div style="padding: 40px; padding-bottom: 0;">
                <div style="text-align: center">
                    <h1>WOLIBA</h1>
                </div>
                <h2><b>Hi {{ $firstName }},</b></h2>
                <p>Here is your one time password(OTP).
                    <br>Please use the verification code below o sign in for Woliba.
                    <br>OTP will be expired in 5 minutes.
                </p>

                <div style="text-align:center; margin:20px 0;">
                    <table role="presentation" cellpadding="8" cellspacing="5" align="center">

                        @foreach(str_split(strval($otp)) as $no)
                        {{-- <div style="padding: 10px; background: lightblue; color: blue; margin: 2%;"> --}}
                        <td
                            style="background: lightblue; border:2px solid #ddd; border-radius:6px; width:30px; height:30px; text-align:center; font-size:15px; font-weight:bold; color:#333;">

                            {{ $no }}
                        </td>
                        @endforeach
                    </table>
                </div>

                <p>If you didn't request this, you can ignore this email.</p>

                <p style="margin-top: 30px;">In Health & Wellness,<br><strong>The Woliba Team</strong></p>
            </div>

            <div class="footer" style="width: 100%; background: rgb(13, 55, 95);">
                <div style="padding: 30px; color: #FFF; display: flex">
                    <div style="float: left; width: 50%;">
                        <p>Contact US<br> <a href="mailto:support@woliba.io" style="color: #FFF">support@woliba.io</a>
                        </p>
                        <p>Follow us:</p>
                        <div class="social-icons">
                            <div href="#"><img src="https://cdn-icons-png.flaticon.com/512/665/665209.png"
                                    alt="Facebook">
                            </div>
                            <div href="#"><img src="https://cdn-icons-png.flaticon.com/512/15522/15522333.png"
                                    alt="Youtube">
                            </div>
                            <div href="#"><img src="https://cdn-icons-png.flaticon.com/512/665/665228.png"
                                    alt="Twitter">
                            </div>
                            <div href="#"><img src="https://cdn-icons-png.flaticon.com/512/665/665212.png"
                                    alt="Linkedin">
                            </div>
                            <div href="#"><img src="https://cdn-icons-png.flaticon.com/512/15522/15522253.png"
                                    alt="Instagram">
                            </div>
                        </div>
                    </div>
                    <div style=" float: right; width: 50%; margin-right: 5%;">
                        <div class="store-buttons" align="right">
                            <a href="#">
                                <img style="width: 200px;"
                                    src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
                                    alt="Google Play">
                            </a><br>
                            <a href="#">
                                <img style="width: 200px;"
                                    src="{{ asset('assets/images/apple.svg') }}"
                                    alt="App Store">
                                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
