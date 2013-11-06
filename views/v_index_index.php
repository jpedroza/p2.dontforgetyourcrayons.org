<?php if($user): ?>

		<pre>
			<?php
				print_r($user);
			?>	
		</pre>
        What's Up <?=$user->first_name;?>
<?php else: ?>
        Our Casa, is your Casa. So kick your shoes off. Sign up or Log in, your choice.
<?php endif; ?>