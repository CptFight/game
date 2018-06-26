
<section class="l-annonces-search l-annonces-section apparitionright">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="back_path" value="<?php echo $back_path; ?>">
        <input type="hidden" name="id" value="<?php echo $state->id; ?>">

        <div class="l-annonces-form l-form">
            <fieldset class="inputstyle">
                <label for="name"><?php echo $this->lang->line('name'); ?></label>
                <input type="text" id="name" name="name" value="<?php echo $state->name; ?>" required>
            </fieldset>
           
            <fieldset class="inputstyle">
                <?php echo $this->lang->line('icon'); ?>
                <img src="<?php echo $state->path; ?>" />
                <input type="file" name="picture" id="picture">
            </fieldset>

            <fieldset class="form-buttons">
                <button name="save" class="btn save" value="save" type="submit"><i class="fa fa-floppy-o"></i><span><?php echo $this->lang->line('save'); ?></span></button>
                <button name="delete" class="btn delete" value="delete" type="submit"><i class="fa fa-remove"></i><span><?php echo $this->lang->line('delete'); ?></span></button>
            </fieldset>
        </div>
    </form>
</section>
