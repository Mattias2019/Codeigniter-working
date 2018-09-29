<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">

    <title><?php if (isset($page_title)) echo $page_title; ?></title>
    <meta name="keywords" content="Machinery Consultant, Machinery Marketplace, On-demand machinery." />
    <meta name="description" content="<?php if (isset($meta_description)) echo $meta_description; ?>"/>
    <link ref="canonical" href="<?php echo current_url(); ?>" />
    <meta property="og:title" content="<?php if (isset($page_title)) echo $page_title; ?>"/>
    <meta property="og:image" content="<?php echo image_url('logo-machinery.png'); ?>"/>
    <meta property="og:site_name" content="Machinery Marketplace"/>
    <meta property="og:description" content="<?php if (isset($meta_description)) echo $meta_description; ?>"/>
    <?php
    if (isset($this->outputData['css']) and is_array($this->outputData['css'])) {
        foreach ($this->outputData['css'] as $css) {
            echo '<link rel="stylesheet" href="' . base_url($css) . '">' . "\n";
        }
    }
    ?>

    <script>
        var site_url = "<?php echo site_url(); ?>";
    </script>

    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>

    <?php
    if (isset($this->outputData['js']) and is_array($this->outputData['js'])) {
        foreach ($this->outputData['js'] as $js) {
            echo '<script src="' . base_url($js) . '"></script>' . "\n";
        }
    }
    ?>

    <script>
        var lang = <?php global $LANG; echo json_encode($LANG->language); ?>;
    </script>
    <script>
        m.init({strings: lang});
        <?php echo $this->outputData['js_init']; ?>
    </script>

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only"><?= t('Toggle navigation'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">
                <img src="<?php echo site_logo(); ?>"/>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav navbar-right navbar-menu">

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-target="dropdown-menu" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="<?php echo image_url('logo-machinery.png'); ?>"/>
                        <span class="caret"></span>
                        <ul class="dropdown-menu collapse">
                            <li>
                                <a href="/">
                                    <img src="<?php echo image_url('logo-machinery.png'); ?>"/>
                                </a>
                            </li>
                            <li>
                                <a href="/">
                                    <img src="<?php echo image_url('logo-consultant.png'); ?>"/>
                                </a>
                            </li>
                        </ul>
                    </a>
                </li>

                <?php
                $config = (array)$this->config;
                $menus = $config['config']['menu']['top'];
                foreach ($menus as $mn_key=>$menu) {
                    if (menu_isAllowed($menu)) {
                        $mainUrl = isset($menu['url']) ? $menu['url'] : $menu['resource']
                        ?>
                        <?php if($mn_key=='login'&& current_url()!=site_url($mainUrl)): ?>
                            <li class="dropdown">
                                    <a class="" data-toggle="dropdown" data-container=".navbar" data-placement="bottom" data-delay="100">
                                        <?php if ($menu['icon_class'] != '') { ?>
                                            <img class="<?php echo $menu['icon_class']; ?>"
                                                 src="<?php echo image_url($menu['src']); ?>"/>
                                        <?php } ?>
                                        <span class="text-uppercase"><?php echo t($menu['label']); ?></span>
                                    </a>
                                    <div class="dropdown-menu login_popover">
                                        <form method="post" action="#" id="form_login_ajax">
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <h3><?php echo t($menu['label']); ?></h3>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <input required="required" tabindex="1" name="username" value="" class="form-control  user" id="UN" placeholder="<?= t('Login Name'); ?>" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <input required="required" tabindex="2" type="password" name="pwd" class="form-control  password" id="PW" placeholder="<?= t('Password'); ?>" />
                                                    <span id="message_error"></span>
                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <div>
                                                        <input type="checkbox" class="checkbox check" name="remember" id="remember"/>
                                                        <label class="form-control-label" for="remember"><?= t('remember me'); ?></label>

                                                    </div>
                                                    <div>
                                                        <input type="checkbox" class="checkbox check" name="keepsignin" id="keepsignin"/>
                                                        <label class="form-control-label" for="keepsignin"><?= t('keep signed in'); ?></label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <a href="<?php echo site_url('account/forgot_password'); ?>"><?= t('I forgot my login details'); ?>?</a>
                                                </div>
                                                <div class="col-xs-12">
                                                    <a href="<?php echo site_url('account/signup'); ?>"><?= t('Signup'); ?></a>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-3"></div>
                                                <div class="col-xs-6">

                                                    <button type="submit"  class="usersLoginAjax button big primary"><i style="display: none" class="fa fa-spin fa-spinner"></i> <?= t('Sign In'); ?></button>
                                                </div>
                                                <div class="col-xs-3"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <script>
                                        jQuery(document).ready(function(){
                                            $('#UN, #PW').focusin(function(){
                                                $('#message_error').html('');
                                            });
                                            $('#form_login_ajax').submit(function(){
                                                var username = $('#UN').val();
                                                var password = $('#PW').val();

                                                if(username!='' && password!='' && !$('.usersLoginAjax').hasClass('disable')){
                                                    $('.usersLoginAjax i').css('display','inline-block');
                                                    $('.usersLoginAjax').addClass('disable');

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo site_url('account/login_ajax'); ?>",
                                                        dataType: 'JSON',
                                                        data: $('#form_login_ajax').serializeArray(),
                                                        success: function(response){
                                                            if(response.success){
                                                                location.href = response.data;
                                                            }else{
                                                                $('#message_error').html(response.message);
                                                                $('.usersLoginAjax i').css('display','none');
                                                                $('.usersLoginAjax').removeClass('disable');
                                                            }
                                                        }
                                                    });
                                                }
                                                return false;
                                            });
                                        });
                                    </script>
                            </li>
                        <?php else: ?>
                            <li class="<?php if (isset($menu['items'])) echo 'dropdown'; ?>">
                                <a href="<?php echo site_url($mainUrl); ?>" <?php if (isset($menu['items'])) echo 'data-toggle="dropdown" data-target="dropdown-menu" role="button" aria-haspopup="true" aria-expanded="false"'; ?> >
                                    <?php if ($menu['icon_class'] != '') { ?>
                                        <img class="<?php echo $menu['icon_class']; ?>"
                                             src="<?php echo image_url($menu['src']); ?>"/>
                                    <?php } ?>
                                    <span class="text-uppercase"><?= t($menu['label']); ?></span>
                                    <?php if (isset($menu['items'])) { ?>
                                        <span class="caret"></span>
                                        <ul class="dropdown-menu collapse">
                                            <?php
                                            foreach ($menu['items'] as $submenu) {
                                                if (menu_isAllowed($submenu)) {
                                                    $subUrl = isset($submenu['url']) ? $submenu['url'] : $submenu['resource']
                                                    ?>
                                                    <li>
                                                        <a class="text-uppercase" href="<?php echo site_url($subUrl); ?>">
                                                            <?php
                                                            if (isset($this->logged_in_user) and strpos($submenu['label'], '&username') !== FALSE) {
                                                                echo str_replace('&username', $this->logged_in_user->full_name, t($submenu['label']));
                                                            } else {
                                                                echo t($submenu['label']);
                                                            }
                                                            ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php
                    }
                }
                ?>

            </ul>
        </div>

    </div>
</nav>


<div class="page-container">
    <?php
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    ?>
    <?= $msg->display($msg::SUCCESS) ?>
<?= $msg->display($msg::ERROR) ?>