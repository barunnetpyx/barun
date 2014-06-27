<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-10">
                    <h4 class="page-header">Video List</h4>					
                </div>
				<div class="col-lg-2">
					<a href="<?php echo site_url('video/add') ?>" class="btn btn-info page-header" title="Add Video">Add Video</a>
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <?php $user = $this->session->userdata('logged_in'); ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="allAPI">
									<thead>
										<tr>
											<th>Title</th>
											<th>Duration</th>
											<?php if($user['type'] == 1 ) { ?>
											<th>User Name</th>
											<?php } ?>
											<th>Description</th>
											<th>Type</th>
											<th>Action</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										//echo "<pre>"; print_r($videos); echo "</pre>";
										$count = 1;
										foreach($videos as $video) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<td><a data-toggle="modal" href="<?php echo site_url('video/preview/'.$video->id ) ?>" data-target="#myModal" ><?php echo $video->title; ?></a></td>
											<td><?php echo $video->duration; ?></td>
											<?php if($user['type'] == 1 ) { ?>
											<td class="center"><?php echo $video->name; ?></td>
											<?php } ?>
											<td><?php echo htmlspecialchars_decode($video->description); ?></td>
											<td><?php if($video->api == 3 ) echo "Self Uploaded"; else echo "YouTube"; ?></td>
											<td style="width:86px;">
												<a href="<?php echo site_url('video/edit/' .$video->id ) ?>" ><button type="button" class="btn btn-primary btn-circle"><i class="fa fa-pencil-square-o"></i></button></a>
												<a href="<?php echo site_url('video/status/' .$video->id ) ?>" >
													<?php if($video->status == 0){ ?>
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
	<div class="modal fade" id="myModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type=
					"button">×</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal" type=
					"button">Close</button> <button class="btn btn-primary" type=
					"button">Save changes</button>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('tm_footer'); ?>