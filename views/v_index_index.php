
<!-- if the user is logged in, then we give a personalized greeting-->
<?php if($user): ?>


        I hope you are having a Great Day, <?=$user->first_name;?>
<?php else: ?>
<!-- if the user is not logged in then explain what the website is all about -->
	<h2>This is a very tiny Microblog platform for those who are a bit more casual and laid back.</h2>
	<p>
	First we are gonna need some basic user information to get you signed up and going, then you can chat away.
	</p>
        Our Casa, is your Casa. So kick your shoes off. Sign up or Log in, your choice.
<?php endif; ?>