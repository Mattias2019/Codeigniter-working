<!-- span inside a is used because third :before/:after pseudo-element is needed -->
<ul class="workflow-breadcrumbs">
    <?php if (isEntrepreneur() && $project['portfolio_id'] > 0) { ?>
    <li>
        <a href="<?= $stages[0]['url']; ?>"
           class="<?= $stages[0]['class_bg'].' '.$stages[0]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t('Search Machinery'); ?></span>
        </a>
    </li>
    <?php } ?>
	<li>
		<a href="<?= $stages[1]['url']; ?>"
		   class="<?= $stages[1]['class_bg'].' '.$stages[1]['class_border']; ?>">
            <?php if ($project['is_urgent'] == 1) { ?>
                <div class="workflow-ribbon urgent"><span><?= t('Urgent'); ?></span></div>
            <?php } ?>
			<?php if ($project['is_feature'] == 1) { ?>
                <div class="workflow-ribbon featured"><span><?= t('Featured'); ?></span></div>
			<?php } ?>
			<?php if ($project['is_hide_bids'] == 1) { ?>
                <div class="workflow-ribbon hide-bids"><span><?= t('Hidden'); ?></span></div>
			<?php } ?>
			<?php if ($project['is_private'] == 1) { ?>
                <div class="workflow-ribbon private"><span><?= t('Private'); ?></span></div>
			<?php } ?>
            <span class="breadcrumbs-content"><?= t($project['portfolio_id'] > 0 ? 'Quote Request' : (isEntrepreneur() ? 'Tender' : 'Search Tender')); ?></span>
        </a>
        <p class="breadcrumbs-subheader"><?= $project['enddate'] > 0 ? t('Tender Deadline').' '.date('d.m.Y', $project['enddate']) : ''; ?></p>
	</li>
	<li>
		<a href="<?= $stages[2]['url']; ?>"
		   class="<?= $stages[2]['class_bg'].' '.$stages[2]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t(isEntrepreneur() ? 'Get Quote' : 'Quote'); ?></span>
        </a>
        <p class="breadcrumbs-subheader"><?= count($project['quotes']).' '.t('quotes').', '.t('lowest').': '.currency().number_format($project['lowest_quote']); ?></p>
	</li>
	<li>
		<a href="<?= $stages[3]['url']; ?>"
		   class="<?= $stages[3]['class_bg'].' '.$stages[3]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t('Project'); ?></span>
        </a>
        <p class="breadcrumbs-subheader"><?= t('Milestone').' '.$project['current_milestone'].' '.t('of').' '.count($project['milestones']); ?></p>
	</li>
	<li>
		<a href="<?= $stages[4]['url']; ?>"
		   class="<?= $stages[4]['class_bg'].' '.$stages[4]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t('Payment'); ?></span>
        </a>
        <p class="breadcrumbs-subheader"><?= t('Paid').' '.currency().number_format($project['payment']['amount']).' '.t('of').' '.currency().number_format($project['payment']['amount'] + $project['payment']['due']); ?></p>
	</li>
	<li>
		<a href="<?= $stages[5]['url']; ?>"
		   class="<?= $stages[5]['class_bg'].' '.$stages[5]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t('Rating'); ?></span>
        </a>
        <div class="breadcrumbs-subheader">
            <div class="workflow-rating" data-rating="<?= $project['review_other']['avg_rating']; ?>"></div>
        </div>
	</li>
	<li>
		<a href="<?= $stages[6]['url']; ?>"
		   class="<?= $stages[6]['class_bg'].' '.$stages[6]['class_border']; ?>">
            <span class="breadcrumbs-content"><?= t('Archive'); ?></span>
        </a>
		<p class="breadcrumbs-subheader"><?= t('Archived'); ?></p>
	</li>
</ul>
<div class="clearfix"></div>