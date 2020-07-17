@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">


                <tr>
                    <td style="padding: 9px 7px 3px 12px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                       Hi Team,

                        <br>
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 12px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                     There is new product request from {{$name}}  
                    </td>   
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 12px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                        Kindly find their information below:- 
                        <br>
                        Contact No          :- {{$contact}}
                        <br>
                        Email Id            :- {{$email}}
                        <br>
                        Hear About Us From  :- {{$email}}
                        <br>
                        Looking For         :- {{$lookingFor}}
                    </td>   
                </tr>
                <tr>
                   <td style="padding: 9px 7px 3px 12px;font-family: sans-serif;font-size: 14px;line-height: 22px;color: #444444;display: block;">
                     Message                :- {{$msg}}
                     <br/><br/>
                     Thanks & Regards<br/>
                     GPTS Team<br/>
                    </td>   
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')