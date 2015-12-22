<?php global $T; ?>
    <footer class="footer">
        <div class="footer-right">
            <?php $T->navMenu(); ?>

            <ul class="share menu">
                <?php require 'share.php'; ?>
            </ul>
        </div>
    </footer>

<?php wp_footer(); ?>
    <script src="<?= $T->getTheme(); ?>/js/app.js"></script>
<!--
    <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds.
    Serverd from: <?php echo $_SERVER['SERVER_ADDR']; ?>
-->
</body>
</html>