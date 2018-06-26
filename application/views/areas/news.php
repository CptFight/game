
<section class="l-annonces-search l-annonces-section apparitionright">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="back_path" value="<?php echo $back_path; ?>">
        <input type="hidden" name="id" value="">

        <div class="l-annonces-form l-form">
            <fieldset class="inputstyle">
                <label for="name"><?php echo $this->lang->line('name'); ?></label>
                <input type="text" id="name" name="name" required>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('first_message'); ?> :
                <select name="first_message_id" id="first_message_id" class="selectpicker">
                    <?php foreach($messages as $key => $message){ ?>
                        <option value="<?php echo $message->id; ?>"><?php echo $message->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('accessibilite'); ?> :
                <select name="accessibilite[]" id="accessibilite" class="selectpicker" multiple>
                    <?php foreach($areas as $key => $info_area){ ?>
                        <option value="<?php echo $info_area->id; ?>"><?php echo $info_area->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
           
            <fieldset class="inputstyle">
                <?php echo $this->lang->line('icon'); ?>
                <input type="file" name="icon" id="icon">
            </fieldset>

             <fieldset class="inputstyle">
                <?php echo $this->lang->line('picture'); ?>
                <input type="file" name="picture" id="picture">
            </fieldset>
            
            <fieldset class="form-buttons">
                <button name="save" class="btn save" value="save" type="submit"><i class="fa fa-floppy-o"></i><span><?php echo $this->lang->line('save'); ?></span></button>
                <button name="delete" class="btn delete" value="delete" type="submit"><i class="fa fa-remove"></i><span><?php echo $this->lang->line('delete'); ?></span></button>
            </fieldset>
        </div>
    </form>
</section>
