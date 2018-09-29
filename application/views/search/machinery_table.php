<?php foreach ($this->outputData['portfolios'] as $portfolio) { ?>
    <div class="machinery-item-container fade-slow">

        <div class="machinery-item">

            <?php
            if (isset($portfolio['url']) && $portfolio['url'] != "" && !empty($portfolio['url'])) { ?>
                <img class="machinery-image" src="<?php echo $portfolio['url']; ?>">
                <?php
            }
            else { ?>
                <img class="machinery-image" src="<?php echo get_default_portfolio_thumbnail(); ?>">
                <?php
            } ?>

            <div class="machinery-caption">

                <input type="hidden" class="portfolio_name" value="<?php echo $portfolio['title']; ?>"/>
                <input type="hidden" class="portfolio_price" value="<?php echo $portfolio['price']; ?>"/>
                <input type="hidden" class="portfolio_description" value="<?php echo word_limiter($portfolio['machine_description'], 20); ?>"/>

                <input
                        type="hidden"
                        class="portfolio_img_url"
                        value="
                        <?php if (isset($portfolio['url']) && $portfolio['url'] != "" && !empty($portfolio['url'])) {
                            echo $portfolio['url'];
                        }
                        ?> ?>"
                />

                <div class="machinery-title">
                    <span class="machinery-name"><?php echo $portfolio['title']; ?></span>
                    <span class="machinery-price-container">
                        <span><?= t('Price'); ?>: </span>
                        <span class="machinery-price"><?php echo currency().number_format($portfolio['price']); ?></span>
                    </span>
                </div>
                <div class="machinery-desc">
                    <p><?php echo $portfolio['machine_description']; ?></p>
                </div>
                <div class="machinery-foot">
                    <a href="<?php echo site_url('portfolio/view?id='.$portfolio['id']); ?>" class="machinery-read-more"><?= t('Learn More'); ?></a>
	                <?php if (!$this->outputData['compare'] and $this->outputData['parent_controller'] != 'portfolio/user') { ?>
                    <span class="machinery-compare-container">
                        <input type="checkbox" class="machinery-compare" id="check-<?php echo $portfolio['id']; ?>"/>
                        <label for="check-<?php echo $portfolio['id']; ?>"><?= t('Compare'); ?></label>
                    </span>
					<?php } ?>
                </div>

            </div>
        </div>

        <!-- Items for comparison -->
        <?php if ($this->outputData['compare']) { ?>
            <div class="machinery-items">
				<?php foreach ($portfolio['items'] as $item) { ?>
                    <p>
                        <span class="machinery-item-name"><?php echo $item['name']; ?></span>
                        <span class="machinery-item-value"><?php echo $item['value'].' '.$item['unit']; ?></span>
                    </p>
				<?php } ?>
            </div>
            <?php if (!array_key_exists('no_request', $this->outputData)) { ?>
			<a href="#" class="button big secondary request-quote" data-id="<?php echo $portfolio['id']; ?>"><?= t('Request a Quote'); ?></a>
			<?php } ?>
		<?php } ?>
    </div>
<?php } ?>