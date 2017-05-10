<div id="footerwrap">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-4">
                <?php 
                if (is_active_sidebar('footer-left'))
                    dynamic_sidebar ('footer-left'); ?>
            </div>
            <div class="col-md-4">
                <?php 
                if (is_active_sidebar('footer-mid'))
                    dynamic_sidebar ('footer-mid'); ?>
            </div>
            <div class="col-md-3 col-lg-4">
                <?php 
                if (is_active_sidebar('footer-right'))
                    dynamic_sidebar ('footer-right'); ?>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /footerwrap -->

<?php wp_footer(); ?>
</body>
</html>