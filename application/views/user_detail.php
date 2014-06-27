<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Monitisation Users Detials</h4>
					
                </div>
				
                <!-- /.col-lg-12 -->
            </div>
			<?php //echo "<pre>"; print_r($user); echo "</pre>"; ?>
			<div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo $user->name; ?>'s Details
							<a href="<?php echo site_url('users/edit/' .$user->id ) ?>">
								<button type="button" class="btn btn-info btn-circle btn-lg pull-right"><i class="fa fa-edit"></i></button>
							</a>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<ul class="timeline">
								<li>
									<div class="timeline-badge"><i class="fa fa-user"></i>
									</div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">User Details</h4>
										</div>
										<div class="timeline-body">
											<ul class="list-group">
											  <li class="list-group-item"><b>Name :</b> <?php echo $user->name; ?></li>
											  <li class="list-group-item"><b>Username :</b> <?php echo $user->username; ?></li>
											  <li class="list-group-item"><b>Email : </b> <?php echo $user->email; ?></li>
											  <li class="list-group-item"><b>URL : </b> <?php echo $user->url; ?></li>
											 
											</ul>
										</div>
									</div>
								</li>
								<li class="timeline-inverted">
									<div class="timeline-badge warning"><i class="fa fa-envelope"></i>
									</div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">Contact Details</h4>
										</div>
										<div class="timeline-body">
											<ul class="list-group">
											  <li class="list-group-item"><b>Name :</b> <?php echo $user->contact_name; ?></li>
											  <li class="list-group-item"><b>Phone :</b> <?php echo $user->contact_phone; ?></li>
											  <li class="list-group-item"><b>Email : </b> <?php echo $user->contact_email; ?></li>
											 
											</ul>
										</div>
									</div>
								</li>
								<li>
									<div class="timeline-badge danger"><i class="fa fa-money"></i>
									</div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">Payment Details</h4>
										</div>
										<div class="timeline-body">
											<ul class="list-group">
											  <li class="list-group-item"><b>Payment method :</b> 
												<?php
													if($user->payment_method == 1) echo "PayPal"; else echo "Bank";
												?>
											  </li>
											  <?php if($user->payment_method == 1) {?>
											  <li class="list-group-item"><b>PayPal :</b> <?php echo $user->payment_paypal; ?></li>
											  
											  <?php } else { ?>
											  <li class="list-group-item"><b>Account Holder's Name : </b> <?php echo $user->payment_bank_account_name; ?></li>
											  <li class="list-group-item"><b>Account number : </b> <?php echo $user->payment_bank_account_no; ?></li>
											  <li class="list-group-item"><b>Address : </b> <?php echo $user->payment_bank_account_res_add; ?></li>
											  <li class="list-group-item"><b>Swift Code : </b> <?php echo $user->payment_bank_swift_code; ?></li>
											  <?php } ?>
											 
											</ul>
										</div>
									</div>
								</li>
								<li class="timeline-inverted">
									<div class="timeline-badge warning"><i class="fa fa-code"></i>
									</div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">API Details</h4>
										</div>
										<div class="timeline-body">
											<?php
											$admin = $this->session->userdata('logged_in'); 											
											if(!empty($api)) { 
												?>
												<pre><code><?php echo htmlspecialchars($api); ?></code></pre>
												<?php
											}elseif($admin['type'] == 1){											
											?>		
											<!-- Button trigger modal -->
											<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createAPI">Create API</button>
											<!-- Modal -->
											<div class="modal fade" id="createAPI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title" id="myModalLabel">Create API</h4>
														</div>
														<?php 
														$attributes = array('class' => 'form-horizontal', 'id' => 'createAPI');
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
																	<textarea id="p_code" name="p_code" class="form-control" rows="6"><?php echo set_value('p_code'); ?></textarea>
																</div>
															</div>
															
														</div>
														<div class="modal-footer">
															<input type="hidden" name="url" value="<?php echo $user->url; ?>" />
															<input type="hidden" name="userId" value="<?php echo $user->id; ?>" />
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<input type="submit" class="btn btn-primary" name="addAPI" value="Create API"/>
														</div>
														</form>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
											<?php }else{
												?>
												<div class="alert alert-warning">No API has been created yet</div>
												<?php
											} ?>
										</div>
									</div>
								</li>
								<?php if($admin['type'] == 1){ ?>
								<li>
									<div class="timeline-badge danger"><i class="fa fa-book"></i>
									</div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">Remarks</h4>
										</div>
										<div class="timeline-body">
											<?php echo $user->remarks; ?>
										</div>
									</div>
								</li>	
								<?php } ?>
							</ul>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
			</div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php $this->load->view('tm_footer'); ?>