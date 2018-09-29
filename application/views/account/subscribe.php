<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
	<div class="clsInnerCommon">

		<?php flash_message(); ?>

		<div class="packages-container">
			<?php if (isset($packages)) foreach ($packages as $package) { ?>
				<div class="package">
					<div class="package-title">
						<h4><?php echo $package['package_name']; ?></h4>
					</div>
					<div class="package-price"><?php echo ($package['amount'] == 0)?t('Free'):currency().number_format($package['amount']); ?></div>
					<div class="package-features">
						<p><?= t('disk space'); ?></p>
						<p><?= t('databases'); ?></p>
						<p><?= t('emails'); ?></p>
						<p><?= t('bandwidth'); ?></p>
					</div>
					<div class="package-button">
						<button><?= t(($package['amount'] == 0)?'Get it now':'Purchase'); ?></button>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>
</div>

<?php $this->load->view('footer1'); ?>