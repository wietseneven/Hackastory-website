<?php global $T, $hidenav; ?>
<!doctype html>
<html lang="nl">
<head xmlns:og="http://opengraphprotocol.org/schema/">
<!-- ,                 _
    /|   |            | |
     |___|  __,   __  | |   __,   , _|_  __   ,_
     |   |\/  |  /    |/_) /  |  / \_|  /  \_/  |  |   |
     |   |/\_/|_/\___/| \_/\_/|_/ \/ |_/\__/    |_/ \_/|/
                                                      /|
                                                      \|  -->
    <meta charset="utf-8">
    <meta name="og:title" content="<?= get_the_title(); ?>">
    <meta name="og:type" content="article">
    <meta name="og:url" content="<?= get_permalink(); ?>">
    <meta name="og:image" content="<?= $T->getPostThumb(); ?>">

    <title><?php the_title(); ?> &raquo; <?php bloginfo('name'); ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="google-site-verification" content="TckLz5_Yvk7heUkGI4UN204gIIH6FkHotvyixNXeeXo" />

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="/feed" />
    <link rel="stylesheet" href="<?= $T->getTheme(); ?>/css/style.css" />

    <?php wp_head(); ?>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-67379081-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body id="body">
    <?php if (!isset($hidenav)): ?>
    <nav class="main-nav">
        <a href="<?= $T->getHome(); ?>" class="main-nav-logo">
            <img src="<?= $T->getTheme(); ?>/img/logo-circle.png">
            <h1><?php bloginfo('name'); ?></h1>
        </a>

        <?php $T->navMenu(); ?>

        <ul class="menu share">
            <?php require 'share.php'; ?>
        </ul>
    </nav>
    <?php endif; ?>
