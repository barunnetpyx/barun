<?php $this->load->view('tm_header'); ?>
<?php $user = $this->session->userdata('logged_in'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>
            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                 <div class="col-lg-10">
                    <h4 class="page-header">Payments</h4>					
                </div>
				<div class="col-lg-2">
					<?php if($user['type'] == 1 ) { ?>
					<a href="<?php echo site_url('payment/add') ?>" class="btn btn-info page-header" title="Add New User">Register Payment</a>
					<?php } ?>
				</div>
				
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="allPayment">
									<thead>
										<tr>
											<th>User</th>
											<th>Amount</th>
											<th>Impressions</th>
											<th>Type</th>
											<th>Method</th>
											<th>Month</th>
											<th>Paid Date <br/> Transaction ID</th>											
											<?php if($user['type'] == 1 ) { ?>
											<th>Action</th>					
											<?php } ?>						
										</tr>
									</thead>
									<tbody>
										<?php 
										//echo "<pre>"; print_r($payment); echo "</pre>";
										$count = 1;
										foreach($payment as $pay) { 
										$class = "odd";	
										if($count %2 == 0)  $class = "even";
										?>
										<tr class="<?php echo $class; ?> gradeX">
											<td><a href="<?php echo site_url('users/detail/' .$pay->userID ) ?>"><?php echo $pay->name; ?></a></td>
											<td><?php echo $pay->amount; ?></td>
											<td><?php echo $pay->impression; ?></td>
											<td><?php if($pay->revenue_type == 1) echo "Instream"; else echo "Display"; ?></td>
											<td>
												<?php  if($pay->method == 1) echo "PayPal"; else echo "Bank"; ?>
											</td>
											<td>
												<?php echo date("M-Y", strtotime($pay->to_date)); ?>
											</td>
											<td>
												<?php 
												if(!empty($pay->payDate) && $pay->payDate != '0000-00-00 00:00:00'){
													echo date("d-M-Y", strtotime($pay->payDate)) ."<br /> ( " .$pay->transactionID ." )"; 
												}else{ echo "Pending Payment";}
												?>
											</td>
											<?php if($user['type'] == 1 ) { ?>
											<td align="center">
												<?php if($pay->pay_status == 0){ ?>
												<a href="<?php echo site_url('payment/edit/' .$pay->payID ) ?>" ><button type="button" class="btn btn-info btn-circle entooltip" data-toggle="tooltip" data-placement="left" title="Approve Payment">
														<i class="fa fa-check"></i>
													</button>
												</a>
												<?php  } else { ?>
												<i class="fa fa-money btn-success btn-circle"></i>
												<?php }?>
												
											</td>
											<?php } ?>
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