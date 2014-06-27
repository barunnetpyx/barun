<?php $this->load->view('tm_header'); ?>
<!-- add some comments here--->
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">API List</h4>					
                </div>
				
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="allAPI">
									<thead>
										<tr>
											<th>Token</th>
											<th>API Created</th>
											<th>User Name</th>
											<th>Ad code</th>
											<th>Action</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										$count = 1;
										foreach($apis as $api) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<td><?php echo $api->api_token; ?></td>
											<td><?php echo $api->api_timestamp; ?></td>
											<td>
											<a href="<?php echo site_url('users/detail/' .$api->userid ) ?>"><?php echo $api->name; ?></a>
											</td>
											<td class="center">
												<?php if(!empty($api->embed_adcode)) {?>
												<pre><code><?php echo htmlspecialchars(urldecode($api->embed_adcode)); ?></code></pre>
												<?php } ?>
											</td>
											<td style="width:86px;">
												<a href="<?php echo site_url('api/edit/' .$api->api_id ) ?>" >
													<button type="button" class="btn btn-primary btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Edit API">
														<i class="fa fa-pencil-square-o"></i>
													</button>
												</a>
												<a href="<?php echo site_url('api/status/' .$api->api_id ) ?>" >
													<?php if($api->api_status == 0){ ?>
													<button type="button" class="btn btn-danger btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Activate API">
														<i class="fa fa-times"></i>
													</button>
													<?php }else{?>
													<button type="button" class="btn btn-success btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Deactivate API">
														<i class="fa fa-check"></i>
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