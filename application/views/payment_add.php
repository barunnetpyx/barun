<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
		<?php $this->load->view('tm_top_menu'); ?>
		<?php $this->load->view('tm_sidemenu'); ?>            
	</nav>

	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="page-header">Add Payment</h4>
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
					//echo "<pre>"; print_r($users); echo "</pre>";
				$attributes = array('class' => 'form-horizontal', 'id' => 'addPayment');
				echo form_open('payment/addPayment', $attributes); ?>
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
					<label for="interval_month" class="col-sm-2 control-label">Month</label>
					<div class="col-sm-10">	
						<input class="form-control" placeholder="Enter Date" name="interval_month" id="datepicker" type="text" value="<?php echo set_value('interval_month'); ?>" />
						
					</div>	
				</div>
				<div class="form-group">
					<label for="revenue_type" class="col-sm-2 control-label">Revenue Type</label>
					<div class="col-sm-10">
						<select class="form-control" id="revenue_type" name="revenue_type">
							<option value="0">-Select Revenue-</option>
							<option value="1">Instream</option>
							<option value="2">Display</option>
							
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="impression" class="col-sm-2 control-label">Impressions</label>
					<div class="col-sm-10">	
						<input class="form-control" placeholder="Enter Impressions" name="impression" id="impression" type="text" value="<?php echo set_value('impression'); ?>" />								
					</div>	
				</div>
				<div class="form-group">
					<label for="method" class="col-sm-2 control-label">Payment Method</label>
					<div class="col-sm-10">	
						<input class="form-control" placeholder="Enter Payment method" name="method" id="method" type="text" value="<?php echo set_value('method'); ?>" />								
					</div>	
				</div>
				<div class="form-group">
					<label for="amount" class="col-sm-2 control-label">Amount</label> 
					<div class="col-sm-10">
						<input class="form-control" placeholder="Enter amount" name="amount" id="amount" type="text" value="<?php echo set_value('amount'); ?>" />
					</div>	
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-3">
						<input type="submit" name="addPayment" class="btn btn-lg btn-success btn-block" value="Register Revenue"/>
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