<?php
    $hidenav = true;
    global $T;
?>
<?php get_header(); ?>
<header class="intro">
    <article>
        <img src="<?= $T->getTheme(); ?>/img/logo-circle.png" alt="<?php bloginfo('name'); ?>">
        <h1><?php bloginfo('name'); ?></h1><br>
        <h2><?php bloginfo('description'); ?></h2>

        <nav class="main-nav-mini">
            <?php $T->navMenu(); ?>
        </nav>

        <nav class="main-nav-mini">
            <ul class="share menu">
                <?php require 'share.php'; ?>
            </ul>
        </nav>
    </article>
</header>

<div class="container buffer-top-2">
    <article class="blog-article">
        <?php
            have_posts();
            the_post();
            the_content();
            edit_post_link("edit");
        ?>
    </article>
<?php get_footer(); ?>