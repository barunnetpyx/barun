<?php $this->load->view('tm_header'); ?>
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
											<th>Video ID</th>
											<th>Title</th>
											<th>Duration</th>
											<th>Category</th>
											<th>Thumb</th>
											<th>Action</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										//echo "<pre>";print_r($videos); print_r($playlist); echo "</pre>";
										$data = array();
										foreach ($playlist as $playlist ) {
											$data[] = $playlist->video_id;
										}
										//echo "<pre>";print_r($data); echo "</pre>";
										
										$count = 1;
										foreach($videos as $video) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<td><?php echo $video->video_id; ?></td>
											<td><a href="<?php echo $video->video_full_url; ?>" target="_blank"><?php echo $video->title; ?></a></td>
											<td><?php echo $video->video_duration; ?></td>
											<td><?php echo $video->category_name; ?></td>
											<td class="center">
												<img src="http://cdn.tunechannel.tv/video_upload/video_imgs/resized/110x80/<?php echo $video->video_image_new; ?>" title="<?php echo $video->title; ?>" alt="<?php echo $video->title; ?>"/> 
											</td>
											<td style="width:86px;" class="center">
												<?php if(!in_array($video->video_id, $data)) { ?>
												<a href="<?php echo site_url('api/videoAssign/' .$video->video_id ) ?>" >
													<button type="button" class="btn btn-info btn-circle"><i class="fa fa-film"></i></button>
												</a>
												<?php } else { ?>
												<a href="<?php echo site_url('api/videoUnAssign/' .$video->video_id ) ?>" >
													<button type="button" class="btn btn-success btn-circle"><i class="fa fa-film"></i></button>
												</a>	
												<?php }?>												
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