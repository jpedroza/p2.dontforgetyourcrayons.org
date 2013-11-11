<h2>Sign Up</h2>

<form method='POST' action='/users/p_signup'>

        First Name <input type='text' name='first_name' /><br>
        Last Name <input type='text' name='last_name' /><br>
        Email <input type='text' name='email' /><br>
        Password <input type='password' name='password' /><br>
		<!-- added new fields short bio, time zone, and location -->
		Timezone <input type='text' name='timezone' /><br>
		Location <input type='text' name='location' /><br>
		Tell Us A Few Words About Yourself <textarea rows="5" cols="100" name="aboutyou"></textarea><br>
        <input type='submit' value='Sign Up' />
        

</form>