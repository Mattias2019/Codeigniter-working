<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <?php flash_message(); ?>

        <div class="cls_page-title clearfix">
            <h2><span><?= t('Feedback'); ?></span></h2>
        </div>

        <div>
            <form id="feedback-form" action="<?php site_url('project/review'); ?>" method="post">

                <input type="hidden" name="project_id" value="<?php echo $this->outputData['project_id']; ?>"/>

                <div class="feedback-form-block">
                    <table class="table feedback-form-table">
                        <tbody>
                        <?php foreach ($this->outputData['rating_categories'] as $category) { ?>
                            <tr>
                                <td><?php echo $category['name'] ?></td>
                                <td>
                                    <input type="hidden" name="ratings[<?php echo $category['id'] ?>][rating_category_id]" class="feedback-form-input-category" value="<?php echo $category['id'] ?>"/>
                                    <input type="hidden" name="ratings[<?php echo $category['id'] ?>][rating]" class="feedback-form-input-rating"/>
                                    <div class="feedback-form-rating"></div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="feedback-form-block">
                    <label class="form-control-label" for="comment"><?= t('What would you like to share with us'); ?>:</label>
                    <textarea class="feedback-form-comment" name="comments" id="comments"></textarea>
                    <input type="submit" name="submit" class="button big primary" value="<?= t('Send Review'); ?>">
                </div>

            </form>
        </div>

    </div>
</div>

<style type="text/css" class="init">
    #main {
        padding-left:20px;
    }
    .nav.nav-tabs li a:hover {
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0;
        border-right: 1px solid #e0e0e0;
        border-top: 1px solid #e0e0e0;
    }
    .feedback-form-block {
        margin-top: 0.5em;
        margin-right: 2em;
        /* Position side-by-side, align to top */
        display: inline-block;
        line-height: normal;
        vertical-align: top;
    }
    .feedback-form-table > tbody > tr > td {
        background-color: white;
        color: #8bc34a;
        font-weight: bold;
        text-transform: uppercase;
        padding: 1em;
    }
    .feedback-form-label {
        font-size: smaller;
        margin-top: 1em;
    }
    .feedback-form-comment {
        display: block;
        width: 30em;
        height: 14em;
        margin-top: 0.2em;
        margin-bottom: 1em;
        resize: none;
    }
    .feedback-form-submit {
        display: block;
        float: right;
    }
</style>

<script type="text/javascript">

    jQuery(document).ready(function(){

        var rating = jQuery(".feedback-form-rating");

        rating.rateYo({
            fullStar: true,
            starWidth: "18px" /* Doesn't seem to work with em */
        });

        rating.rateYo().on("rateyo.set", function (e, data) {
            jQuery(this).parent().find('.feedback-form-input-rating').val(data.rating);
        });

        // Pre-set delivery time
        var row = jQuery('.feedback-form-input-category[value=10]').closest('tr');
        var preRating = '<?php echo $this->outputData['time_rating']; ?>';
        row.find('.feedback-form-input-rating').val(preRating);
        row.find('.feedback-form-rating').rateYo('rating', preRating);

    });

</script>

<?php $this->load->view('footer1'); ?>