<?php get_header(); ?>
<?php the_post(); ?>
<div class="container">
    <article class="project">
        <h1 class="project-heading"><?php the_title(); ?></h1>
        <?php if ( get_field('project-event') ) { ?>
            <em class="project-event"><?php the_field('project-event'); ?></em>
        <?php } ?>
        <p class="project-lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque doloribus harum illo impedit minima nesciunt numquam optio quam rerum vero.</p>
        <div class="project-content">
            <div class="project-actions">
                <ul>
                    <li><span class="project-vote project-vote-experimental" title="Cast vote for best experiment" data-postid="<?php echo get_the_ID(); ?>"><?php echo get_post_meta(get_the_ID(), 'project-votes-experimental', true); ?></span></li>
                    <li><span class="project-vote project-vote-potential" title="Cast vote for most potential" data-postid="<?php echo get_the_ID(); ?>"><?php echo get_post_meta(get_the_ID(), 'project-votes-potential', true); ?></span></li>
                </ul>
                <ul>
                    <?php if ( get_field('project-demo') ) { ?>
                        <li><a href="<?php echo get_field('project-demo'); ?>" target="_blank">Demo</a></li>
                    <?php } ?>
                </ul>
                <ul class="right">
                    <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="project-actions-fb">Facebook</a></li>
                    <li><a target="_blank" href="https://twitter.com/home?status=<?php echo urlencode('Check out "' . get_the_title() . '", a project made during a @hackastory hackaton! ' . get_permalink()); ?>" class="project-actions-twitter">Twitter</a></li>
                </ul>
            </div>
            <?php the_content(); ?>
        </div>
    </article>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/projects.js"></script>
<?php get_footer(); ?>