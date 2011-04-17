Here are the posts:<br /><br />
<?php foreach ($vars['posts'] as $post) : ?>
	<?php $post_uri = sprintf('%s/posts/view/%u', dirname($_SERVER['PHP_SELF']), $post['_id']) ?>
	<a href="<?php echo $post_uri ?>"><?php echo $post['title'] ?></a> by <?php echo $post['author'] ?><br />
<?php endforeach ?>
