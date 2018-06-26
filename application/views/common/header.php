
<body class="l-annonces" id="annonces">
    <div class="wrapper">
        <div class="content" >      
            <header class="l-header clearfix">
                <button id="btn-toggle-nav" class="btn"><i class="fa fa-plus"></i></button>
                <h1 class="visuallyhidden"><?php echo $this->lang->line('app_name'); ?></h1>
                <nav class="l-nav-top">
                    <ul>
                        <li><a href="<?php echo site_url('users/logout'); ?>"><i class="fa fa-sign-out"></i> <?php echo $this->lang->line('logout'); ?></a></li>
                    </ul>
                </nav>
            </header>
            <div class="title-container">
                <h2><?php echo $header['page_title']; ?></h2>
            </div>
            <ul class="m-breadcrumb">
                <li>
                    <?php foreach($header['breadcrumb'] as $key => $page){ ?>
                    <a href="<?php echo $page['url']; ?>" class="<?php if($page['active']) echo 'active'; ?>"><?php echo $page['title']; ?></a>
                    <?php } ?>
                    <!--<span class="alert alert-warning" style="padding: 5px;"><?php echo $this->lang->line('problem'); ?></span> -->
                </li>
            </ul>
