<?php foreach ($this->outputData['projects'] as $project) { ?>
    <div class="machinery-item-container fade-slow">

        <div class="machinery-item">

            <img class="machinery-image" src="<?php if (count($project['attachments']) > 0) echo $project['attachments'][0]['img_url']; ?>">

            <div class="machinery-caption">

                <input type="hidden" class="portfolio_name" value="<?php echo $project['job_name']; ?>"/>
                <input type="hidden" class="portfolio_price" value="<?php echo $project['budget_min']; ?>"/>
                <input type="hidden" class="portfolio_description" value="<?php echo word_limiter($project['description'], 20); ?>"/>
                <input type="hidden" class="portfolio_img_url" value="<?php if (count($project['attachments']) > 0) echo $project['attachments'][0]['img_url']; ?>"/>

                <div class="machinery-title">
                    <span class="machinery-name"><?php echo $project['job_name'] ?></span>
                    <span class="machinery-price-container">
                        <span><?= t('Price'); ?>: </span>
                        <span class="machinery-price"><?php echo currency().number_format($project['budget_min']); ?></span>
                    </span>
                </div>
                <div class="machinery-desc">
                    <p><?php echo $project['description']; ?></p>
                </div>
                <div class="machinery-foot">
                    <a href="<?php echo site_url('project/view?id='.$project['id']); ?>" class="machinery-read-more"><?= t('Learn More'); ?></a>
                </div>

            </div>
        </div>
    </div>
<?php } ?>