<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username or email address'); ?></legend>
        <?php echo $this->Form->input('username_email', array('label' => false));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Reset Password')); ?>
</div>
