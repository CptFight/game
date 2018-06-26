<section class="l-annonces-section l-annonces-search apparitionright">
    <form action="" method="POST" enctype="multipart/form-data">
   
        <div class="l-annonces-form l-form">

        <ul class="tabs">
            <li><div id="tab1"  data-select="tab1" class="<?php if($tab == 1) echo 'active'; ?>"><?php echo $this->lang->line('agence'); ?></div></li>
            <li><div id="tab2"  data-select="tab2" class="<?php if($tab == 2) echo 'active'; ?>"><?php echo $this->lang->line('account'); ?></div></li>
        </ul>
        <fieldset class="inputstyle select tabsselectcont">
            <select id="tabsselect" >
                <option value="tab1" <?php if($tab == 1) echo 'selected'; ?>><?php echo $this->lang->line('agence'); ?></option>
                <option value="tab2" <?php if($tab == 2) echo 'selected'; ?>><?php echo $this->lang->line('account'); ?></option>
            </select>
         </fieldset>

        <div class="block">
            <div class='<?php if($tab == 1) echo 'active'; ?> tab tab1'>
                 <br/>
                <fieldset class="inputstyle">
                    <label for="title"><?php echo $this->lang->line('name'); ?></label>
                    <input type="text" id="title" name="title" value="<?php echo $agence->name; ?>" disabled class="disabled">
                </fieldset>
                <div class="clearfix separation-form">
                    <div class="separation-form-title"><h3><?php echo $this->lang->line('adress'); ?>:</h3></div>
                    <div class="float-middle input-separation">
                        <div class="float-trois-quart input-separation">
                            <fieldset class="inputstyle">
                            <label for="adress"><?php echo $this->lang->line('adress'); ?></label>
                            <input type="text" id="adress" name="adress" value='<?php echo $agence->adress; ?>' >
                        </fieldset>
                        </div>
                        <div class="float-quart input-separation">
                            <fieldset class="inputstyle">
                                <label for="number"><?php echo $this->lang->line('number'); ?></label>
                                <input type="text" id="number" name="number" value='<?php echo $agence->number; ?>' >
                            </fieldset>
                        </div>
                    </div>
                    <div class="float-middle input-separation">
                        <div class="float-middle input-separation">
                            <fieldset class="inputstyle">
                                <label for="postcode"><?php echo $this->lang->line('postcode'); ?></label>
                                <input type="text" id="postcode" name="zipcode" value='<?php echo $agence->zipcode; ?>' >
                            </fieldset>
                        </div>
                        <div class="float-middle input-separation">
                            <fieldset class="inputstyle">
                                <label for="city"><?php echo $this->lang->line('city'); ?></label>
                                <input type="text" id="city" name="city" value='<?php echo $agence->city; ?>' >
                            </fieldset>
                        </div>
                    </div>
                </div>
                <fieldset class="inputstyle">
                    <label for="phone"><?php echo $this->lang->line('tel'); ?></label>
                    <input type="text" id="phone" name="tel" value='<?php echo $agence->tel; ?>' >
                </fieldset>
                <div class="clearfix separation-form ul-multiple-inputs-container no-bottom-margin">
                    <h3><?php echo $this->lang->line('status_favoris'); ?>:</h3>
                    <ul>
                    <?php $cpt = 0; ?>
                        <?php foreach($status_favoris as $key => $status){   ?>
                        <li>
                            <input type="hidden" name="status_favoris_id[]" value="<?php echo $status->id; ?>" >
                            <input type="hidden" name="status_favoris_color[]" class="status_color" value="<?php echo $status->color; ?>" >
                            <div class="inputsstatus">
                                <a href="javascript:;" class="btn-colorpicker colorpickerjs" ><span class="color-fill-icon dropdown-color-fill-icon" style="background-color:<?php echo $status->color; ?>;"></span></a>
                                <fieldset class="inputstyle">
                                    <label for="status<?php echo $cpt; ?>"><?php echo $this->lang->line('status'); ?></label>
                                    <input type="text" id="status<?php echo $cpt; ?>" name="status_favoris[]" value='<?php echo $status->name; ?>' >
                                </fieldset>
                            </div>
                        </li>
                        <?php $cpt++; } ?>

                        <?php for($i = $cpt; $i < 7; $i++){ ?>
                        <li>
                            <input type="hidden" name="status_favoris_id[]" value="" >
                            <input type="hidden" name="status_favoris_color[]" class="status_color" value="" >
                            <div class="inputsstatus">
                                <a href="javascript:;" class="btn-colorpicker colorpickerjs" ><span class="color-fill-icon dropdown-color-fill-icon" style="background-color:#ffffff;"></span></a>
                                <fieldset class="inputstyle">
                                    <label for="status<?php echo $i; ?>"><?php echo $this->lang->line('status'); ?></label>
                                    <input type="text" id="status<?php echo $i; ?>" name="status_favoris[]" value='' >
                                </fieldset>
                            </div>
                        </li>
                        <?php } ?>
                        
                    </ul>
                </div>
                <div class="clearfix separation-form ul-multiple-inputs-container no-top-margin">
                    <h3><?php echo $this->lang->line('status_owner'); ?>:</h3>
                    <ul>
                        <?php $cpt = 0;
                        foreach($status_owners as $key => $status){  ?>

                        <li>
                            <input type="hidden" name="status_owners_id[]" value="<?php echo $status->id; ?>" >
                            <input type="hidden" name="status_owners_color[]" class="status_color" value="<?php echo $status->color; ?>" >
                            
                            <div class="inputsstatus">
                                <a href="javascript:;" class="btn-colorpicker colorpickerjs" ><span class="color-fill-icon dropdown-color-fill-icon" style="background-color:<?php echo $status->color; ?>;"></span></a>
                                <fieldset class="inputstyle">
                                    <label for="status<?php echo $cpt; ?>"><?php echo $this->lang->line('status'); ?></label>
                                    <input type="text" id="status<?php echo $cpt; ?>" name="status_owners[]" value='<?php echo $status->name; ?>' >
                                </fieldset>
                            </div>
                        </li>
                        <?php $cpt++; } ?>

                        <?php for($i = $cpt; $i < 7; $i++){ ?>
                        <li>
                            <input type="hidden" name="status_owners_id[]" value="" >
                            <input type="hidden" name="status_owners_color[]" class="status_color" value="" >
                            
                            <div class="inputsstatus">
                                <a href="javascript:;" class="btn-colorpicker colorpickerjs" ><span class="color-fill-icon dropdown-color-fill-icon" style="background-color:#ffffff;"></span></a>
                                <fieldset class="inputstyle">
                                    <label for="status<?php echo $i; ?>"><?php echo $this->lang->line('status'); ?></label>
                                    <input type="text" id="status<?php echo $i; ?>" name="status_owners[]" value='' >
                                </fieldset>
                            </div>
                        </li>
                        <?php } ?>


                    </ul>

                </div>
            </div>
            <div class="tab tab2 <?php if($tab == 2) echo 'active'; ?>">

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
                <fieldset class="radio-inline-cont separation-form"><br/>
                    <?php echo $this->lang->line('direct_access_page'); ?> : 
                    <div>
                        <input name="direct_access_page" type="radio" value="1" id="direct_access_page_1" <?php if($user->direct_access_page == '1') echo 'checked'; ?>>
                        <label for="direct_access_page_1"><?php echo $this->lang->line('yes'); ?></label>
                    </div><!--
                     --><div>
                        <input name="direct_access_page" type="radio" value="0" id="direct_access_page_0" <?php if($user->direct_access_page == '0') echo 'checked'; ?>>
                        <label for="direct_access_page_0"><?php echo $this->lang->line('no'); ?></label>
                    </div>
                </fieldset>
                <fieldset class="radio-inline-cont ">
                    <?php echo $this->lang->line('autorisation_members'); ?> : 
                    <div >
                        <input name="public_access" type="radio" value="1" <?php if($user->public_access >= 1){ echo 'checked'; }?> id="autorisation_members_access_yes">
                        <label for="autorisation_members_access_yes"><?php echo $this->lang->line('yes'); ?></label>
                    </div><!--
                    --><div>
                        <input name="public_access" type="radio" value="0" <?php if($user->public_access == 0){ echo 'checked'; }?> id="autorisation_members_access_no">
                        <label for="autorisation_members_access_no"><?php echo $this->lang->line('no'); ?></label>
                    </div>
                    <div class="hidden">
                        <input name="public_access_option" type="radio" value="1" id="autorisation_members_access_option_0" <?php if($user->public_access_option == '1') echo 'checked'; ?> >
                        <label for="autorisation_members_access_option_0"><?php echo $this->lang->line('vue'); ?></label>
                    </div><!--
                     --><div class="hidden">
                        <input name="public_access_option" type="radio" value="2" id="autorisation_members_access_option_1" <?php if($user->public_access_option == '2') echo 'checked'; ?>>
                        <label for="autorisation_members_access_option_1"><?php echo $this->lang->line('edition'); ?></label>
                    </div>
                </fieldset>
                <hr/>
            </div>
        
        </div>

        <fieldset>
            <button name="save" class="btn" value="save" type="submit"><?php echo $this->lang->line('save'); ?></button>
         </fieldset>
    </form>
</section>
