<!-- Wrapper -->
<div class="enormail-wrapper">

    <!-- Header -->
    <?php include 'enormail-admin-header.php'; ?>
    <!-- /Header -->

    <!-- Content -->
    <div class="enormail-content enormail-content">

        <h1><?php echo __( 'WooCommerce settings', 'enormail' ); ?></h1>
        <p class="lead"><?php echo __("Configure settings to integrate Enormail in your WooCommerce checkout process.", 'enormail'); ?></p>

        <?php settings_errors(); ?>

        <div class="enormail-form-wrapper">

            <form method="post" action="<?php echo admin_url('admin.php?page=enormail-woocommerce&noheader=true'); ?>">
                <table class="form-table">
                    <tr>
                        <th><?php echo __( 'Default list', 'enormail' ); ?></th>
                        <td>
                            <select id="js-enormail-list-select" name="enormail_woocommerce_listid">
                                <option value=""><?php echo __( 'Please select a list', 'enormail' ); ?></option>
                                <?php foreach ($apiListsList as $listId => $name) : ?>
                                    <option value="<?php echo  $listId; ?>"<?php if ($listId == $list->listid) : ?> selected<?php endif; ?>><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php echo __( 'By default customers will be default placed in this mailing list.', 'enormail' ); ?></p>
                        </td>
                    </tr>
                </table>
            </form>

            <button type="submit" class="button button-primary button-hero"><?php echo __( 'Save settings', 'enormail' ); ?></button>

        </div>

    </div>
    <!-- /Content -->

</div>
<!-- /Wrapper -->