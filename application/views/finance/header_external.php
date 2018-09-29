<div class="dashboard-stat2 top_green container-fluid">
    <form method="post" action="<?= site_url('finance/' . $this->outputData['operation']); ?>"
          enctype="multipart/form-data" id="finance-form">

        <input type="hidden" name="operation" value="<?= $this->outputData['operation']; ?>"/>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="col-xs-2">
                <span class="finance-info-bullet">1</span>
            </div>

            <div class="col-xs-10">
                <div class="row form-group">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <strong class="uppercase"><?= t('User Name'); ?>:</strong>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <span><?= $this->logged_in_user->full_name; ?></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <strong class="uppercase"><?= t('Account Balance'); ?>:</strong>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <strong class="uppercase text-color-2"><?= currency() . number_format($this->outputData['balance']); ?></strong>
                    </div>
                </div>
                <div class="row form-group">
                    <?= form_error('amount'); ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label for="amount"
                               class="form-control-label"><?= ucfirst($this->outputData['operation']) . ' ' . t('Amount'); ?>
                            :</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <input name="amount" class="form-control inputmask" data-prefix="<?= currency(); ?>"
                               id="amount" value="<?= set_value('amount'); ?>"/>
                    </div>
                </div>


                <?php
                if ($operation == 'deposit') {
                    ?>

                    <div class="js-wire-fields <?= (set_value('payment_method') == 2) ? '' : 'hidden' ?>">
                        <div class="row form-group">
                            <?= form_error('user_transaction_id'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="transaction_id"
                                       class="form-control-label"><?= t('Bank Transaction-ID'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="user_transaction_id" class="form-control" id="transaction_id"
                                       value="<?= set_value('user_transaction_id'); ?>"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <?= form_error('user_description'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="purpose_payment"
                                       class="form-control-label"><?= t('Purpose of payment'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="user_description" class="form-control" id="purpose_payment"
                                       value="<?= set_value('user_description'); ?>"/>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>


                <?php
                if ($operation == 'withdraw') {
                    ?>

                    <div class="js-wire-fields <?= (set_value('payment_method') == 2) ? '' : 'hidden' ?>">
                        <div class="row form-group">
                            <?= form_error('recipient'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="recipient"
                                       class="form-control-label"><?= t('Recipient'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="recipient" class="form-control" id="recipient"
                                       value="<?php echo $this->outputData['bank_account'] ? $this->outputData['bank_account']['name_on_account'] : ""; ?>" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?= form_error('bank_account_number'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="bank_account_number"
                                       class="form-control-label"><?= t('Bank account number'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="bank_account_number" class="form-control" id="bank_account_number"
                                       value="<?php echo $this->outputData['bank_account'] ? $this->outputData['bank_account']['account_number'] : ""; ?>" readonly>
                            </div>
                        </div>


                        <div class="row form-group">
                            <?= form_error('bic_swift_code_aba'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="bic_swift_code_aba"
                                       class="form-control-label"><?= t('BIC/Swift-Code/ABA'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="bic_swift_code_aba" class="form-control" id="bic_swift_code_aba"
                                       value="<?php echo $this->outputData['bank'] ? $this->outputData['bank']['swift_code'] : ""; ?>" readonly>
                            </div>
                        </div>


                        <div class="row form-group">
                            <?= form_error('credit_institution'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="credit_institution"
                                       class="form-control-label"><?= t('Credit institution'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="credit_institution" class="form-control" id="credit_institution"
                                       value="<?php echo $this->outputData['bank'] ? $this->outputData['bank']['name'] : ""; ?>" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?= form_error('target_country'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="target_country"
                                       class="form-control-label"><?= t('Target country'); ?>
                                    :</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="target_country" class="form-control" id="target_country"
                                       value="<?php echo $this->outputData['bank_country'] ? $this->outputData['bank_country']['country_name'] : ""; ?>" readonly>

                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>
                <div id="paypal-email-container" class="row form-group hidden">
                    <?= form_error('paypal_email'); ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label for="paypal_email"
                               class="form-control-label"><?= t('Please enter your PayPal email address'); ?>:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <input name="paypal_email" id="paypal_email" class="form-control"
                               value="<?php echo isset($this->outputData['paypal']) ? $this->outputData['paypal']['email'] : "" ?>" readonly>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="col-xs-2">
                <span class="finance-info-bullet">2</span>
            </div>

            <div class="col-xs-10">
                <?= form_error('payment_method'); ?>
                <div class="row form-group">
                    <strong class="uppercase"><?= t('Payment Method'); ?>:</strong>
                </div>
                <div class="row form-group">
                    <?php foreach ($payment_methods as $payment_method) {
                        if ($operation == 'deposit' and $payment_method['is_deposit_enabled'] == 1 or $operation == 'withdraw' and $payment_method['is_withdraw_enabled'] == 1) { ?>
                            <input type="radio"
                                   name="payment_method"
                                   value="<?= $payment_method['id']; ?>"
                                   id="<?= $payment_method['title']; ?>"
                                   class="js-<?= $payment_method['title']; ?>"
                                <?php if (set_value('payment_method') == $payment_method['id']) echo 'checked="checked"'; ?>
                            />
                            <label for="<?= $payment_method['title']; ?>">
                                <img class="finance-info-image tooltip-attach"
                                     data-toggle="tooltip"
                                     data-placement="top"
                                     src="<?= image_url('payment-' . $payment_method['title'] . '.png'); ?>"
                                     alt="<?= ucfirst($payment_method['title']); ?>"
                                     title="<?= t(($operation == 'deposit') ? $payment_method['deposit_description'] : $payment_method['withdraw_description']); ?>"
                                />
                            </label>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

        </div>

        <?php
        if ($operation == 'deposit') {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 js-wire-fields <?= (set_value('payment_method') == 2) ? '' : 'hidden' ?>"
                 style="clear: both; margin-top: 15px;">
                <div class="col-xs-2">
                    <span class="finance-info-bullet">3</span>
                </div>

                <div class="col-xs-10">
                    <div class="row form-group">
                        <strong class="uppercase"><?= t('Bank account the payment should be transferred to'); ?>
                            :</strong>
                    </div>
                    <div class="row form-group">
                        <?php
                        foreach ($this->outputData['payment_method_credentials'] as $payment_method_credential) {
                            ?>
                            <div>
                                <b><?= $payment_method_credential['name'] ?> :</b>
                                <?= $payment_method_credential['value'] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <?php
        }
        ?>
        <div class="col-xs-12">
            <div class="col-lg-10 col-md-10 col-sm-8"></div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                <input type="submit" class="button big primary" name="submit"
                       value="<?= $this->outputData['operation_text']; ?>"/>
            </div>
        </div>

    </form>
</div>
