<?php $errors = $this->session->flashdata('errors');; ?>

<?php if($errors && is_array($errors) && count($errors) > 0) { ?>
<div style="border:1px; color:red;">
<ul class="errors">
<?php foreach($errors as $key => $message){ ?>
	<li><?php echo $message; ?></li>
<?php } ?>
</ul>
</div>
<?php } ?>