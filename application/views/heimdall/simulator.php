
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
    <head>
        <title>Radio</title>
        <meta charset="utf-8">
           <meta name="author" content="Gabygaël Pirson">
        <meta name="description" content="" />
        <meta name="keywords" content="" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>/assets/simulator/css/screen.css">
    </head>
    <body class="blue"> <!-- blue purple green red yellow-->

        <?php //print_r($dialogs); ?>
       

        <?php //print_r($all_characters); ?>
        <div class="wrapper">
            <ul class="messages">
                <?php 
                    $first = true;
                    $current_character_from_id = false;
                ?>

                <?php foreach($dialogs as $key => $dialog){  ?>
                <?php 

                if($dialog->character_from_id == 1){
                    $class = '';
                    $first = true;
                }else{
                    if($current_character_from_id != $dialog->character_from_id){
                        $class = 'other other-first';
                        $first = false;
                        $current_character_from_id = $dialog->character_from_id;
                    }else{
                        $class = 'other';
                    }
                    $current_character_from_id = $dialog->character_from_id;
                }
                
                ?>
                <li class="<?php echo $class; ?>">
                    <div class="message">
                        <p class="message-infos"><span><?php echo $dialog->name; ?> <?php echo $dialog->firstname ?></span> <?php echo $dialog->area_name; ?> | <?php echo date('Y-m-d H:i:s',$dialog->date); ?></p>


                        <p><?php echo $dialog->value; ?></p>
                    </div>
                </li>
                <?php } ?>
                <?php /*
                <li class="other other-first">
                    <div class="message">
                        <p class="message-infos"><span>Jasper</span> Zone du Crash | 17:01</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </li>
                <li class="other">
                    <div class="message">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </li>
                <li>
                    <div class="message">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                    </div>
                </li>
                 <li class="other other-first">
                    <div class="message">
                        <p class="message-infos"><span>Jasper</span> Zone du Crash | 17:01</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </li>
                */ ?>
            </ul>
            <ul class="answers"> <!--  -->
                <form action="" method="POST">
                <?php foreach($answers as $key => $answers_char){ ?>
                    <?php foreach($answers_char['answers'] as $key => $answer){  ?>
                    <li>
                        <div class="message">
                            <button name="answer" value="<?php echo $answer->id; ?>" type="submit"> <b><?php echo $answers_char['name']."</b> : ".$answer->value; ?></button>
                        </div>
                    </li>
                    <?php } ?>
                <?php } ?>
               </form>
            </ul>
            <footer>
                <a class="btn btn-options" href=""><span>Options</span></a>
                <a class="btn btn-planet" href=""><span>Planet</span></a>
                <form action="" method="POST">
                    <ul class="contacts">

                        <?php //MARIE Y EN A UN MAIS IL NE S'AFFICHE PAS
                        foreach($reporting_characters as $key => $char){ ?>
                        <li class="contact-<?php echo $char->color; ?>"  > <button name="character" <?php if(isset($char->active) && !$char->active) echo "disabled"; ?>  value="<?php echo $char->id; ?>" type="submit" ><?php echo $char->name." ".$char->firstname; ?></button></li>
                        <?php } ?>
                        <?php /*
                        <li class="contact-purple"><a href="" class="new"><span>Bob</span></a></li>
                        <li class="contact-green"><a href="" class="typing"><span>Frank</span></a></li>
                        <li class="contact-red"><a href=""><span>Andrew</span></a></li>
                        <li class="contact-yellow"><a href="" class="active"><span>Terry</span></a></li>
                        */ ?>
                    </ul>
                </form>
               
            </footer>

            <?php if(isset($_GET['debug'])) { ?>
            <div>
                 <ul>
                <?php foreach($all_characters as $key => $char){ 
                    echo "<li><pre>";
                    print_r($char); 
                    echo "</pre></li>";
                 }  ?>  
            </ul>

            </div>
            <?php } ?>
        </div>
    </body>
       


</html>
<script src="<?php echo base_url(); ?>/assets/simulator/js/libs/jquery-3.2.0.js"></script>