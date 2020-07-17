@include('emails.header')
	<h1>Password Changed</h1>
	<table class="main">
	  <!-- START MAIN CONTENT AREA -->
	  <tr>
		<td class="wrapper">
		  <table border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td>
				<p>Hi, {{ $name }},</p>
				<p>Your password has been changed for Crimson Admin. please find your password below.</p>
				<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
				  <tbody>
					<tr>
					  <td align="center">
						<table border="0" cellpadding="0" cellspacing="0">
						  <tbody>
							<tr>
							  <td>{{$msg}}.Your new  password is :- {{$password}}</td>
							</tr>
						  </tbody>
						</table>
					  </td>
					</tr>
				  </tbody>
				</table>
				<p>If you have any questions or concerns, feel free to contact me at info@crimson.com or 9999999999.</p>
				<p>Good luck!</p>
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>

	<!-- END MAIN CONTENT AREA -->
	</table>
@include('emails.footer')