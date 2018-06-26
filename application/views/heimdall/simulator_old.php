
<section class="apparitionright l-news-section">
    
    <div class="btns-calendar">
        <form action="" method="POST">
            <br/><br/>
            <label for="reload">Refresh : </label><input type="checkbox" name="azd" id="reload" checked />
        </form>

         <fieldset class="form-buttons">
            <ul>
                <?php foreach($all_characters as $key => $char){ 
                    echo "<li>";
                    print_r($char); 
                    echo "</li>";
                 }  ?>  
            </ul>
        </fieldset>
    </div>

     <br/><br/><br/> <br/><br/><br/>
     <div >
         <ul class="m-news-list">
            <?php foreach($dialogs as $key => $dialog){  ?>
            <li>
                <article>
                    <div>
                        <h3><?php echo $dialog->name; ?> <?php echo $dialog->firstname ?></h3>
                        <p><?php echo $dialog->value; ?></p>
                    </div>
                </article>
            </li>
            <?php } ?>
        </ul>
    </div>
    <hr/>
           
    <fieldset class="form-buttons">
        <form action="" method="POST">
            <?php foreach($answers as $key => $answers_char){  ?>
                <h3><?php echo $answers_char['name']; ?></h3>
                 <?php foreach($answers_char['answers'] as $key => $answer){  ?>
            <button name="answer" class="btn" value="<?php echo $answer->id; ?>" type="submit"><?php echo $answer->value; ?></button>
                <?php

                 } ?> 
            <?php  break; } ?> 
        </form>
    </fieldset>

    <hr/>
    <fieldset class="form-buttons">
        <form action="" method="POST">
            <?php foreach($reporting_characters as $key => $char){ ?>
            <button name="character" class="btn" <?php if(isset($char->active) && !$char->active) echo "disabled"; ?>  value="<?php echo $char->id; ?>" type="submit"><?php echo $char->name; ?> <?php echo $char->firstname; ?> <?php if(isset($char->alert) && $char->alert) echo "URGENT"; ?></button>
            <?php }  ?>  
        </form>
    </fieldset>
    <hr/>
       


</section>
           
