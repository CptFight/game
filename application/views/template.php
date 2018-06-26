<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
    <head>
        <title><?php echo $this->lang->line('website_title'); ?></title>
        <meta charset="utf-8">
        <meta name="author" content="Gabygaël Pirson">
        <meta name="description" content="<?php echo $this->lang->line('website_description'); ?>" />
        <meta name="keywords" content="" />
        <meta name="google-site-verification" content="ohU9UZxMyldgxXdJeX3kRO9RZpwDAnAmko9c36AeN7s" />
        <?php $this->load->view('common/css') ?>

        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/global/img/favicon.ico">
        
       

        <script src="<?php echo base_url(); ?>/assets/global/libs/modernizr.js"></script>
        <!--<meta name="google-signin-client_id" content="381487630406-vhvcp9hcod69rtf4sdj8eih3gmfrp74q.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js?signed_in=false" async defer></script>
        <script type="text/javascript">
            function onSignIn(googleUser) {
                $('.g-signin2').remove();
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); 
}
</script> -->
    </head>
    
    <?php $this->load->view('common/set_js_var') ?>
	   <?php $this->load->view('common/header') ?>
     <?php $this->load->view('common/messages') ?>
     <?php $this->load->view('common/errors') ?>
	   <?php $this->load->view($this->router->class.'/'.$this->router->method) ?>
		
     <?php $this->load->view('common/footer') ?>
     <?php $this->load->view('common/js') ?>
</html>