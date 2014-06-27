<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-10">
                    <h4 class="page-header">Monitisation Users</h4>
					
                </div>
				<div class="col-lg-2">
					<a href="<?php echo site_url('users') ?>" class="btn btn-info page-header" title="Add New User">Add User</a>
				</div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="allUsers">
									<thead>
										<tr>
											<th>User ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Payment</th>
											<th>Phone</th>
											<th>Remark</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$count = 1;
										foreach($users as $user) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<td><?php echo $user->id; ?></td>
											<td><a href="<?php echo site_url('users/detail/' .$user->id ) ?>"><?php echo $user->name; ?></a></td>
											<td><?php echo $user->contact_email; ?></td>
											<td>
											<?php 
												if($user->payment_method == 1) echo "PayPal"; else echo "Bank";  
											?>
											</td>
											<td class="center"><?php echo $user->contact_phone; ?></td>
											<td><?php echo word_limiter($user->remarks, 12); ?></td>
											<td style="width:112px;">
												<a href="<?php echo site_url('users/edit/' .$user->id ) ?>" >
													<button type="button" class="btn btn-primary btn-circle entooltip"  entooltip" data-toggle="tooltip" data-placement="left" title="Edit User">
														<i class="fa fa-pencil-square-o"></i>
													</button>
												</a>
												<a href="<?php echo site_url('users/status/' .$user->id ) ?>" >
													<?php if($user->status == 0){ ?>
													<button type="button" class="btn btn-danger btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Activate User">
														<i class="fa fa-times"></i>
													</button>
													<?php }else{?>
													<button type="button" class="btn btn-success btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Deactivate User">
														<i class="fa fa-check"></i>
													</button>	
													<?php } ?>
												</a>
												<a href="<?php echo site_url('users/uploadStatus/' .$user->id ) ?>" >
													<?php if($user->can_upload == 0){ ?>
													<button type="button" class="btn btn-danger btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Revoke Special MA">
														<i class="fa fa-film"></i>
													</button>
													<?php }else{?>
													<button type="button" class="btn btn-success btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Make Special MA">
														<i class="fa fa-film"></i>
													</button>	
													<?php } ?>
												</a>
											</td>
										</tr>
										<?php $count++; } ?>
										
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
							
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-12 -->
			</div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php $this->load->view('tm_footer'); ?>