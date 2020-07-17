@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">


                <tr>
                    <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                       Hi Sir,

                        <br>
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                     There is new contact request from {{$name}}  
                    </td>   
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                     Contact Detail :- 
                     <br>
                     Contact No :- {{$contact}}<br>
                     Email Id :- {{$email}}
                    </td>   
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 7px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                     Message :- 
                     <br>
                    {{$msg}}
                    </td>   
                </tr>
               

            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')