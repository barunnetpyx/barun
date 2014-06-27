<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Update Payment</h4>
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
					//echo "<pre>"; print_r($payment); echo "</pre>";
					$attributes = array('class' => 'form-horizontal', 'id' => 'editPayment');
					echo form_open('payment/editPayment', $attributes); ?>
						<div class="form-group">
							<label for="datepicker" class="col-sm-2 control-label">Pay Date</label>
							<div class="col-sm-10">	
								<input class="form-control" placeholder="Enter Date" name="pay_month" id="pay_month" type="text" value="<?php echo set_value('pay_month'); ?>" />
								
							</div>	
						</div>
						<div class="form-group">
							<label for="trans_id" class="col-sm-2 control-label">Transaction ID</label>
							<div class="col-sm-10">	
								<input class="form-control" placeholder="Enter Transaction ID" name="trans_id" id="trans_id" type="text" value="<?php echo set_value('trans_id'); ?>" />
								
							</div>	
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-2">
								<input type="hidden" name="payID" value="<?php echo $payment->payID; ?>" />
								<input type="submit" name="addPayment" class="btn btn-xl btn-success btn-block" value="Register Payment"/>
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