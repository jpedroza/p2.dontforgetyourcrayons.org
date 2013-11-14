<?php if(isset($user)): ?> 
        <h1>This is the profile for <?=$user->first_name?></h1>
<?php else: ?>
        <h1>Log back in, something went wrong.</h1>
<?php endif; ?>
<?php $photostr ="/uploads/" . $user->photo ?>



<form method='POST' enctype="multipart/form-data" action='/users/p_editprofile'>

		<img src=<?=$photostr?> /><br>
		<!-- show the current photo or threaten with "Rick Roll"--way too harsh!!! -->
		<label>Upload a new Picture</label><br />
		<!-- added a file to store the path to the uploaded photo -->
		<input type='file' name='photo' id='photo'/><br />
        <label>First Name</label> <input type='text' name='first_name' value="<?=$user->first_name?>" /><br />
        <label>Last Name</label> <input type='text' name='last_name' value="<?=$user->last_name?>"/><br />
        <!-- added new fields short bio, time zone, and location -->
		<label>Timezone</label> <input type='text' name='timezone' value="<?=$user->timezone?>"/><br />
		<label>Location</label> <input type='text' name='location' value="<?=$user->location?>"/><br />
		<label>Tell Us A Few Words About Yourself</label> <br />
		
		<textarea rows="5" cols="70" name="aboutyou" ><?=$user->aboutyou?></textarea><br />
        <input type='submit' value='Save Changes to my Profile' />
		
		<a href="/"><button type="button">Cancel Changes</button></a>
		<h3>If you put in blank space for any field, the changes will not be entered</h3>
        

</form>