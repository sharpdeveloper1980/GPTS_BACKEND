@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

                <tr style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 20px; margin-bottom: -35px;">
                    <td> Welocme to GPTS! We are excited to have you on board. </td>
                </tr>
                <tr>
                    <td style="padding: 30px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;">
                        Now let's get you started by taking you to your Personalised Dashboardand jump start your career journey!
                        <br>

                        You will be getting the following things in the dashboard: 
                        <br>
                </tr>
                <tr>
                    <td style="padding: 30px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;"> 
                        <b>1. Career Discovery Assessment</b><br>
                        <i>Take the innovative self-report strength based assessment that is specifically designed to understand your passion, dreams, strengths and limitations.</i>
                    </td>   
                </tr>
                 <tr>
                    <td style="padding: 30px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;"> 
                        <b>2.  Video Career Library</b><br>
                        <i>Access 200+ careers videos and get information on everything, from expert insight to fresher reviews about different career fields. </i>
                    </td>   
                </tr>
                <tr style="
                    padding-left: 30px;
                    display: block;
                    padding-top: 7em;
                    padding-bottom: 7em;
                    ">
                    <td style="-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background-color: #2853b5;text-align: center;width: 200px;display: block;">
                        <a href="{{$loginlink}}" style="color: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; text-align: center; text-decoration: none; display: block; padding: 15px 20px; border: 1px solid #333333; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;"> <b>
                                <!--[if mso]>&nbsp;<![endif]-->Go to my dashboard
                                <!--[if mso]>&nbsp;<![endif]--></b> </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')