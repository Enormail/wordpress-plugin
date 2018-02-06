<!-- Wrapper -->
<div class="enormail-wrapper">

    <!-- Header -->
    <?php include 'enormail-admin-header.php'; ?>
    <!-- /Header -->

    <!-- Content -->
    <div class="enormail-content enormail-content">

        <h1 class="enormail-heading-inline"><?php echo __( 'Forms', 'enormail' ); ?></h1>
        <a class="enormail-heading-action button" href="<?php echo admin_url('admin.php?page=enormail-admin&view=add_form'); ?>"><?php echo __( 'Create form', 'enormail' ); ?></a>

        <div class="enormail-table-wrapper">
            <form id="enormail-form-list-options" method="post" action="<?php echo 'admin.php?page=enormail-admin&noheader=true'; ?>">
                <?php
                $formsTable->prepare_items();
                $formsTable->display();
                ?>
            </form>
        </div>

    </div>
    <!-- /Content -->

</div>
<!-- /Wrapper -->