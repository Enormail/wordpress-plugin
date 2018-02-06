<!-- Wrapper -->
<div class="enormail-wrapper">

    <!-- Header -->
    <?php include 'enormail-admin-header.php'; ?>
    <!-- /Header -->

    <!-- Content -->
    <div class="enormail-content enormail-content-sm">

        <h1><?php echo __( 'Enormail API key', 'enormail' ); ?></h1>
        <p class="lead"><?php echo __("We need an API key to connect your Enormail account to your Wordpress website. Please login to your Enormail account and create an API key.", 'enormail'); ?></p>

        <?php settings_errors(); ?>

        <form method="post" action="<?php echo admin_url('admin.php?page=enormail-api-key&noheader=true'); ?>">

            <div class="enormail-well">
                <div class="enormail-api-key-field">
                    <label><?php echo __( 'Enormail API key', 'enormail' ); ?></label>
                    <input type="text" class="enormail-api-key-input" name="enormail_api_key" value="<?php echo esc_html(get_option('enormail_api_key')); ?>">
                    <p class="description"><?php echo __( 'Don\'t have an API key?', 'enormail' ); ?> <a href="https://app.enormail.eu/login?referrer=/account/api" target="_blank"><?php echo __( 'Create an Enormail API key!', 'enormail' ); ?></a></p>
                </div>
            </div>

            <button type="submit" class="button button-primary button-hero"><?php echo __( 'Connect your Enormail account', 'enormail' ); ?></button>

        </form>

    </div>
    <!-- /Content -->

</div>
<!-- /Wrapper -->
