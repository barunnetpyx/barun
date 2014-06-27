<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                 <div class="col-lg-10">
                    <h4 class="page-header">Tags</h4>					
                </div>
				<div class="col-lg-2">
					<?php 
					$logged_user = $this->session->userdata('logged_in'); 
					if($logged_user['type'] == 1) { ?>
					<a href="<?php echo site_url('tag/create') ?>" class="btn btn-info page-header" title="Add New User">Register Tag</a>
					<?php } ?>
				</div>
            </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="allAPI">
									<thead>
										<tr>
											<?php 
											$logged_user = $this->session->userdata('logged_in'); 
											if($logged_user['type'] == 1) { ?>
											<th>User</th>
											<?php }?>
											<th>Desc</th>
											<th>Ad Code</th>
											<?php 
											$logged_user = $this->session->userdata('logged_in'); 
											if($logged_user['type'] == 1) { ?>
											<th>Action</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php 
										//echo "<pre>"; print_r($tags); print_r($api); echo "<pre>"; die;
										$count = 1;
										foreach($tags as $tag) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<?php 
											$logged_user = $this->session->userdata('logged_in'); 
											if($logged_user['type'] == 1) { ?>
											<td><?php echo $tag->name; ?></td>
											<?php } ?>
											<td><?php echo $tag->code_desc; ?></td>
											<td>
											<pre><code><?php echo htmlspecialchars(stripcslashes( urldecode($tag->code))); ?></code></pre>
											</td>
											<?php 
											$logged_user = $this->session->userdata('logged_in'); 
											if($logged_user['type'] == 1) { ?>
											<td style="width:86px;">
												<a href="<?php echo site_url('tag/edit/' .$tag->id ) ?>" ><button type="button" class="btn btn-primary btn-circle"><i class="fa fa-pencil-square-o"></i></button></a>
												<a href="<?php echo site_url('tag/status/' .$tag->id ) ?>" >
													<?php if($tag->status == 0){ ?>
													<button type="button" class="btn btn-danger btn-circle">
														<i class="fa fa-times"></i>
													</button>
													<?php }else{?>
													<button type="button" class="btn btn-success btn-circle">
														<i class="fa fa-check"></i>
													</button>	
													<?php } ?>
												</a>
												
											</td>
											<?php } ?>
										</tr>
										<?php $count++; } ?>
										<?php if(isset($api) && count($api) >0 ) { ?>
										<tr class="<?php echo $class; ?> gradeX">
											<td>API Tag</td>
											<td>
												<pre><code><?php echo htmlspecialchars($api); ?></code></pre>
											</td>
											
										</tr>
										
										<?php } ?>
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