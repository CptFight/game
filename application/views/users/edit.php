
<section class="l-annonces-search l-annonces-section apparitionright">
    <div class="clearfix l-top-annonces-export">
       <div class="btns-calendar">
            <a href="<?php echo site_url('users/news'); ?>"><?php echo $this->lang->line('new'); ?></a> 
            <a href="<?php echo site_url('users/index'); ?>"><?php echo $this->lang->line('liste'); ?></a>
        </div>
    </div>
    <form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
    <div class="l-annonces-form l-form">
        <fieldset class="inputstyle">
            <label for="email"><?php echo $this->lang->line('email'); ?></label>
            <input type="text" name="email" id="email" value='<?php echo $user->login; ?>' required>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="password"><?php echo $this->lang->line('password'); ?></label>
            <input type="password" id="password" name="password" value=''>
        </fieldset>
         <fieldset class="inputstyle">
            <label for="verify_password"><?php echo $this->lang->line('verify_password'); ?></label>
            <input type="password" id="verify_password" name="verify_password" value=''>
        </fieldset>
        <hr/>
        <fieldset class="inputstyle">
            <label for="name"><?php echo $this->lang->line('name'); ?></label>
            <input type="text" id="name" name="name" value='<?php echo $user->name; ?>' >
        </fieldset>
        <fieldset class="inputstyle">
            <label for="firstname"><?php echo $this->lang->line('firstname'); ?></label>
            <input type="text" id="firstname" name="firstname" value='<?php echo $user->firstname; ?>' >
        </fieldset>
        <fieldset class="inputstyle select">
            <select name="agence">
                <?php foreach( $agences as $key => $agence){ ?>
                <option value="<?php echo $agence->id; ?>" <?php if($user->agence_id == $agence->id) echo "selected"; ?>><?php echo $agence->name; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="tel"><?php echo $this->lang->line('tel'); ?></label>
            <input type="text" id="tel" name="tel" value='<?php echo $user->tel; ?>' >
        </fieldset>
        <fieldset class="inputstyle">
            <label for="adress"><?php echo $this->lang->line('adress'); ?></label>
            <input type="text" id="adress" name="adress" value='<?php echo $user->adress; ?>' >
        </fieldset>
        <fieldset class="radio-inline-cont ">
            <div>
                <input name="lang" type="radio" value="french" id="fr" <?php if($user->lang == 'french') echo 'checked'; ?>>
                <label for="fr"><?php echo $this->lang->line('french'); ?></label>
            </div><!--
             --><div>
                <input name="lang" type="radio" value="dutch" id="nl" <?php if($user->lang == 'dutch') echo 'checked'; ?>>
                <label for="nl"><?php echo $this->lang->line('dutch'); ?></label>
            </div>
        </fieldset>
        <hr/>
         
        <fieldset class="inputstyle select">
            <select name="role">
                <?php foreach( $roles as $key => $role){ ?>
                <option value="<?php echo $role->id; ?>" <?php if($user->role_id == $role->id) echo "selected"; ?>><?php echo $role->name; ?></option>
                <?php } ?>
            </select>
        </fieldset>

        <fieldset class="radio-inline-cont ">
            <div>
                <input name="deleted" type="radio" value="0" id="delete-no" <?php if($user->deleted == 0) echo 'checked'; ?>>
                <label for="delete-no"><?php echo $this->lang->line('active'); ?></label>
            </div><!--
             --><div>
                <input name="deleted" type="radio" value="1" id="delete-yes" <?php if($user->deleted == 1) echo 'checked'; ?>>
                <label for="delete-yes"><?php echo $this->lang->line('no_active'); ?></label>
            </div>
        </fieldset>

        <fieldset class="form-buttons">
            <button name="save" class="btn save" value="save" type="submit"><i class="fa fa-floppy-o"></i><span><?php echo $this->lang->line('save'); ?></span></button>
            <button name="delete" class="btn delete" value="delete" type="submit"><i class="fa fa-remove"></i><span><?php echo $this->lang->line('delete'); ?></span></button>


            <a class="btn archive" href="<?php echo site_url('users/change').'?id='.$user->id.'&token='.md5('immofficetoken'.date('h')).'&back_path=annonces/index'; ?>"><i class="fa fa-archive"></i><span><?php echo $this->lang->line('login'); ?></span></a>

            
         </fieldset>
    </div>
    </form>
    <!--<a href="" class="btn">Charger plus d'annonces</a>-->
</section>
