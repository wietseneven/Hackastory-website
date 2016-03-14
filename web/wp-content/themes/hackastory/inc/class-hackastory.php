<?php
class Hackastory {
    const DATE_FORMAT = "D d M Y";
    const DEFAULT_RECENT_BLOG_POST_COUNT = 5;
    const DEFAULT_NAVMENU = "menu";

    function __construct() {
        add_theme_support( 'post-thumbnails' );
        $this->defaultPostThumb = $this->getTheme() . "/img/logo-circle.png";

        // Remove stupid WP emoji support
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );

        // Add projects CPT
        register_post_type('projects', array(
            'labels' => array(
                'menu_name'          => 'Projects',
                'name'               => __('Project'),
                'singular_name'      => __('Project'),
                'add_new'            => __('Add'),
                'add_new_item'       => __('Add new project'),
                'edit_item'          => __('Edit project'),
                'new_item'           => __('New project'),
                'all_items'          => __('All projects'),
                'view_item'          => __('View project'),
                'search_items'       => __('Search projects'),
                'not_found'          => __('No projects found'),
                'not_found_in_trash' => __('No projects found in trash'),
            ),
            'public'        => true,
            'has_archive'   => true,
            'menu_position' => 9
        ));

        // Add votes metabox
        function hackastory_votes_meta_box($post_type, $post) {
            add_post_meta($post->ID, 'project-votes-experimental', 0, true);
            add_post_meta($post->ID, 'project-votes-potential', 0, true);

            add_meta_box('votes_box', 'Votes', function($post) {
                echo 'Best experiment: ' . get_post_meta($post->ID, 'project-votes-experimental', true) . '<br>';
                echo 'Most potential: ' . get_post_meta($post->ID, 'project-votes-potential', true);
            }, array('projects'), 'side');
        }
        add_action('add_meta_boxes', 'hackastory_votes_meta_box', 10, 2);

        // Define ajaxurl in frontend
        function hackastory_ajaxurl() {
            ?>
            <script type="text/javascript">
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            </script>
            <?php
        }
        add_action('wp_head', 'hackastory_ajaxurl');

        // AJAX voting
        function hackastory_votes_callback() {
            $post_id  = $_POST['post_id'];
            $meta_key = 'project-votes-' . $_POST['type'];
            $votes    = max(0, get_post_meta($post_id, $meta_key, true) + intval($_POST['votes']));

            update_post_meta($post_id, $meta_key, $votes);
            wp_die();
        }
        add_action('wp_ajax_hackastory_votes', 'hackastory_votes_callback');
    }

    public function navMenu($handle = self::DEFAULT_NAVMENU) {
        wp_nav_menu([
            "handle" => $handle,
            "container" => false
        ]);
    }

    public function time() {
        the_time( self::DATE_FORMAT);
    }

    public function getPostThumb() {
        global $post;
        $thumbid = get_post_thumbnail_id($post->ID);
        $img = wp_get_attachment_image_src($thumbid);
        if ($img) {
            return $img[0];
        } else {
            return $this->defaultPostThumb;
        }
    }

    public function getTime() {
        return get_the_time(self::DATE_FORMAT);
    }

    public function getTheme() {
        return get_bloginfo('template_directory');
    }

    public function getHome() {
        return get_bloginfo('url');
    }

    public function getRecentBlogPosts($count = self::DEFAULT_RECENT_BLOG_POST_COUNT) {
        global $post;

        $query = new WP_Query("showposts=" . $count);
        $posts = [];

        while ($query->have_posts()) {
            $query->the_post();

            $p = new stdClass;
            $p->link = get_permalink();
            $p->title = get_the_title();
            $p->time = $this->getTime();

            $posts[] = $p;
        }

        return $posts;
    }

    public function getLatestPostsInCategory($id, $limit) {
        $q = new WP_Query(array(
            "cat" => $id,
            "posts_per_page" => $limit
        ));

        return $q->have_posts() ? $q : false;
    }

    public function getPreviousPostLink() {
        return $this->getAdjacentPostLink("previous");
    }

    public function getNextPostLink() {
        return $this->getAdjacentPostLink("next");
    }

    private function getAdjacentPostLink($type) {
        $previous = ($type == "previous");
        $post = get_adjacent_post(false, '', $previous);
        if (!post) return;
        return get_permalink($post);
    }
}