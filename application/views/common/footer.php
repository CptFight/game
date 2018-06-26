    
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $current_user->id; ?>" />

                <footer class="footer-annonces">
                    <p><span>Copyright</span> <?php echo $this->lang->line('app_name'); ?> © 2017-2018</p>
                </footer>
            </div>
        
        </div>
        <aside class="l-nav-aside hide-menu" >
            <div class="m-map-marker"><i class="fa fa-map-marker"></i></div>
            <div class="dropdown-container dropdown-profile">
                <a href="javascript:;" class="btn-dropdown profile-btn" data-id="profile">
                    <span><?php echo $current_user->firstname; ?></span>
                    <?php echo $this->lang->line('my_account'); ?>
                </a>
                <ul class="dropdown hidden" id="profile">
                    <li><a href="<?php echo site_url('users/edit_profile'); ?>"><?php echo $this->lang->line('edit_my_profil'); ?></a></li>
                    <li><a href="<?php echo site_url('users/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a></li>
                </ul>
            </div>
            
            <ul class="l-nav-big">
                <li><a href="<?php echo site_url('stuffs/index'); ?>" class='<?php if($pagename == "stuffs") echo "active"; ?>'><i class="fa fa-object-ungroup"></i><span><?php echo $this->lang->line('menu_stuffs'); ?></span></a></li>

                <li><a href="<?php echo site_url('characters/index'); ?>" class='<?php if($pagename == "characters") echo "active"; ?>'><i class="fa fa-user"></i><span><?php echo $this->lang->line('menu_characters'); ?></span></a></li>

                <li><a href="<?php echo site_url('states/index'); ?>" class='<?php if($pagename == "states") echo "active"; ?>'><i class="fa fa-crosshairs"></i><span><?php echo $this->lang->line('menu_states'); ?></span></a></li>

                <li><a href="<?php echo site_url('areas/index'); ?>" class='<?php if($pagename == "areas") echo "active"; ?>'><i class="fa fa-map"></i><span><?php echo $this->lang->line('menu_areas'); ?></span></a></li>
                
                <li><a href="<?php echo site_url('messages/index'); ?>" class='<?php if($pagename == "messages") echo "active"; ?>'><i class="fa fa-comments"></i><span><?php echo $this->lang->line('menu_messages'); ?></span></a></li>

                 <li><a href="<?php echo site_url('games/index'); ?>" class='<?php if($pagename == "games") echo "active"; ?>'><i class="fa fa-rocket"></i><span><?php echo $this->lang->line('menu_games'); ?></span></a></li>
            

                 <li><a href="<?php echo site_url('heimdall/simulator?game_id=1'); ?>" target="_blank" class='<?php if($pagename == "heimdall") echo "active"; ?>'><i class="fa fa-rocket"></i><span><?php echo $this->lang->line('menu_simulator'); ?></span></a></li>
            
            </ul>

        </aside>
    </div>
</body>