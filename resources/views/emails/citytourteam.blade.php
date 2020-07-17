@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

                <tr style="padding:30px 30px 10px 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 14px; margin-bottom: -35px;">
                    <td>Hi there,</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                       You have received a new registration in CDAP 10 city tour. Please see the details below.
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;">
                     <table border='1' width="80%">
                            <tr><th>Name</th><td>{{ $name }}</td></tr>
                            <tr><th>Email Id</th><td>{{ $email }}</td></tr>
                            <tr><th>School Name</th><td>{{ $school }}</td></tr>
                            <tr><th>City</th><td>{{ $city }}</td></tr>
                            <tr><th>Contact No.</th><td>{{ $contact }}</td></tr>
                            <tr><th>No. of Guest</th><td>{{ $noofguest }}</td></tr>
                    </table>
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
