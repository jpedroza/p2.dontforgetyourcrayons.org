<h2>Sign On Up!</h2>

<form method='POST' action='/users/p_signup'>
		<h3>We are glad you could take time out of your busy schedule to Join US.</h3>
		<h4>All fields must be filled in to start an account!</h4>
		
		<!-- Added this line to show the dafault Simpson png before the db default for the photo field just puts in the default image -->  
		Photo <img src="/uploads/pic.png" /><br>
		*once you are signed up, you can edit your profile and upload a better png photo<br /> <br />
        First Name <input type='text' name='first_name' /><br />
        Last Name <input type='text' name='last_name' /><br />
        Email <input type='text' name='email' /><br />
        Password <input type='password' name='password' /><br />
		<!-- added new fields short bio, time zone, and location -->
		Timezone <input type='text' name='timezone' /><br />
		Location <input type='text' name='location' /><br />
		Tell Us A Few Words About Yourself <br />
		<textarea rows="5" cols="70" name="aboutyou"></textarea><br />
        <input type='submit' value='Sign Up' />
        

</form>