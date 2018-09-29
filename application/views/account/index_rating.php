<h2>Rank <span class="text-primary"><?php echo $this->outputData['rank']; ?></span> of <?php echo $this->outputData['all_rank']; ?></h2>

<div class="row">
	<div class="col-xs-12">
		<div class="dashboard border-top border-primary no-padding">

			<table class="table">
				<thead>
				<tr class="review-header">
					<th class="text-color-2 uppercase"><?= t('Total'); ?></th>
					<th class="text-color-2"><?php echo number_format($this->outputData['user']['user_rating'], 1); ?></th>
					<th>
						<input type="hidden" class="rating-value" value="<?php echo $this->outputData['user']['user_rating']; ?>"/>
						<div class="rating"></div>
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->outputData['rating_categories'] as $category) { ?>
					<tr style="background-color:#FFFFFF;">
						<td><?php echo $category['name']; ?></td>
						<td><?php echo number_format($category['rating'], 1); ?></td>
						<td>
							<input type="hidden" class="rating-value" value="<?php echo $category['rating']; ?>"/>
							<div class="rating"></div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>