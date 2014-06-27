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
					//echo "<pre>"; print_r($tag); echo "</pre>"; 
					$attributes = array('class' => 'form-horizontal', 'id' => 'createTag');
					echo form_open('tag/edit', $attributes); ?>
						<div class="form-group">
							<label for="code_desc" class="col-sm-2 control-label">Script Description</label>
							<div class="col-sm-10">
								<textarea id="code_desc" name="code_desc" class="form-control" rows="6"><?php if(isset($tag->code_desc) && !empty($tag->code_desc)) echo $tag->code_desc; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="code" class="col-sm-2 control-label">Script code</label>
							<div class="col-sm-10">
								<textarea id="code" name="code" class="form-control" rows="6"><?php if(isset($tag->code) && !empty($tag->code)) echo htmlspecialchars(stripcslashes( urldecode($tag->code))); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-3">
								<input type="hidden" name="id" value="<?php echo $tag->id; ?>"/> 
								<input type="submit" name="addScript" class="btn btn-lg btn-success btn-block" value="Edit Script"/>
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