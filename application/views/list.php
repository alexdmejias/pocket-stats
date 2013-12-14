<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?php echo site_url('/public_html/styles.css'); ?>">

</head>
<body>

<div id="container">
	<?php if(isset($count)): ?>
		you have <?php echo $count; ?> articles in your list
	<?php endif; ?>

<ol>
<?php foreach($list as $key=>$value): ?>
	<li><?php echo $value->item_id ?> - <?php echo $value->resolved_title ?></li>
<?php endforeach; ?>
</ol>

</body>
</html>