<?php $this->load->view('header'); ?>
    <style>

        .coloumn_align_separate_cls {
            display: inline-table;
            width: 100%;

        }

        .coloumn_align_separate_cls > ul {
            display: inline-block;
            width: 100%;
        }

        .coloumn_align_separate_cls li {
            display: inline-block;
            float: left;
            width: 33%;
            text-align: left;
            padding: 0 20px;
        }

        .container1 {
            margin: 100px auto;
            width: 900px;
            border: 1px solid rgb(236, 236, 236);
            box-shadow: 4px 4px 5px -2px rgb(204, 204, 204);
            padding: 20px 15px;

        }

        .coloumn_align_separate_cls a {
            color: #000;
        }

        .coloumn_align_separate_cls a:hover {
            color: #166bb5;
        }
    </style>
    <div class="container1">
        <h2 style="color:#000; text-align:left;font-size:22px;"><?= t('All Categories'); ?></h2>
		<?php
		if (isset($groups_with_categories) and count($groups_with_categories) > 0) {
			foreach ($groups_with_categories as $groupsWithCategory) {
				if ($groupsWithCategory['num_categories'] > 0) {
					?>
                    <div class="coloumn_align_separate_cls">
                        <h3 style="text-align:left;font-size:18px;">
                            <a style="color:#166bb5; text-align:left;font-size:16px;"href="<?php echo site_url('search/machinery?group='.urlencode($groupsWithCategory['group_name'])); ?>"><?= t($groupsWithCategory['group_name']); ?></a>
                        </h3>
                        <ul>
							<?php foreach ($groupsWithCategory['categories'] as $category) { ?>
                                <li><a href="<?php echo site_url('search/machinery?group='.urlencode(strtolower($groupsWithCategory['group_name'])).'&category='.urlencode(strtolower($category['category_name']))); ?>"><?= t($category['category_name']); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
				<?php }
			}
		} ?>
    </div>

<?php $this->load->view('footer'); ?>