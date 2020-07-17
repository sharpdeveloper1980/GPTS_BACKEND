@include('emails.header')
	<h1>Welcome to Crimson</h1>
	<table class="main">
	  <!-- START MAIN CONTENT AREA -->
	  <tr>
		<td class="wrapper">
		  <table border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td>
				<p>Hi {{ $name }},</p>
				<p>{{ $title }}</p>
				<p>Please click below and use following credentials to login on our website.</p>
				<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
				  <tbody>
					<tr>
					  <td align="center"> 
						<table border="0" cellpadding="0" cellspacing="0">
						  <tbody>
							<tr>
							  <td> <a href="{{ url('/administrator') }}" target="_blank">Login</a> </td>
							</tr>
						  </tbody>
						</table>
					  </td>
					</tr>
				  </tbody>
				</table>
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>

	<!-- END MAIN CONTENT AREA -->
	</table>
@include('emails.footer')