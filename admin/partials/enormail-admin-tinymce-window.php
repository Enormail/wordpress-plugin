<html>
<head>
    <title><?php echo __('Enormail subscribe form', 'enormail'); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <link rel='stylesheet' id='enormail-css'  href='<?php echo ENORMAIL_PLUGIN_URL; ?>admin/css/enormail-admin.css?ver=1.0.0' type='text/css' media='all' />
</head>

<body>

    <div class="enormail-tinymce-content wp-core-ui">

        <form id="js-enormail-tinymce-form" action="javascript:;" method="post">

            <p><?php echo __( 'Select a subscribe form to embed in your post or page.', 'enormail' ); ?></p>

            <p>
                <label for="enormail-form-id"><?php echo __('Form', 'enormail'); ?></label><br/>
                <select class="enormail-input-select-lg" id="enormail-form-id" name="enormail_form_id">
                    <?php foreach ($formsList as $formId => $name) : ?>
                        <option value="<?php echo $formId; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <button id="js-enormail-button-shortcode" class="button button-primary button-large"><?php echo __('Add form shortcode', 'enormail'); ?></button>

        </form>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('#js-enormail-button-shortcode').click(function () {
                    var formId = jQuery('#js-enormail-tinymce-form #enormail-form-id').val();
                    var shortcode = '[enormail_form form_id=' + formId + ']';
                    tinyMCEPopup.execCommand("mceInsertContent", false, shortcode);
                    tinyMCEPopup.close();
                    return false;
                });
            });
        </script>

    </div>

</body>
</html>