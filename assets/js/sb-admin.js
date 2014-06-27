$(function() {
	$("#paypal-cont").hide();
	$("#bank-cont").hide();
    $('#side-menu').metisMenu();
	$('#allUsers').dataTable();
	$('#allAPI').dataTable();
	$('#allPayment').dataTable();
	$("input[name='payment_method']").change(function(){
		var method = this.value;
		if( method == 1){
			$("#paypal-cont").show();
			$("#bank-cont").hide();
		}else{
			$("#paypal-cont").hide();
			$("#bank-cont").show();
		}
	});
	$("#interval_month").datepicker({
		dateFormat: 'M-Y',
		changeYear: true,
		yearRange:"-100",
	}); 
	$( "#datepicker" ).datepicker({
		dateFormat: "MM-yy",		
	});
	$( "#pay_month" ).datepicker({
		dateFormat: "dd-M-yy",		
	});
	$("#name").change(function(){
		if(this.value){
			$.ajax({
				type: "GET",
				url: "getMethod",
				data: "aff_id="+this.value, 
				cache: false,
				success: function(data){
					var affObj = $.parseJSON(data);
					//$('#date_joined').val( affObj.posted_date );	
					if(affObj.payment_method){
						var pay_method = 'PayPal';
						if(affObj.payment_method == 2){
							pay_method = "Bank";
						}
						$('#pay_method').val( affObj.payment_method );	
						$('#method').val( pay_method );	
						$('#method').attr('readonly', true);
					}
				}
			})
		}
	});
	$("#v_type").change(function(){
		if(this.value){
			var type = this.value;
			if( type == 3 ) showSelf();
			else showYoutube();
		}
	});
	function showYoutube(){
		$(".youtube").show();
		$(".self").hide();
	}
	function showSelf(){
		$(".youtube").hide();
		$(".self").show();
	}
	$('#myModal').on('hidden.bs.modal', function (e) {
	  location.reload();
	})
	$(".entooltip").tooltip();
	
});
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})
