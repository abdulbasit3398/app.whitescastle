<!DOCTYPE html>
<html lang="nl">


  <head>
 <title>Welkom bij Bolbooks</title>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <style type="text/css">


        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }


        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }


        img { -ms-interpolation-mode: bicubic; }




        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }


        table { border-collapse: collapse !important; }


        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }




        a[x-apple-data-detectors] {


            color: inherit !important;


            text-decoration: none !important;


            font-size: inherit !important;


            font-family: inherit !important;


            font-weight: inherit !important;


            line-height: inherit !important;


        }




        u + #body a {


            color: inherit;


            text-decoration: none;


            font-size: inherit;


            font-family: inherit;


            font-weight: inherit;


            line-height: inherit;


        }




        #MessageViewBody a {


            color: inherit;


            text-decoration: none;


            font-size: inherit;


            font-family: inherit;


            font-weight: inherit;


            line-height: inherit;


        }






        a { color: #175ADE; font-weight: 600; text-decoration: underline; }


        a:hover { color: #000000 !important; text-decoration: none !important; }


        a.button:hover { color: #ffffff !important; background-color: #0949C6 !important; }






        @media screen and (min-width:600px) {


            h1 { font-size: 48px !important; line-height: 48px !important; }


            .intro { font-size: 24px !important; line-height: 36px !important; }


        }


    </style>


  </head>


  <body style="margin: 0 !important; padding: 0 !important;">




    <div role="article" aria-label="Een email van Bolbooks" lang="nl" style="background-color: white; color: #2b2b2b; font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 28px; margin: 0 auto; max-width: 720px; padding: 40px 20px 40px 20px;">






        <header>




            <a href="#">


                <center><img src="{{asset('assets/admin/images/logo-whitecastle.jpg')}}" alt="" height="50" width="110"></center>


            </a>






             


        </header>




        <main>






            <!-- <a href="https://bolbooks.nl"><img alt="" src="https://bolbooks.nl/media/img/welkom" width="600" border="0" style="border-radius: 4px; display: block; max-width: 100%; min-width: 100px; width: 100%;"></a> -->






            <h2 style="color: #000000; font-size: 28px; font-weight: 600; line-height: 32px; margin: 48px 0 24px 0; text-align: center;">


                Password Reset


            </h2>


            <p>


                You are receiving this email because we received a password reset request for your account. Use this OTP to reset your password.
                <h2 style="color: #000000; font-size: 28px; font-weight: 600; line-height: 32px; margin: 14px 0 14px 0; text-align: center;">


               {{$reset_otp}}


            </h2>
                <br>
                If you did not request a password reset, no further action is required.
            <br>
            Regards,
            <br>
            {{env('APP_NAME')}}


            </p>






            <center>


                <div style="margin: 48px 0;"><!--[if mso]>


                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://litmus.com/community" style="height:60px;v-text-anchor:middle;width:300px;" arcsize="10%" stroke="f" fillcolor="#B200FD">


                <w:anchorlock/>


                <center>


                <![endif]-->


                 


                <!--[if mso]>


                </center>


                </v:roundrect>


                <![endif]--></div>


            </center>


        </main>




        <footer bgcolor="#000000">




            <center>

 




            </center>


           
        </footer>






    </div>


    <!--[if (gte mso 9)|(IE)]>


    </td></tr></table>


    <![endif]-->


  </body>


</html>