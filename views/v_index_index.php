
<!-- if the user is logged in, then we give a personalized greeting-->
<?php if($user): ?>


        <h3>I hope you are having a Great Day, <?=$user->first_name;?></h3>
<?php else: ?>
<!-- if the user is not logged in then explain what the website is all about -->
	<h2>This is a very tiny Microblog platform for those who are a bit more casual and laid back.</h2>
	<p>
	First we are gonna need some basic user information to get you signed up and going, then you can chat away.
	Our Casa, is your Casa. So kick your shoes off. Sign up or Log in, your choice.
	</p>
	<h3>My Plus One Features are listed below:</h3>
    <ol>
	<li class='features'>The capability to update the user profile</li>
	<li class='features'>The capability to upload a graphic for the profile image</li>
	<li class='features'>Aside: Originally, I wanted to send an email confirmation; however, Gmail blocked this as a suspicious activity-so it doesn't work exactly...
	</ol>
		
<?php endif; ?>