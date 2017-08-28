
	function check_student_options(v)
	{
		if(v == '4'){
			jQuery('#let_options').show();
		}else{
			jQuery('#let_options').hide();
			document.getElementById('water_inc').checked = false;
			document.getElementById('gas_inc').checked = false;
			document.getElementById('elec_inc').checked = false;
			document.getElementById('tv_inc').checked = false;
			document.getElementById('tv_sub_inc').checked = false;
		}
	}
	
	function update_neg() {
		jQuery('#negotiator_div').html('');
		var branch = jQuery('#branch').val();
		var url = '?mod=systems&action=get_users&smode=transparent&copyrights=0&branch='+branch+'&name=negotiator';
		jQuery.post(url, function(data) {
			if(data != '') {
				jQuery('#negotiator_div').html(data);
				jQuery('#negotiator').val(135);
			}
		});
	}
	
	function check_req(opt)
	{
		if(opt == 'rm')
		{
			var lfckv = document.getElementById("send_to_rm").checked;
		}
		else
		{
			var lfckv = document.getElementById("send_to_zp").checked;
		}
		
		var price 			= jQuery('#price_rent').val();
		var area 			= jQuery('#area').val();
		var town 			= jQuery('#town').val();
		var portal_summary 	= jQuery('#portal_summary').val();
		var portal_details 	= jQuery('#portal_details').val();
		var add1 			= jQuery('#add1').val();
		var postcode 		= jQuery('#postcode').val();
		var for_prop 		= jQuery('#for').val();
		var admin_fee 		= jQuery('#admin_fee').val();		
		
		var rm_error_msg ='';
		
		if(lfckv)
		{			
			if(price =='' || price == 0.00)
			{
				rm_error_msg +='- Price field is required.'+'<br>';
			}
			
			if (postcode =='' || postcode.indexOf(' ') === -1)
			{
    			rm_error_msg +='- Post code is not valid (must contain one space).'+'<br>';
			}			
			
			if(area =='' && town == '')
			{
				rm_error_msg += '- Town field is required.'+'<br>';
			}
			if(add1 =='')
			{
				rm_error_msg += '- Address 1 field is required.'+'<br>';
			}
			if(portal_summary =='')
			{
				rm_error_msg += '- Portal summary field is required.'+'<br>';
			}
			if(portal_details =='')
			{
				rm_error_msg += '- Portal details field is required.'+'<br>';
			}

			if(rm_error_msg !='')
			{
				if(opt == 'rm')
				{
					jQuery('#errorMessageDiv').show('fast');
					jQuery('#errorMessageDiv').html('This property will not upload to Rightmove'+'<br><br>'+rm_error_msg);
					$('#send_to_rm').attr('checked', false);
					
				}
				else
				{
					if(for_prop == 2 & admin_fee =='')
					{
						rm_error_msg += '- Admin fee field is required.'+'<br>';
					}
					
					jQuery('#zperrorMessageDiv').show('fast');
					jQuery('#zperrorMessageDiv').html('This property will not upload to Zoopla'+'<br><br>'+rm_error_msg);
					$('#send_to_zp').attr('checked', false);
					
				}
			}
			else
			{
				jQuery('#errorMessageDiv').hide('slow');
				jQuery('#zperrorMessageDiv').hide('slow');
				//jQuery('#rm_add').show('fast');
			} 					
		}
		else
		{
			//jQuery('#rm_add').hide('fast');
		}      
		         
	}