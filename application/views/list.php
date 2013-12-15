
<?php if(isset($count)): ?>
	you have <?php echo $count; ?> articles in your list
<?php endif; ?>

<ol>
<?php foreach($list as $key=>$value): ?>
	<li><?php echo $value->item_id ?> - <?php echo $value->resolved_title ?></li>
<?php endforeach; ?>
</ol>
