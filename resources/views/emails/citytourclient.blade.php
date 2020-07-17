@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

                <tr style="padding:30px 30px 10px 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 14px; margin-bottom: -35px;">
                    <td>Dear {{ $name }},</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                        Thank you for registering with us for our Future Readiness Summit.<br>We would be more than happy to host you at our summit in <b>{{ $address }}</b> on <b><i>{{ $date }}</i></b>. The summit is aimed to make sure we understand how we can our young generations future ready.
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                        In case of any queries please feel free to get in touch with us on +91 - 8800659818
                        <br><br>
                        <p>Regards,<br>Team Great Place To Study</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')
