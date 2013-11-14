<h2>Sign On Up!</h2>

<form method='POST' action='/users/p_signup'>
		<h3>We are glad you could take time out of your busy schedule to Join US.</h3>
		<h3>All fields must be filled in to start an account!</h3>
		
		<!-- Added this line to show the dafault Simpson png before the db default for the photo field just puts in the default image -->  
		<label>Photo</label> <img src="/uploads/pic.png" /><br>
		<label>*once you are signed up, you can edit your profile and upload a better photo</label><br /> <br />
        <label>First Name</label> <input type='text' name='first_name' /><br />
        <label>Last Name</label> <input type='text' name='last_name' /><br />
        <label>Email</label> <input type='text' name='email' /><br />
        <label>Password</label> <input type='password' name='password' /><br />
		<!-- added new fields short bio, time zone, and location -->
		<label>Timezone</label> <input type='text' name='timezone' /><br />
		<label>Location</label> <input type='text' name='location' /><br />
		<label>Tell Us A Few Words About Yourself</label> <br />
		<textarea rows="5" cols="70" name="aboutyou"></textarea><br />
        <input type='submit' value='Sign Up' />
        

</form>