<?php if(isset($user)): ?> 
        <h1>This is the profile for <?=$user->first_name?></h1>
<?php else: ?>
        <h1>Log back in, something went wrong.</h1>
<?php endif; ?>

<form method='POST' action='/users/p_editprofile'>

        First Name <input type='text' name='first_name' value="<?=$user->first_name?>" /><br>
        Last Name <input type='text' name='last_name' value="<?=$user->last_name?>"/><br>
        <!-- added new fields short bio, time zone, and location -->
		Timezone <input type='text' name='timezone' value="<?=$user->timezone?>"/><br>
		Location <input type='text' name='location' value="<?=$user->location?>"/><br>
		Tell Us A Few Words About Yourself <textarea rows="5" cols="70" name="aboutyou" ><?=$user->aboutyou?></textarea><br>
        <input type='submit' value='Save Changes to my Profile' />
        

</form>