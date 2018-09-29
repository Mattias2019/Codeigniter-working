<?php if (isset($this->logged_in_user)) {
    /* set class active to selected menu */
    $for_menu_current_url = uri_string();
    $explode_menu_value = explode("/", $for_menu_current_url);

    $menu_controller = $explode_menu_value[0];

    if (isset($explode_menu_value[1]))
        $menu_function = $explode_menu_value[1];

    if (isset($explode_menu_value[2]))
        $menu_value = $explode_menu_value[2];

    $config = (array)$this->config;
    $sidebar_menu = $config['config']['menu']['sidebar'];

    ?>
    <div class="page-sidebar-wrapper col-md-2 no-padding" id="sidebar">
        <div class="page-sidebar navbar-collapse collapse" id="sidebar-collapse">

            <ul id="myUL" class="page-sidebar-menu page-header-fixed" data-keep-expanded="false">

                <li class="sidebar-header">
                    <img src="<?php echo image_url('logo-machinery.png'); ?>" alt="<?= t('Machinery Marketplace'); ?>"/>
                    <div class="role-text"><?= t(($this->logged_in_user->role_id == 2 ? 'supplier' : $this->logged_in_user->role_name) . ' cockpit'); ?></div>
                </li>

                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>

                <li>
                    <form class="search-form"
                          action="<?php echo site_url(isEntrepreneur() ? 'search/machinery' : (isProvider() ? 'search/tender' : '')); ?>"
                          method="get">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn submit search-form-submit">
                                    <img class="icon-svg-img"
                                         src="<?php echo base_url() ?>application/css/svg-icon/dashboard/ic_search.svg"/>
                                </button>
                            </span>
                            <input type="text" name="keyword" id="filterInput" onkeyup="menuFilterFunction()"
                                   class="form-control input-sm" placeholder="<?= t('Search'); ?>...">
                        </div>
                    </form>
                </li>

                <!-- Menu -->
                <?php
                $i = 1;
                $ci =& get_instance();
                $controller = $ci->router->class;
                $resource = $this->router->fetch_directory() . $controller . "/" . $this->router->fetch_method();

                foreach ($sidebar_menu as $key => $value) {

                    // main menu
                    $isAllowed = menu_isAllowed($value);

                    $isSubItems = isset($value['items']);
                    $active = ($value['resource'] == $resource) ? 'active open' : "";
                    $url = isset($value['resource']) ? '/' . $value['resource'] : '';
                    $url = $isSubItems ? "#" . $key . '_submenu' : site_url($url);

                    if ($isSubItems) {
                        foreach ($value['items'] as $key1 => $value1) {
                            if (!$active) {
                                $active = ($value1['resource'] == $resource) ? 'open' : "";
                            }
                        }
                    }

                    if ($isAllowed) {
                        ?>

                        <li class="<?php echo $active; ?>">

                            <a href="<?php echo $url; ?>" <?php if ($isSubItems) echo 'data-toggle="collapse"'; ?> >

                                <?php if (isset($value['src'])) { ?>
                                    <span class="<?php echo $value['icon_class']; ?>"><?php echo svg($value['src'], TRUE); ?></span>
                                <?php } else { ?>
                                    <i class="<?php echo $value['icon_class'] ?>"></i>
                                <?php } ?>

                                <span class="title"><?php echo strtoupper(t($value['label'])); ?></span>
                                <span class="selected"></span>

                                <?php if (isset($value['badge_data']) and array_key_exists($value['badge_data'], $this->outputData) and $this->outputData[$value['badge_data']] > 0) { ?>
                                    <span class="badge navbar-right"><?php echo $this->outputData[$value['badge_data']]; ?></span>
                                <?php } ?>

                                <?php if ($isSubItems) { ?>
                                    <span class="fa fa-caret-down navbar-right"></span>
                                <?php } ?>

                            </a>

                            <?php
                            if ($isSubItems) {
                                echo render_sidemenu($key, $value['items'], $resource);
                            }
                            ?>

                        </li>

                        <?php
                    }
                }
                ?>

                <!-- Team -->
                <?php if (count($this->outputData['team_online']) > 0) { ?>
                    <?php
                    $online = 0;
                    foreach ($this->outputData['team_online'] as $user) {
                        if ($user['is_online']) $online++;
                    }
                    ?>
                    <li>
                        <a href="#team-online_submenu" data-toggle="collapse">
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                            <span class="title"><?= t('Team Online'); ?></span>
                            <span class="fa fa-caret-down navbar-right"></span>
                            <?php if ($online > 0) { ?>
                                <span class="badge badge-success navbar-right"><?php echo $online; ?></span>
                            <?php } ?>
                        </a>
                        <ul class="sub-menu collapse" id="team-online_submenu">
                            <?php foreach ($this->outputData['team_online'] as $user) { ?>
                                <li>
                                    <a href="javascript: void(0)" data-toggle="popover" class="team_online_li">
                                        <input type="hidden" value="<?php echo $user['id']; ?>" name="user_id"/>
                                        <div class="image-circle small">
                                            <img src="<?php echo $user['img_logo']; ?>"
                                                 title="<?php echo $user['name']; ?>"/>
                                        </div>
                                        <span><?php echo $user['name']; ?></span>
                                        <span class="user-status <?php echo $user['is_online'] ? 'is-online' : 'is-offline'; ?>"></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Stopper for menu expanding (lower-level items are not calculated properly) -->
                <li>
                    <span class="navbar-right">&nbsp;</span>
                </li>

            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>

<?php } ?>

<script>
    function showChat() {
        $('#chat-menu-toggle').click();
    }
</script>

<script>
    function menuFilterFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('filterInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>

<script>
    // Hack for sizing text as container
    sizeText.init(jQuery('.role-text'));
</script>