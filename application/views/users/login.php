
    <body class="l-landing">
        <div class="wrapper" id="top"> 
            <button id="btn-toggle-nav" class="btn"><i class="fa fa-plus"></i></button>
            <div class="content">            
                
                <section class="l-landing-welcome">
                    <div class="clearfix max-width apparition">
                        <div class="float-middle">
                            <h2 class="titre-green"><?php echo $this->lang->line('login_title'); ?> <?php echo $this->lang->line('app_name'); ?></h2>
                            <p class="subtitle"><?php echo $this->lang->line('login_text'); ?></p>
                        </div>
                        <div class="float-middle">
                            <form action="" method="POST">
                                <input type="email" id="login-email" name="login" class="form-control" placeholder="Email" required="">
                                <input type="password" id="login-password" name="password" class="form-control" placeholder="Mot de passe" required="">
                                <input type="submit" class="btn" name="send-login" value="<?php echo $this->lang->line('login'); ?>" />
                            </form>
                            <a href="<?php echo site_url('users/lost_password'); ?>" class="link-password"><?php echo $this->lang->line('forgot_password'); ?></a>
                            <?php $this->load->view('common/messages') ?>
                            <?php $this->load->view('common/errors') ?>
                        </div>
                       
                    </div>
                     
                </section>
               
            </div>
          
        </div>
    </body>
   