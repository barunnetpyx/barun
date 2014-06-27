<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Add Video</h4>
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
					<?php if(isset($error) && !empty($error)) { ?>
					<div class="alert alert-danger">
						<?php echo $error; ?>
					</div>	
					<?php } ?>
					<?php 
					$attributes = array('class' => 'form-horizontal', 'id' => 'newVideo');
					echo form_open_multipart('video/add', $attributes); ?>
					<div class="modal-body">
						<?php $logged_user = $this->session->userdata('logged_in'); ?>
						<?php if($logged_user['type'] == 1 ) { ?>
						<div class="form-group">
							<label for="v_user" class="col-sm-2 control-label">User</label>
							<div class="col-sm-10">
								<select class="form-control" id="v_user" name="v_user">
									<option value="">-Select User-</option>
									<?php foreach ($user as $uploader ) {
										?>
									<option value="<?php echo $uploader->id; ?>" <?php echo set_select('v_user', $uploader->id); ?> ><?php echo $uploader->name; ?></option>	
										<?php
									}?>							
								</select>
							</div>
						</div>
						<?PHP } ?>						
						<div class="form-group">
							<label for="v_type" class="col-sm-2 control-label">Video Type</label>
							<div class="col-sm-10">
								<select class="form-control" id="v_type" name="v_type">
									<option value="">-Select type-</option>
									<option value="3">Self</option>
									<option value="5">YouTube</option>									
								</select>
							</div>
						</div>
						<div class="form-group youtube">
							<label for="v_youtube" class="col-sm-2 control-label">YouTube Video ID</label>
							<div class="col-sm-10">
								<input class="form-control" name="v_youtube" id="v_youtube" type="text" value="<?php echo set_value('v_youtube'); ?>">
							</div>
						</div>
						<div class="self">
							<div class="form-group">
								<label for="v_title" class="col-sm-2 control-label">Video Title</label>
								<div class="col-sm-10">
									<input class="form-control" name="v_title" id="v_title" type="text" value="<?php echo set_value('v_title'); ?>">
								</div>
							</div>						
							<div class="form-group">
								<label for="v_video" class="col-sm-2 control-label">Video file</label>
								<div class="col-sm-10">
									<input name="v_video" id="v_video" type="file" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="v_duration" class="col-sm-2 control-label">Video Duration</label>
								<div class="col-sm-10">
									<input class="form-control" name="v_duration" id="v_duration" type="text" value="<?php echo set_value('v_duration'); ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label for="v_desc" class="col-sm-2 control-label">Video Description</label>
								<div class="col-sm-10">
									<textarea id="v_desc" name="v_desc" class="form-control" rows="6"><?php echo set_value('v_desc'); ?></textarea>
								</div>
							</div>
						</div>
						
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" name="addVideo" value="Add Video"/>
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