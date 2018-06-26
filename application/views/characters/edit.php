
<section class="l-annonces-search l-annonces-section apparitionright">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="back_path" value="<?php echo $back_path; ?>">
        <input type="hidden" name="id" value="<?php echo $character->id; ?>">

        <div class="l-annonces-form l-form">
            <fieldset class="inputstyle">
                <label for="name"><?php echo $this->lang->line('name'); ?></label>
                <input type="text" id="name" name="name" value="<?php echo $character->name; ?>" required>
            </fieldset>

            <fieldset class="inputstyle">
                <label for="firstname"><?php echo $this->lang->line('firstname'); ?></label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $character->firstname; ?>" required>
            </fieldset>

             <fieldset class="inputstyle">
                <?php echo $this->lang->line('character_type'); ?> :
                <select name="character_type_id" id="character_type_id" class="selectpicker">
                    <?php foreach($characters_types as $key => $character_type){ ?>
                        <option value="<?php echo $character_type->id; ?>"
                            <?php if($character->character_type_id == $character_type->id) echo "selected"; ?>
                        ><?php echo $character_type->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('first_message'); ?> :
                <select name="first_message_id" id="first_message_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($messages as $key => $message){ ?>
                        <option value="<?php echo $message->id; ?>"
                            <?php if($character->first_message_id == $message->id) echo "selected"; ?>
                        ><?php echo $message->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('first_state'); ?> :
                <select name="first_state_id" id="first_state_id" class="selectpicker">
                    <option value="null"><?php echo $this->lang->line('nothing'); ?></option>
                    <?php foreach($states as $key => $state){ ?>
                        <option value="<?php echo $state->id; ?>"
                            <?php if($character->first_state_id == $state->id) echo "selected"; ?>
                        ><?php echo $state->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('first_area'); ?> :
                <select name="first_area_id" id="first_area_id" class="selectpicker">
                    <?php foreach($areas as $key => $area){ ?>
                        <option value="<?php echo $area->id; ?>"
                            <?php if($character->first_area_id == $area->id) echo "selected"; ?>
                        ><?php echo $area->name; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <fieldset class="inputstyle">
                <?php echo $this->lang->line('first_game_character_status'); ?> :
                <select name="first_game_character_status_id" id="first_game_character_status_id" class="selectpicker">
                    <?php foreach($games_character_status as $key => $game_character_status){ ?>
                        <option value="<?php echo $game_character_status->id; ?>"
                            <?php if($character->first_game_character_status_id == $game_character_status->id) echo "selected"; ?>
                        ><?php echo $game_character_status->value; ?></option>
                    <?php } ?>
                </select>
            </fieldset>
           
            <fieldset class="inputstyle">
                <?php echo $this->lang->line('icon'); ?>
                <img src="<?php echo $character->path; ?>" />
                <input type="file" name="picture" id="picture">
            </fieldset>


            <fieldset class="form-buttons">
                <button name="save" class="btn save" value="save" type="submit"><i class="fa fa-floppy-o"></i><span><?php echo $this->lang->line('save'); ?></span></button>
                <button name="delete" class="btn delete" value="delete" type="submit"><i class="fa fa-remove"></i><span><?php echo $this->lang->line('delete'); ?></span></button>
            </fieldset>
        </div>
    </form>
</section>
