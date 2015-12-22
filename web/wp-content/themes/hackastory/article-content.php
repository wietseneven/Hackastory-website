<header class="blog-article-header">
    <h2>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php if (is_single()): ?>
            <time><?php $T->time(); ?></time>
        <?php endif; ?>
        <?php edit_post_link("edit"); ?>
    </h2>

    <?php if (!is_page()): ?>
        <div class="clearfix"></div>

        <h3 class="blog-article-author" data-size="small">
            <?= get_avatar( get_the_author_meta('user_email') ); ?>

            <span>by: <?= get_the_author(); ?></span>
        </h3>
    <?php endif; ?>

    <?php /*
    <ul class="taglist">
        <?php foreach (get_the_category() as $cat): ?>
        <li>
            <a href="<?= get_category_link($cat->term_id); ?>">
                <?= $cat->name; ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    */ ?>
</header>

<?php the_content(); ?>

<?php if (!is_page()): ?>
    <h3 class="blog-article-author" data-size="large">
        <?= get_avatar( get_the_author_meta('user_email') ); ?>

        <p>
            <span class="author"><?= get_the_author(); ?></span><br>
            <?= the_author_meta( 'description' ); ?>
        </p>
    </h3>
<?php endif; ?>

<?php if (is_single()): ?>
<aside class="share clearfix">
    <h3>Share this page</h3>

    <?php
        $sharetext = urlencode(
            sprintf("%s: %s via @hackastory",
            get_the_title(), get_permalink()
        ));
    ?>

    <a data-type="twitter"
       target="_blank"
       title="Share on Twitter"
       href="https://twitter.com/intent/tweet?text=<?php echo $sharetext; ?>"
    >Twitter</a>

    <a data-type="facebook"
       target="_blank"
       title="Share on Facebook"
       href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
    >Facebook</a>
</aside>
<?php endif; ?>