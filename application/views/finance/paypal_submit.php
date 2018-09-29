<html>
<head>
	<script type="text/javascript">
        function closethisasap() {
            document.forms["submit-form"].submit();
        }
	</script>
</head>
<body onload="closethisasap();">
<form name="submit-form" method="post" enctype="multipart/form-data" action="<?php pifset($_ci_vars, 'paypal_url'); ?>">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?php pifset($_ci_vars, 'paypal_mail'); ?>">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="item_name" value="<?php pifset($_ci_vars, 'operation'); ?>">
	<input type="hidden" name="item_number" value="">
	<input type="hidden" name="currency_code" value="<?php pifset($_ci_vars, 'currency'); ?>">
	<input type="hidden" name="button_subtype" value="services">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="return" value="<?php echo site_url('finance/paypal_return'); ?>">
	<input type="hidden" name="cancel_return" value="<?php pifset($_ci_vars, 'back_url'); ?>">
	<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHosted">
	<input type="hidden" name="amount" value="<?php pifset($_ci_vars, 'amount'); ?>">
</form>
</body>
</html>