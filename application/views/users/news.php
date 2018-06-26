
<section class="l-annonces-search l-annonces-section apparitionright">
    <div class="clearfix l-top-annonces-export">
       <div class="btns-calendar">
            <a class="active" href="<?php echo site_url('users/news'); ?>"><?php echo $this->lang->line('new'); ?></a> 
            <a href="<?php echo site_url('users/index'); ?>"><?php echo $this->lang->line('liste'); ?></a>
        </div>
    </div>
    <!-- TODO ME : AJOUTER VERIFICATION FORM + LABELS -->
    <form action="" method="POST">
    <div class="l-annonces-form l-form">
        <fieldset class="inputstyle">
            <label for="email"><?php echo $this->lang->line('email'); ?></label>
            <input type="text" id="email" name="email" value='' required>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="password"><?php echo $this->lang->line('password'); ?></label>
            <input type="password" id="password" name="password" value='' required>
        </fieldset>
         <fieldset class="inputstyle">
            <label for="verify_password"><?php echo $this->lang->line('verify_password'); ?></label>
            <input type="password" id="verify_password" name="verify_password" value='' required>
        </fieldset>
        <hr/>
        <fieldset class="inputstyle">
            <label for="name"><?php echo $this->lang->line('name'); ?></label>
            <input type="text" id="name" name="name" value='' >
        </fieldset>
        <fieldset class="inputstyle">
            <label for="firstname"><?php echo $this->lang->line('firstname'); ?></label>
            <input type="text" id="firstname" name="firstname" value='' >
        </fieldset>
        <fieldset class="inputstyle select">
            <select name="agence">
                <?php foreach( $agences as $key => $agence){ ?>
                <option value="<?php echo $agence->id; ?>"><?php echo $agence->name; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="tel"><?php echo $this->lang->line('tel'); ?></label>
            <input type="text" id="tel" name="tel" value='' >
        </fieldset>
        <fieldset class="inputstyle">
            <label for="adress"><?php echo $this->lang->line('adress'); ?></label>
            <input type="text" id="adress" name="adress" value='' >
        </fieldset>
        <hr/>
      
        <fieldset class="radio-inline-cont ">
            <div>
                <input name="lang" type="radio" value="french" id="fr" required checked>
                <label for="fr"><?php echo $this->lang->line('french'); ?></label>
            </div><!--
             --><div>
                <input name="lang" type="radio" value="dutch" id="nl" required>
                <label for="nl"><?php echo $this->lang->line('dutch'); ?></label>
            </div>
        </fieldset>
        <fieldset class="inputstyle select">
            <select name="role">
                 <?php foreach( $roles as $key => $role){ ?>
                <option value="<?php echo $role->id; ?>" <?php if($role->id == 2) echo "selected"; ?>><?php echo $role->name; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset>
            <button name="save" class="btn" value="save" type="submit"><?php echo $this->lang->line('save'); ?></button>
         </fieldset>
    </div>
    </form>
    <!--<a href="" class="btn">Charger plus d'annonces</a>-->
</section>
