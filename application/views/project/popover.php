<div class="project-creator-logo">
    <div class="image-circle medium">
        <img src="<?=$project['logo']?>"/>
    </div>
</div>
<div class="project-data">
    <div class="project-parameters">
        <?php if ($project['is_urgent'] == 1) { ?>
            <span class="cls_urgent"><?=t('Urgent');?></span>
        <?php } ?>
        <?php if ($project['is_feature'] == 1) { ?>
            <span class="cls_fetur"><?=t('Featured');?></span>
        <?php } ?>
        <?php if ($project['is_private'] == 1) { ?>
            <span class="cls_prvt"><?=t('Private');?></span>
        <?php } ?>
    </div>
    <h3 class="project-title"><?=$project['job_name']?></h3>
    <p class="project-date"><?=date('h:i d/m/Y', $project['created'])?></p>
    <p class="project-description"><?=word_limiter($project['description'])?></p>
    <p class="project-see-more">
        <a href="<?=site_url('project/view?id='.$project['id'])?>"><?=t('See More');?></a>
    </p>
    <p class="project-action">
        <a href="<?=site_url('project/'.(isEntrepreneur()?'create':'quote').'?id='.$project['id'])?>" class="button big secondary" <?php if (isEntrepreneur() and count($project['quotes']) > 0 or isProvider() and $project['latest_quote'] == NULL) echo 'disabled="disabled"' ?>><?=t(isEntrepreneur()?'Edit':'Quote');?></a>
    </p>
</div>