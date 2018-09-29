<footer>
    <div id="selFooter">
        <div class="container">
            <div id="selBottomFooter">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-10 clsFooter clearfix">
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <ul>
                                    <li><span><?php  echo t('Navigate'); ?></span></li>
                                    <li><a href="<?php echo base_url(); ?>"><?= t('Home'); ?></a></li>
                                    <?php if($this->logged_in_user) : ?>
                                        <li><a href="<?php echo site_url('account'); ?>"><?= t('My Account'); ?></a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo site_url('home/sitemap'); ?>"><?= t('Sitemap'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <ul>
                                    <li><span><?= t('Take Action'); ?></span></li>
                                    <li><a href="<?php echo site_url("home/support"); ?>"><?= t('Support'); ?></a></li>
                                    <li><a href="<?php echo site_url("home/faq");?>"><?= t('FAQ'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <ul>
                                    <li><span><?php  echo t('Resources'); ?></span></li>
                                    <?php if($this->logged_in_user) : ?>
                                        <li><a href="<?php echo site_url('/'); ?>"><?= t('Suggestion Box'); ?></a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo site_url("home/page/about");?>"><?= t('About Us'); ?></a></li>
                                    <li><a href="<?php echo site_url("home/page/help");?>"><?= t('Help'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <ul>
                                    <li><span><?= t('Terms and Policies'); ?></span></li>
                                    <li><a href="<?php echo site_url("home/page/condition");?>"><?= t('Terms of use'); ?></a></li>
                                    <li><a href="<?php echo site_url("home/page/privacy");?>"><?= t('Privacy Policy'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12 social-links-ftr">
                                <div class="clsSocialBlock">
                                    <ul><li><span><?= t('Follow Us'); ?></span></li></ul>
                                    <a href="#"><img src="<?php echo image_url('fb-icn.png');?>" /></a>
                                    <a href="#"><img src="<?php echo image_url('linkedin-icn.png');?>" /></a>
                                    <a href="#"><img src="<?php echo image_url('twitr-icn.png');?>" /></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="top-lang">
                                    <div id="selflag">
                                        <div class="dropup">
                                            <button class="btn btn-default dropdown-toggle" id="selLangMenu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                <img src="<?php echo image_url('languages/'.$this->config->item('language').'.png'); ?>" title=""/>
                                                <span style="position: relative; top: 1px;" ><?php echo ucfirst(t($this->config->item('language'))); ?></span>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="selLangMenu" style="min-width: 30px;">
                                                <?php foreach ($this->config->item('lang_uri_abbr') as $language_code => $language_name) { ?>
                                                    <li>
                                                        <a href="<?php echo base_url().$language_code.uri_string(); ?>">
                                                            <img src="<?php echo image_url('languages/'.$language_name.'.png'); ?>" title="<?php echo $language_name; ?>"/>
                                                            <span><?php echo ucfirst(t($language_name)); ?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clsBottomfoot">
        <div class="row">
            <p class="copy col-md-12">
				<?= t('copy'); ?>
                <a href="<?php echo site_url("home/page/privacy");?>"><?= t('Privacy Policy'); ?></a>
                &nbsp;| &nbsp;
                <a href="<?php echo site_url("home/page/condition");?>"><?= t('Terms of use'); ?></a> &nbsp;
            </p>
        </div>
    </div>
</footer>

</div>

<?php
if (isset($this->logged_in_user->id))
{
	$this->load->view('chat');
}
?>
<!--Start Cookie Script-->
<?php //if (ENVIRONMENT != 'development') { ?>
<!--    <script type="text/javascript" charset="UTF-8" src="http://chs03.cookie-script.com/s/b5a4849855363621b25a1b12910cfc01.js"></script>-->
<?php //} ?>
<!--End Cookie Script-->
<?php
if (isset($this->logged_in_user->id)):
?>
<script>
    jQuery(document).ready(function(){
        setInterval(ajaxCheckLoginSesssion, 6000);
        var is_login = true;
        function ajaxCheckLoginSesssion() {
            if(!is_login) return false;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('account/check_session_login'); ?>",
                dataType: 'JSON',
                data: {url: '<?php echo current_url(); ?>'},
                success: function(response){
                    if(!response.is_login) {
                        is_login=false;
                        bootbox.confirm({
                            title: "<?php echo t('Notification'); ?>",
                            message: "<?php echo t('Your session is expired. Please sign in again!'); ?>",
                            buttons: {
                                cancel: {
                                    label: '<i class="fa fa-times"></i> <?php echo t('Close'); ?>'
                                },
                                confirm: {
                                    label: '<i class="fa fa-check"></i> <?php echo t('Sign In'); ?>'
                                }
                            },
                            callback: function (result) {
                                if(result){
                                    location.href = '<?php echo site_url('account/login'); ?>';
                                }else{
                                    location.reload();
                                }
                            }
                        });
                    }

                }
            });
        }
    });

</script>
<?php endif; ?>
</body>
</html>