<div class="container">
    <?php if(have_posts()): ?>

        <?php if (!is_single()): ?>
        <section class="blog-article-list">
        <?php endif; ?>

    <?php
        while (have_posts()) :
            the_post();
    ?>
        <article class="blog-article">
            <?php if (is_single() || is_page()): ?>
                <?php require 'article-content.php'; ?>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" class="blog-article-teaser">
                    <h2>
                        <?php the_title(); ?>
                        <time><?php $T->time(); ?></time>
                    </h2>

                    <?php the_excerpt(); ?>

                    <h3 class="read-more">Read more...</h3>
                </a>
            <?php endif; ?>

            <?php if (is_single()): ?>
            <nav class="text-center">
                <a href="<?= $T->getPreviousPostLink(); ?>" class="button">
                    &laquo; Previous entry
                </a>

                <a href="<?= $T->getNextPostLink(); ?>" class="button">
                    Next entry &raquo;
                </a>
            </nav>
            <?php endif; ?>
        </article>

        <?php endwhile; ?>

        <?php if (!is_single() && !is_page()): ?>
        <nav class="text-center">
            <a href="<?= get_next_posts_page_link(); ?>" class="button">
                &laquo; Older entries
            </a>

            <a href="<?= get_previous_posts_page_link(); ?>" class="button">
                Newer entries &raquo;
            </a>
        </nav>
        <?php endif; ?>
    <?php if (!is_single()): ?>
    </section>
    <?php endif; ?>

    <?php else: ?>
        <article class="blog-article text-center">
            <h2>404 Barrie not found</h2>
            <img class="buffer-top-2" src="<?= $T->getTheme(); ?>/img/404.gif" alt="404" />
        </article>
    <?php endif; ?>
</div>