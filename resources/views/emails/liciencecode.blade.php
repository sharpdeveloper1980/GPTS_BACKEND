@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

                <tr style="padding:30px 30px 10px 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 14px; margin-bottom: -35px;">
                    <td> Hello {{$contactPerson}},</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;">
                           It is time to start your journey with us.
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
Students who enroll in the programme will get access to the highly extensive, diverse and infotaining video career library where they can get inspired by successful professionals, foresee insights of affluent working industries and also visualize the journey of a fresher who takes the first step towards a promising future.
                    </td>   
                </tr>
        
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                            &#34;Give your students the power to write their own destiny.&#34;
                    </td>   
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                    <b>Kindly take a look into the attached excel which carry all the unique student licenses. Each student should have its unique license as this will be used during the sign-up.<b>
                    </td>   
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;"> 
If you have any questions, please free to get in touch with us at <a href="mailto:info@greatplacetostudy.org?Subject=Product%20Related%20Queries" target="_top">info@greatplacetostudy.org</a>. Our team of experts at GPTS will be happy to help you with any queries you may have regarding our Career Discovery & Acceleration Platform.<br><br>
                        <p>Regards,<br>Team Great Place To Study</p>
                    </td>   
                </tr>              
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')