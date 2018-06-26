
<section class="l-annonces-search l-annonces-section apparitionright">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="back_path" value="<?php echo $back_path; ?>">
        <input type="hidden" name="id" value="<?php echo $message->id; ?>">

        <div class="l-annonces-form l-form">
           
            <fieldset class="inputstyle">
                <?php echo $this->lang->line('area'); ?> :
                <select name="area_id" id="area_id" class="selectpicker">
                    <?php foreach($areas as $key => $area){ ?>
                        <option value="<?php echo $area->id; ?>"
                            <?php if($message->area_id == $area->id) echo "selected"; ?>
                        ><?php echo $area->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('character_from'); ?> :
                <select name="character_from_id" id="character_from_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($characters as $key => $character){ ?>
                        <option value="<?php echo $character->id; ?>"
                            <?php if($message->character_from_id == $character->id) echo "selected"; ?>
                        ><?php echo $character->name; ?> <?php echo $character->firstname; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('character_to'); ?> :
                <select name="character_to_id" id="character_to_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($characters as $key => $character){ ?>
                        <option value="<?php echo $character->id; ?>"
                            <?php if($message->character_to_id == $character->id) echo "selected"; ?>
                        ><?php echo $character->name; ?> <?php echo $character->firstname; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('message_type'); ?> :
                <select name="message_type_id" id="message_type_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($messages_types as $key => $message_type){ ?>
                        <option value="<?php echo $message_type->id; ?>"
                            <?php if($message->message_type_id == $message_type->id) echo "selected"; ?>
                        ><?php echo $message_type->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('message_from'); ?> :
                <select name="message_from_id" id="message_from_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($messages as $key => $message_list){ ?>
                        <option value="<?php echo $message_list->id; ?>"
                            <?php if($message->message_from_id == $message_list->id) echo "selected"; ?>
                        ><?php echo $message_list->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('message_to'); ?> :
                <select name="message_to_id" id="message_to_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($messages as $key => $message_list){ ?>
                        <option value="<?php echo $message_list->id; ?>"
                            <?php if($message->message_to_id == $message_list->id) echo "selected"; ?>
                        ><?php echo $message_list->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

             <fieldset class="inputstyle">
                <label for="value"><?php echo $this->lang->line('value'); ?></label>
                <textarea required id="value" name="value" ><?php echo $message->value; ?></textarea>
            </fieldset>


            <fieldset class="form-buttons">
                <button name="save" class="btn save" value="save" type="submit"><i class="fa fa-floppy-o"></i><span><?php echo $this->lang->line('save'); ?></span></button>
                <button name="delete" class="btn delete" value="delete" type="submit"><i class="fa fa-remove"></i><span><?php echo $this->lang->line('delete'); ?></span></button>
            </fieldset>
        </div>
    </form>
</section>
