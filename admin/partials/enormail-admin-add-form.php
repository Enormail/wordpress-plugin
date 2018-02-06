<!-- Wrapper -->
<div class="enormail-wrapper">

    <!-- Header -->
    <?php include 'enormail-admin-header.php'; ?>
    <!-- /Header -->

    <!-- Content -->
    <div class="enormail-content enormail-content">

            <h1><?php echo __( 'Create new form', 'enormail' ); ?></h1>

            <div class="enormail-form-wrapper">
                <?php if ($apiFormList) : ?>
                    <form method="post" action="<?php echo admin_url('admin.php?page=enormail-admin&view=add_form&noheader=true'); ?>">
                        <table class="form-table">
                            <tr>
                                <th><?php echo __( 'Form title', 'enormail' ); ?></th>
                                <td>
                                    <input id="enormail_form_title" name="enormail_form_name" type="text" value="<?php echo __( 'New form', 'enormail' ); ?>" class="regular-text">
                                    <p class="description"><?php echo __( 'This title won\'t be displayed in public', 'enormail' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo __( 'Embed form', 'enormail' ); ?></th>
                                <td>
                                    <select id="js-enormail-form-select" name="enormail_formid">
                                        <?php foreach ($apiFormList as $formId => $name) : ?>
                                            <option value="<?php echo  $formId; ?>"><?php echo  $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description"><?php echo __( 'This form will be embedded from your Enormail account', 'enormail' ); ?></p>
                                </td>
                            </tr>
                        </table>

                        <div id="js-enormail-webform-preview" class="enormail-webform-preview"></div>

                        <button type="submit" class="button button-primary button-hero"><?php echo __( 'Create form', 'enormail' ); ?></button>

                        <script type="text/javascript">
                            jQuery(window).load(function () {
                                var formId = jQuery('#js-enormail-form-select').val();
                                jQuery('#js-enormail-webform-preview').html('<iframe class="enormail-preview-frame" src="https://app.enormail.eu/subscribe/'+formId+'"></iframe>');
                            });
                        </script>
                    </form>
                <?php else : ?>

                <?php endif; ?>
            </div>

    </div>
    <!-- /Content -->

</div>
<!-- /Wrapper -->