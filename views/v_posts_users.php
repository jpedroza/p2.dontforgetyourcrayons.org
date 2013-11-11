<?php foreach($users as $user): ?>
<!-- the list generates the users to follow -->

        <?=$user['first_name']?> <?=$user['last_name']?><br>
        
        <?php if(isset($connections[$user['user_id']])): ?>
                <a href='/posts/unfollow/<?=$user['user_id']?>'><button type="button">Unfollow - Lose That Clown"</button><img src="/losethatclown.png" /></a>
        <?php else: ?>
                <a href='/posts/follow/<?=$user['user_id']?>'><button type="button">Follow - Snoop Around a Bit</button><img src="/snoop.png" /></a>
        <?php endif; ?>        
        
        <br><br>

<?php endforeach ?>

<!-- src="images/stack.png">