@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr style="padding: 30px;font-family: sans-serif;font-size: 16px;line-height: 0px;color: #444444;padding-left: 30px;display: block;margin-bottom: -15px;font-size: 20px;font-weight: 500;">
                    <td>Hi {{$name}},</td>
                </tr>
                <tr style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 20px; margin-bottom: -35px;">
                    <td> Please reset your password</td>
                </tr>
                <tr>
                    <td style="padding: 30px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;"> Your reset password link is:-{{$token}}
                        <br>

                        <p>If you have any questions or concerns, feel free to contact me at info@crimson.com or 9999999999.</p>
                        <p>Good luck!</p>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')