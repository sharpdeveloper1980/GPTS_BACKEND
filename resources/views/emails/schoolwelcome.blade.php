@include('emails.header2')
<table border="0" width="700" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border: 1px solid #e5e5e5;margin: auto;" class="email-container">
    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="border-bottom: 1px solid #e5e5e5;">
            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

                <tr style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 22px; color: #444444;padding-left: 30px;
                    display: block; font-size: 14px; margin-bottom: -35px;">
                    <td> Respected {{$contactPerson}} </td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                        display: block;">
                            Greetings from Great Place To Study.
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;"> 
                        We would like to welcome you and your prestigious institution, <strong>{{$school}}</strong> on board with Great Place To Study. We are excited that you have elected to be a part of the Career Discovery and Acceleration Platform (CDAP). Together we can empower students and give them new opportunities to explore and learn in an environment enriched with support, encouragement and assistance.
                            
                    </td>   
                </tr>
        
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;"> 
                            With a single positive move, you have taken your first step towards joining a league of pre-eminent education institutions that are spearheading change in the education sector across the globe. It is vital for students get a fair chance to decide their future. We believe that empowering young minds with the right information and support can help them chart new pathways towards a successful career.                        
                    </td>   
                </tr>
                <tr>
                    <td style="padding: 10px; font-family: sans-serif; font-size: 14px; line-height: 22px; color: #444444;padding-left: 30px;
                            display: block; text-align:justify;padding-right: 30px;"> 
                        The CDAP programme has been designed to offer students an opportunity to seek focused guidance from experienced counsellors, inspiring them to embark on a journey to realise their dreams. CDAP gives budding minds access to inside information on a plethora of career paths from experienced industry experts to create a roadmap for a promising future. It also offers insight into student suitability towards work styles, occupations and career profiles, enabling them to explore diverse career prospects at a very young age.                            
                        <br><br>
                        <p>WELCOME ABOARD!<br><br></p>
                        <p>Regards,<br>Great Place to Study Team</p>
                    </td>   
                </tr>              
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->
</table>
@include('emails.footer2')