<?php $this->load->view('header1'); ?>

	<div class="clsInnerpageCommon">
		<div class="clsInnerCommon">

            <h2><?= t('Import Tax Compliance Matrix'); ?></h2>

			<?php flash_message(); ?>

			<div class="container-fluid content" id="content">
                <form method="post" action="<?php echo admin_url('payments/import'); ?>">

                    <div class="row table-responsive">
						<?php echo validation_errors(); ?>
                        <table class="matrix">
                            <thead>
                            <tr>
                                <th></th>
                                <?php if (isset($import)) foreach ($import as $country) { ?>
                                    <th class="vertical"><?php echo $country['name']; ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($import)) foreach ($import as $i => $country1) { ?>
                                <tr>
                                    <th><?php echo $country1['name']; ?></th>
                                    <?php foreach ($import as $j => $country2) { ?>
                                        <td><input title="<?php echo $import[$i]['name'].' - '.$import[$j]['name']; ?>" class="table-input" name="import[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo set_value('import['.$i.']['.$j.']', $import[$i]['import'][$j]); ?>"/></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 col-xs-12">
                            <input type="submit" name="submit" class="button big primary"/>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                </form>
			</div>

		</div>
	</div>

    <style>

        .matrix
        {
            table-layout: fixed;
            width: 100%;
        }
        .matrix td
        {
            background-color: transparent;
            color: black;
            border: 1px solid black;
        }
        .matrix-col-first
        {
            width: 200px;
        }
        .matrix-col
        {
            width: 30px;
        }

        .vertical
        {
            text-align: center;
            white-space: nowrap;
            transform-origin: 50% 50%;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }
        .vertical:before
        {
            content: '';
            padding-top: 110%; /* takes width as reference, + 10% for faking some extra padding */
            display: inline-block;
            vertical-align: middle;
        }

    </style>

<?php $this->load->view('footer1'); ?>