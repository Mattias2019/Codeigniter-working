<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">

    <title><?php if (isset($page_title)) echo $page_title; ?></title>
    <meta name="description" content="<?php if (isset($meta_description)) echo $meta_description; ?>"/>

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

<div id="dialog" class="modal fade">
    <?php $this->load->view('dialog'); ?>
</div>

<nav class="navbar navbar-default navbar-fixed-top">

    <div class="col-xs-12 no-padding navbar-header">

        <div class="col-md-2 col-sm-3 col-xs-3 no-padding">
            <a class="navbar-brand" href="/">
                <div class="no-mobile">
                    <img src="<?php echo site_logo(); ?>"/>
                </div>
                <div class="mobile-only">
                    <img src="<?php echo site_logo('small'); ?>"/>
                </div>
            </a>
        </div>

        <script>
            function receive_notification(id)
            {
                $.ajax({
                    url: "<?php echo site_url() . '/account/set_notified/'?>" + id,
                    data: {
                        id: id
                    }
                });
            }
        </script>

        <div class="col-md-10 col-sm-9 col-xs-9 no-padding">
            <ul class="nav navbar-nav navbar-left navbar-notifications">
                <li class="dropdown">
                    <a id="notifications" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="icon-svg"> <img src="<?php echo base_url() ?>application/css/svg-icon/ic_notifications_header.svg"/></i>
                        <?php if ($this->outputData['unread_notifications_amount'] > 0) { ?>
                            <span id="unread-notifications" class="badge badge-primary"><?php echo $this->outputData['unread_notifications_amount']; ?></span>
                        <?php } ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($this->outputData['unread_notifications'])) {
                            foreach ($this->outputData['unread_notifications'] as $notification) { ?>
                                <li>
                                    <span class="unread notification" onclick="receive_notification(<?php echo $notification['id']?>)">
                                        <a href="<?php echo $notification['url'] !== NULL ? $notification['url'] : '#'?>">
                                            <?php echo $notification['message']?>
                                        </a>
                                    </span>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <li><?= t('No pending notifications'); ?></li>
						<?php } ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-left navbar-account">
				<?php if (isEntrepreneur()) { ?>
                    <li class="navbar-workflow hidden-md hidden-sm hidden-xs">
                        <a href="<?= site_url('search/machinery'); ?>" class="button medium primary"><?= t('Search Machinery'); ?></a>
                    </li>
                    <li class="navbar-workflow hidden-md hidden-sm hidden-xs">
                        <a href="<?= site_url('project/create'); ?>" class="button medium primary"><?= t('New Machine Tender'); ?></a>
                    </li>
                    <li class="dropdown navbar-workflow hidden-lg">
                        <a class="button medium primary dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= t('Project Actions'); ?> <span class="fa fa-caret-down"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('search/machinery'); ?>"><?= t('Search Machinery'); ?></a></li>
                            <li><a href="<?= site_url('project/create'); ?>"><?= t('New Machine Tender'); ?></a></li>
                        </ul>
                    </li>
				<?php } elseif (isProvider()) { ?>
                    <li class="navbar-workflow hidden-md hidden-sm hidden-xs">
                        <a href="<?= site_url('portfolio/manage'); ?>" class="button medium primary"><?= t('Edit Machine Portfolio'); ?></a>
                    </li>
                    <li class="navbar-workflow hidden-md hidden-sm hidden-xs">
                        <a href="<?= site_url('search/tender'); ?>" class="button medium primary"><?= t('Search Tender'); ?></a>
                    </li>
                    <li class="navbar-workflow hidden-md hidden-sm hidden-xs">
                        <a href="<?= site_url('rss'); ?>" class="button medium primary"><?= t('Create RSS Feed'); ?></a>
                    </li>
                    <li class="dropdown navbar-workflow hidden-lg">
                        <a class="button medium primary dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= t('Project Actions'); ?> <span class="fa fa-caret-down"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('portfolio/manage'); ?>"><?= t('Edit Machine Portfolio'); ?></a></li>
                            <li><a href="<?= site_url('search/tender'); ?>"><?= t('Search Tender'); ?></a></li>
                            <li><a href="<?= site_url('rss'); ?>"><?= t('Create RSS Feed'); ?></a></li>
                        </ul>
                    </li>
				<?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-account">
				<?php if (isEntrepreneur() || isProvider()) { ?>
                    <li class="dropdown navbar-workflow">
                        <a class="button medium primary dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= t('Your Projects'); ?> <span class="fa fa-caret-down"></span></a>
                        <ul class="dropdown-menu">
							<?php foreach ($user_projects as $project) { ?>
                                <li><a href="<?= site_url('project/workflow?id='.$project['id']); ?>"><?= $project['job_name']; ?></a></li>
							<?php } ?>
                        </ul>
                    </li>
				<?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="image-circle medium">
                            <img alt="" src="<?php if (isset($logged_in_user)) echo $logged_in_user->img_logo; ?>"/>
                        </div>
                        <span class="username no-mobile"> <?php if (isset($logged_in_user)) echo $logged_in_user->user_name; ?>
                            &nbsp;</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?php echo site_url('account'); ?>"><span class="fa fa-user-circle"></span> <?= t('My Profile'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('messages'); ?>"><span class="fa fa-envelope-open"></span>
                                <?= t('My Inbox'); ?><!--<span class="badge badge-danger"> 3 </span>--></a>
                        </li>
                        <?php if (isProvider()) { ?>
                        <li>
                            <a href="<?php echo site_url('rss'); ?>"><span class="fa fa-rss"></span> <?= t('Subscription'); ?></a>
                        </li>
                        <?php } ?>
                        <li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url('account/logout'); ?>"><span class="fa fa-sign-out"></span> <?= t('Log Out'); ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="col-sm-1 col-xs-1 no-padding">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"
                    aria-expanded="false">
                <span class="sr-only"><?= t('Toggle navigation'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

    </div>

</nav>

<div class="page-container-wrapper">
    <div class="container-fluid page-container page-container-flex">
        <div class="col-md-2 no-padding">
            <?php $this->load->view('sidemenu'); ?>
        </div>
        <div class="col-md-10 col-sm-12 col-xs-12 no-padding">
            <div class="page-content-wrapper">
                <div class="page-content">

                    <div class="workflow-container">
                        <?= empty($_SESSION['workflow']) ? '' : $_SESSION['workflow']; ?>
                    </div>

                    <?php
                    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                    ?>
                    <?= $msg->display($msg::SUCCESS) ?>
                    <?= $msg->display($msg::ERROR) ?>
