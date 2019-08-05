<?php if($this->session->flashdata('message')) : ?>
<div class="alert alert-block alert-success">
	<button type="button" class="close" data-dismiss="alert">
		<i class="ace-icon fa fa-times"></i>
	</button>
	<?php echo $this->session->flashdata('message'); ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')) : ?>
<div class="alert alert-block alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<i class="ace-icon fa fa-times"></i>
	</button>
	<?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>