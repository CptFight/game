<script>
translate_words = {
<?php
foreach($this->lang->language as $key => $translate){
    ?>
    <?php echo $key; ?> : "<?php echo $translate; ?>" ,
<?php } ?>
}
</script>