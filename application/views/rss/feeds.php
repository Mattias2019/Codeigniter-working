<?php
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?php if (isset($rss_title)) echo $rss_title; ?></title>
        <ttl>30</ttl>
        <link><?php echo site_url(); ?></link>
        <description><?php if (isset($rss_description)) echo $rss_description; ?>.</description>
        <language><?= t('en-us'); ?></language>
        <pubDate><?= t('Sat, 17 Jan 2009 05:30:39 GMT'); ?></pubDate>
        <lastBuildDate><?= t('Sat, 17 Jan 2009 05:30:39 GMT'); ?></lastBuildDate>
        <copyright><?= t('Copyright'); ?><?= t('(c) 2015'); ?><?php echo $this->config->item('site_title'); ?></copyright>
		<?php if (isset($projects)) foreach ($projects as $project) { ?>
            <item>
                <title><?php echo $project['job_name']; ?></title>
                <link><?php echo site_url('project/quote?id='.$project['id']); ?></link>
                <guid><?php echo site_url('project/quote?id='.$project['id']); ?></guid>
                <pubDate><?php echo show_date($project['created']); ?></pubDate>
                <?php
                if (isset($type)) {
                    switch ($type) {
                        case 2:
                            echo '<description>';
                            echo htmlspecialchars(character_limiter($project['description'], 100));
                            echo '</description>';
                            break;
                        case 3:
                            echo '<description>';
                            echo $project['description'];
                            echo '</description>';
                            break;
                    }
                }
                ?>
            </item>
        <?php } ?>
    </channel>
</rss>