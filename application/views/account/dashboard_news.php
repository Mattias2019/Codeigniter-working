<?php if (isset($news)) foreach ($news as $new) { ?>
	<li class="news-item">
		<p class="news-time"><?php echo date('Y/m/d h:i', $new['time']); ?></p>
		<h4 class="news-title"><?php echo $new['title']; ?></h4>
		<p class="news-body"><?php echo character_limiter($new['body'], 100); ?></p>
		<p class="news-body-full hidden"><?php echo $new['body']; ?></p>
	</li>
<?php } ?>