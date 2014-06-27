<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Register Tag</h4>
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
					echo form_open('tag/create', $attributes); ?>
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Affiliate Name</label>
							<div class="col-sm-10">
								<select class="form-control" id="name" name="name">
									<option value="">-Select user-</option>
									<?php foreach($users as $user){ ?>
									<option value="<?php echo $user->id; ?>" <?php echo set_select('name', $user->id); ?> ><?php echo $user->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="code_desc" class="col-sm-2 control-label">Script Description</label>
							<div class="col-sm-10">
								<textarea id="code_desc" name="code_desc" class="form-control" rows="6"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="code" class="col-sm-2 control-label">Script code</label>
							<div class="col-sm-10">
								<textarea id="code" name="code" class="form-control" rows="6"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-3">
								<input type="submit" name="addScript" class="btn btn-lg btn-success btn-block" value="Register Script"/>
							</div>
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