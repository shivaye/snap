<?php
/**
 * Footer v2 for Tokoo
 */
?>
            </div><!-- /.site-content-inner -->
        </div><!-- /.site-content -->
    </div><!-- /.container -->
    
    <?php do_action( 'tokoo_before_footer_v2' ); ?>

    <footer class="site-footer footer-v2">
        <?php
            do_action( 'tokoo_footer_v2' ); ?>
    </footer>

    <?php do_action( 'tokoo_after_footer_v2' ); ?>

</div><!-- /#page -->

<?php wp_footer(); ?>

</body>
</html>