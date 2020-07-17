@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                       Hi {{$name}},
                        <br>
                <br>
                <br>
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                       Thank you for registartion with GPTS The 10 City Tour.
                    </td>   
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')