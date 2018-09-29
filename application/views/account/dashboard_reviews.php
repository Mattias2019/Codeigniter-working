<?php if (isset($reviews)) foreach ($reviews as $review) { ?>
	<li class="reviews-item">
		<h4 class="reviews-author"><?php echo $review['reviewer_name']; ?></h4>
		<p class="reviews-body"><?php echo character_limiter($review['comments'], 100); ?></p>
		<p class="reviews-body-full hidden"><?php echo $review['comments']; ?></p>
	</li>
<?php } ?>