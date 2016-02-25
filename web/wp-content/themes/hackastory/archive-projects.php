<?php get_header(); ?>
<div class="container">
    <div class="projects">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="project-heading">Projects</h1>
            </div>
        </div>
        <?php if ( have_posts() ) { ?>
            <div class="row">
                <div class="large-12 columns">
                    <div class="projects-notification">
                        <div class="row">
                            <div class="large-12 columns">
                                <h2 class="projects-notification-heading">We need your votes!</h2>
                            </div>
                            <div class="large-6 columns">
                                <p>There is a little competition going on right now and we want you to vote on projects for 2 seperate categories.</p>
                            </div>
                            <div class="large-6 columns">
                                <h3 class="projects-notification-subheading">Best experiment</h3>
                                <p>Lorem ipsum dolor sit amet.</p>
                                <h3 class="projects-notification-subheading">Most potential</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="projects-filter">
                        <input type="checkbox" class="projects-filter-toggle" id="projects-filter-toggle">
                        <label for="projects-filter-toggle" class="projects-filter-toggle-label">Filter</label>
                        <div class="projects-filter-content">
                            <?php
                                $categories = get_field_object('project-categories');

                                if ( $categories && isset($categories['choices']) && !empty($categories['choices']) ) {
                                    ?>
                                    <h4 class="projects-filter-heading">Categories</h4>
                                    <ul class="projects-filter-list">
                                        <?php foreach ( $categories['choices'] as $choice ) { ?>
                                            <li>
                                                <input type="checkbox" value="<?php echo $choice; ?>" id="<?php echo $choice; ?>">
                                                <label for="<?php echo $choice; ?>"><?php echo $choice; ?></label>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php
                                }
                            ?>
                            <h4 class="projects-filter-heading">Sort by</h4>
                            <ul class="projects-filter-list">
                                <li>
                                    <input type="radio" name="projects-sort" id="projects-sort-mostvotes" checked>
                                    <label for="projects-sort-mostvotes">Most votes</label>
                                </li>
                                <li>
                                    <input type="radio" name="projects-sort" id="projects-sort-bestexperiment">
                                    <label for="projects-sort-bestexperiment">Best experiment</label>
                                </li>
                                <li>
                                    <input type="radio" name="projects-sort" id="projects-sort-mostpotential">
                                    <label for="projects-sort-mostpotential">Most potential</label>
                                </li>
                                <li>
                                    <input type="radio" name="projects-sort" id="projects-sort-mostrecent">
                                    <label for="projects-sort-mostrecent">Most recent</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="projects-list row">
                <?php
                    while ( have_posts() ) {
                        the_post();
                        $image = get_field('project-image');
                        ?>
                        <li class="medium-6 columns"
                            data-categories="[<?php echo join(',', get_field('project-categories')); ?>]"
                            data-timestamp="<?php the_time('U'); ?>"
                            data-experiment-votes=""
                            data-potentional-votes="">
                            <div class="project-excerpt">
                                <div class="project-excerpt-image-container">
                                    <div class="project-excerpt-image"<?php if ( $image ) echo ' style="background-image: url(' . $image['sizes']['medium_large'] . ');"'; ?>></div>
                                </div>
                                <h2 class="project-excerpt-heading"><?php the_title(); ?></h2>
                                <?php if ( get_field('project-event') ) { ?>
                                    <small class="project-excerpt-subheading"><?php the_field('project-event'); ?></small>
                                <?php } ?>
                                <a href="<?php the_permalink(); ?>" class="project-excerpt-anchor"></a>
                                <?php if ( get_field('project-banner') ) { ?>
                                    <span class="project-excerpt-banner"><?php the_field('project-banner'); ?></span>
                                <?php } ?>
                                <?php if ( get_field('project-members') ) { ?>
                                    <ul class="project-excerpt-members">
                                        <?php
                                            while ( has_sub_field('project-members') ) {
                                                $image = get_sub_field('project-member-image');
                                                ?>
                                                <li title="<?php the_sub_field('project-member-name'); ?>"<?php if ( $image ) echo ' style="background-image: url(' . $image['sizes']['thumbnail'] . ');"'; ?>><?php the_sub_field('project-member-name'); ?></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                <?php } ?>
                                <div class="project-excerpt-votes">
                                    <span class="project-vote project-vote-experimental" title="Cast vote for best experiment"><?php echo get_post_meta(get_the_ID(), 'project-votes-experimental', true); ?></span>
                                    <span class="project-vote project-vote-potential" title="Cast vote for most potential"><?php echo get_post_meta(get_the_ID(), 'project-votes-potential', true); ?></span>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        <?php } else { ?>
            <p>No projects could be found.</p>
        <?php } ?>
    </div>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/projects.js"></script>
<?php get_footer(); ?>