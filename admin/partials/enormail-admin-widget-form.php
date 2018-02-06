<p>
    <label for="<?php echo $this->get_field_id('enormail_form_id'); ?>"><?php echo __( 'Select a form', 'enormail' ); ?>:</label>
    <select id="<?php echo $this->get_field_id('enormail_form_id'); ?>" name="<?php echo $this->get_field_name('enormail_form_id'); ?>" style="width:100%;">
        <?php foreach($formsList as $form_id => $name) : ?>
        <option value="<?php echo $form_id; ?>"<?php if ($id == $form_id) : ?> selected<?php endif; ?>><?php echo $name; ?></option>
        <?php endforeach; ?>
    </select>
</p>