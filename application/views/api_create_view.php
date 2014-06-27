<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
		<?php $this->load->view('tm_top_menu'); ?>
		<?php $this->load->view('tm_sidemenu'); ?>            
	</nav>

	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="page-header">Create New API</h4>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php if(validation_errors()){ ?>
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
				<?php } ?>
				<?php 
				$attributes = array('class' => 'form-horizontal', 'id' => 'createTag');
				echo form_open('api/createAPI', $attributes); ?>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="p_width" class="col-sm-2 control-label">Container Width</label>
						<div class="col-sm-10">
							<input class="form-control" name="p_width" id="p_width" type="text" value="<?php echo set_value('p_width'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="p_height" class="col-sm-2 control-label">Container Height</label>
						<div class="col-sm-10">
							<input class="form-control" name="p_height" id="p_height" type="text" value="<?php echo set_value('p_height'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="p_volume" class="col-sm-2 control-label">Player Volume</label>
						<div class="col-sm-10">
							<input class="form-control" name="p_volume" id="p_volume" type="text" value="<?php echo set_value('p_volume'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="p_code" class="col-sm-2 control-label">Preroll code</label>
						<div class="col-sm-10">
							<textarea id="p_code" name="p_code" class="form-control" rows="6"></textarea>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="url" value="<?php echo $url; ?>" />
					<input type="hidden" name="userId" value="<?php echo $user; ?>" />
					<input type="submit" class="btn btn-primary" name="addAPI" value="Create API"/>
				</div>
			</form>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php $this->load->view('tm_footer'); ?>