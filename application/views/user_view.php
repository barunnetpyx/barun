<?php $this->load->view('tm_header'); ?>
<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">            
            <?php $this->load->view('tm_top_menu'); ?>
            <?php $this->load->view('tm_sidemenu'); ?>            
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Add New Monitisation User</h4>
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
					$attributes = array('class' => 'form-horizontal', 'id' => 'addUser');
					echo form_open('users/addUser', $attributes); ?>
						<div class="form-group">
							<div class="col-sm-10">
								<h5 class="page-header">Profile Information</h5>
							</div>	
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input class="form-control" name="name" id="name" type="text" value="<?php echo set_value('name'); ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">	
								<input class="form-control" placeholder="Enter text" name="username" id="username" type="text" value="<?php echo set_value('username'); ?>">
							</div>	
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="email" id="email" type="email" value="<?php echo set_value('email'); ?>" />
							</div>	
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">Password</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="password" id="password" type="password" />
							</div>	
						</div>
						<div class="form-group">
							<label for="url" class="col-sm-2 control-label">URL</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="url" id="url" type="text" />
							</div>	
						</div>
						
						<div class="form-group">
							<div class="col-sm-10">
								<h5 class="page-header">Contact Information</h5>
							</div>	
						</div>
						
						<div class="form-group">
							<label for="contact_name" class="col-sm-2 control-label">Name</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="contact_name" id="contact_name" type="text" value="<?php echo set_value('contact_name'); ?>"/>
							</div>	
						</div>
						<div class="form-group">
							<label for="contact_email" class="col-sm-2 control-label">Email</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="contact_email" id="contact_email" type="email" value="<?php echo set_value('contact_email'); ?>"/>
							</div>	
						</div>
						<div class="form-group">
							<label for="contact_phone" class="col-sm-2 control-label">Phone</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="contact_phone" id="contact_phone" type="text" value="<?php echo set_value('contact_phone'); ?>"/>
							</div>	
						</div>
						
						<div class="form-group">
							<div class="col-sm-10">
								<h5 class="page-header">Payment Information</h5>
							</div>	
						</div>
						
						<div class="form-group">
							<div class="col-sm-2">
								<label>Payment Method</label> 
							</div>
							<div class="col-sm-10">
								<div class="radio">
									<label>
										<input type="radio" name="payment_method" value="1" checked="checked">PayPal
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="payment_method" value="2" checked="">Bank
									</label>
								</div>
							</div>
						</div>
						
						<div class="form-group" id="paypal-cont">
							<label for="payment_paypal" class="col-sm-2 control-label">PayPal Email</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="payment_paypal" id="payment_paypal" type="text"  value="<?php echo set_value('payment_paypal'); ?>"/>
							</div>	
						</div>
						<div id="bank-cont">
						<div class="form-group">
							<label for="payment_bank_account_name" class="col-sm-2 control-label">Account Name</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="payment_bank_account_name" id="payment_bank_account_name" type="text"  value="<?php echo set_value('payment_bank_account_name'); ?>"/>
							</div>	
						</div>
						<div class="form-group">
							<label for="payment_bank_account_no" class="col-sm-2 control-label">Account No.</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="payment_bank_account_no" id="payment_bank_account_no" type="text"  value="<?php echo set_value('payment_bank_account_no'); ?>"/>
							</div>	
						</div>
						<div class="form-group">
							<label for="payment_bank_account_res_add" class="col-sm-2 control-label">Address (as in Bank)</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="payment_bank_account_res_add" id="payment_bank_account_res_add" type="text"  value="<?php echo set_value('payment_bank_account_res_add'); ?>"/>
							</div>	
						</div>
						<div class="form-group">
							<label for="payment_bank_swift_code" class="col-sm-2 control-label">Bank Swift Code</label> 
							<div class="col-sm-10">
								<input class="form-control" placeholder="Enter text" name="payment_bank_swift_code" id="payment_bank_swift_code" type="text"  value="<?php echo set_value('payment_bank_swift_code'); ?>"/>
							</div>	
						</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-10">
								<h5 class="page-header">Remarks</h5>
							</div>	
						</div>
						<div class="form-group">
							<label for="remarks" class="col-sm-2 control-label">Remarks</label> 
							<div class="col-sm-10">
								<textarea name="remarks" id="remarks" class="form-control" rows="3"><?php echo set_value('remarks'); ?></textarea>
							</div>	
						</div>	
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-2">
								<input type="submit" name="addUser" class="btn btn-lg btn-success btn-block" value="Add User"/>
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