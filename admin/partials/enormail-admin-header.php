<div class="enormail-header">
    <div class="enormail-header-logo">
        <img class="enormail-logo" src="/wp-content/plugins/enormail/admin/img/enormail-email-marketing-icon.png" alt="Enormail E-mail Marketing" />
    </div>
    <div class="enormail-header-title">
        <h2>Enormail E-mail Marketing</h2>
    </div>
</div>

<?php if ( isset( $apiVerified ) && $apiVerified === false ) : echo Enormail_Notifications::display( 'apikey_failed' ); endif; ?>
<?php if ( isset( $_GET['notify'] ) ) : echo Enormail_Notifications::display( $_GET['notify'] ); endif; ?>
