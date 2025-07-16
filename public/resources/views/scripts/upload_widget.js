jQuery(function() {
	
	var at_limit =  10485760;
	var at_usage = 0;
	
	if(at_usage < at_limit)
	{		
		// Setup html5 version
		jQuery("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5,flash,gears,silverlight,html4',
			url : './scripts/plupload/upload.php',
			chunk_size: '1mb',
			rename : true,
			dragdrop: true,
			
			filters : {
				// Maximum file size
				max_file_size : '10mb',
				// Specify what files to browse for
				mime_types: [
					{title : "Image files", extensions : "jpg,gif,png,jpeg"},
					
				]
			},
	
			// Resize images on clientside if we can
			resize : {width : 1600, height : '', quality : 100},
	
			flash_swf_url : './scripts/plupload/Moxie.swf',
			silverlight_xap_url : './scripts/plupload/Moxie.xap',
			init : {
		            StateChanged: function(up) {
					   if(up.state == 1){
						   jQuery('.plupload_buttons').show();
						   jQuery('.plupload_upload_status').hide();
					   }
					   
		            },
		 
		            QueueChanged: function(up) {
					  console.log(up.toSource())
		            }
		        }
		});
	}
	else
	{
		jQuery('#upload1').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
	}
});

function check_portals()
{
	t = document.propertyForm.elements.length;
	c = document.getElementById('checkall_portals');

	for(i=0; i<t; i++){
		if(document.propertyForm.elements[i].className.indexOf("portal_checkboxes") != -1){
			
			if(c.checked){                           
				document.propertyForm.elements[i].checked=true;
			}else{
                            
				document.propertyForm.elements[i].checked=false;
			}
		}
	}
}

function showTab(id,flag,flag2) {
	
	jQuery('#'+id+' a').find('span:last').removeClass('step-icon').addClass('error-active');
    jQuery('.selected a').find('span:last').removeClass('error-active').addClass('checked-active');
        
	jQuery('#standardTab').removeClass('selected');
	jQuery('.standardTab').hide();			
	jQuery('#desc').removeClass('selected');
	jQuery('.desc').hide();		
	jQuery('#moreInfoTab').removeClass('selected');
	jQuery('.moreInfoTab').hide();		
	jQuery('#photos').removeClass('selected');
	jQuery('.photos').hide();	
	jQuery('#attachment').removeClass('selected');
	jQuery('.attachment').hide();		
	jQuery('#published').removeClass('selected');
	jQuery('.published').hide();
	
	
	var ch_multi_let_val = jQuery('#ch_multi_let').val();
	if(ch_multi_let_val == 1){
		if(id == 'published' && flag2 == 'f'){
			jQuery('#attachment').addClass('selected');
			jQuery('.attachment').show();
		}
		else {
			if(id == 'published' && flag2 == 'p'){
				jQuery('#photos').addClass('selected');
				jQuery('.photos').show();
			}
			else{
				jQuery('#'+id).addClass('selected');
				jQuery('.'+id).show();
			}
		}
	}
	else{
		jQuery('#'+id).addClass('selected');
		jQuery('.'+id).show();
	}
	 	var ch = validateStepOne();
        if(ch == 1)
        {
        	jQuery('#standardTab a').find('span:last').addClass('error');
        }
        else{

        	jQuery('#standardTab a').find('span:last').removeClass('error').addClass('checked-active');
        }
	
	if(flag == 1) {
		jQuery('html, body').animate({scrollTop: jQuery("#"+id).offset().top }, 'slow');
	}
	
	if(id == 'published')
	{
		var area  			= jQuery("#area option:selected").text();
		var town 			= jQuery('#town').val();
		var county 			= jQuery('#county').val();
		var add1 			= jQuery('#add1').val();
		var add2 			= jQuery('#add2').val();
		var postcode 		= jQuery('#postcode').val();
		var pc = postcode.split(" ");
		
		var p_add 			= add1+', ';
		
		if(add2 !=''){p_add 			= p_add+add2+', ';}
		
		if(area !='' && area !='select'){p_add 			= p_add+area+', ';}
		
		if(county !=''){p_add 			= p_add+county+', ';}
		
		p_add 			= p_add+pc[0];
		
		jQuery('#rm_add').val(p_add);
	}
}


	function validateStepOne(){
        var landlord_name 	= jQuery('#landlord_name').val();
        var postcode 		= jQuery('#postcode').val();
        var property_no 	= jQuery('#property_no').val();
        var property_name 	= jQuery('#property_name').val();


        var ch = 0;

        if(landlord_name == ''){
        	//jQuery('#title').css("background-color", "#FFEDEF");
        	jQuery('#lblll').addClass('required');
        	ch = 1;
        }
        else{jQuery('#lblll').removeClass('required');}

        if(postcode == ''){
        	//jQuery('#fname').css("background-color", "#FFEDEF");
        	jQuery('#lblpcode').addClass('required');
        	ch = 1;
        }
        else
        {
        	jQuery('#lblpcode').removeClass('required');
        }

        if((property_name == '') && (property_no =='')){
       	 	jQuery('#lblproname').addClass('required');
         	jQuery('#lblprono').addClass('required');
        	ch = 1;
        }
        else
        {
        	jQuery('#lblprono').removeClass('required');
        	jQuery('#lblproname').removeClass('required');
        }
        	return ch;
  }



function update_fee()
{
	show_ll_fee();
	var str_pr = jQuery('#str_price').val();
	
	var f = jQuery('#for').val();
	var c = jQuery('#contract').val();
	if(str_pr != ''){

		var temp = str_pr.split('::');
		var s_s_unit = '';
		var m_s_unit = '';		
		var s_f_unit = '';
		var m_f_unit = '';
		var s_man_unit = '';
		var m_man_unit = '';
		
		
		if(temp[5] == 'perc'){
			s_s_unit = 'P'
		}
		else{
			s_s_unit = 'F'
		}

		if(temp[7] == 'perc'){
			m_s_unit = 'P'
		}
		else{
			m_s_unit = 'F'
		}
		
		if(temp[1] == 'perc'){
			s_f_unit = 'P'
		}
		else{
			s_f_unit = 'F'
		}
		
		if(temp[3] == 'perc'){
			m_f_unit = 'P'
		}
		else{
			m_f_unit = 'F'
		}
		
		if(temp[9] == 'perc'){
			s_man_unit = 'P'
		}
		else{
			s_man_unit = 'F'
		}
		
		if(temp[11] == 'perc'){
			m_man_unit = 'P'
		}
		else{
			m_man_unit = 'F'
		}
		
		if(f == 1){
		
			if(c == 'Sole Agency'){
				jQuery('#finder_fee').val(temp[4]);
				jQuery('#finder_fee_unit').val(s_s_unit);
			}else{
				jQuery('#finder_fee').val(temp[6]);
				jQuery('#finder_fee_unit').val(m_s_unit);
			}
			get_list_sell_comm();
		}else{
			if(c == 'Sole Agency'){
				jQuery('#finder_fee').val(temp[0]);
				jQuery('#finder_fee_unit').val(s_f_unit);
				
				jQuery('#management_fee').val(temp[8]);
				jQuery('#management_fee_unit').val(s_man_unit);
			}else{
				jQuery('#finder_fee').val(temp[2]);
				jQuery('#finder_fee_unit').val(m_f_unit);
				
				jQuery('#management_fee').val(temp[10]);
				jQuery('#management_fee_unit').val(m_man_unit);
			}
			get_list_sell_comm();
		}
	}
	
}


function check_category()
{
	cat = document.getElementById('category').value;
	var let_for = document.getElementById('for').value;
	
	
	cat_4 = 'Commercial';
	cat_5 = 'Land';
	cat_2 = 'Residential';
	cat_6 = 'Residential';
	cat_1 = 'Residential';

	
	w = eval('cat_'+cat);
	if(w == 'Residential'){
		document.getElementById('residential_div').style.display = 'block';
		document.getElementById('commercial_div').style.display = 'none';
		document.getElementById('landsize_div').style.display = 'block';
		document.getElementById('outbuildings_div').style.display = 'block';
		document.getElementById('furnished_div').style.display = 'block';
		document.getElementById('living_space').style.display = 'inline';
		//document.getElementById('work_space').style.display = 'none';
		document.getElementById('space_div').style.display = 'block';
		document.getElementById('parking_div').style.display = 'block';
		document.getElementById('pets_td1').style.display = 'block';
		document.getElementById('smoking_td1').style.display = 'block';
		document.getElementById('pets_td2').style.display = 'block';
		document.getElementById('smoking_td2').style.display = 'block';
		document.getElementById('furnished_tr').style.display = 'block';
		if(let_for == 2){
			document.getElementById('tr_student_let').style.display = 'block';
		}
		
		$('.ar_link').hide();
		document.getElementById('annual_rent').value='';
		
	}else if(w == 'Commercial'){
		document.getElementById('residential_div').style.display = 'none';
		document.getElementById('commercial_div').style.display = 'block';
		document.getElementById('landsize_div').style.display = 'block';
		document.getElementById('outbuildings_div').style.display = 'block';
		document.getElementById('furnished_div').style.display = 'none';
		document.getElementById('living_space').style.display = 'none';
		document.getElementById('work_space').style.display = 'inline';
		document.getElementById('space_div').style.display = 'block';
		document.getElementById('parking_div').style.display = 'block';
		document.getElementById('furnished_tr').style.display = 'none';
		document.getElementById('tr_student_let').style.display = 'none';
		
		if(let_for == 2)
		$('.ar_link').show();
		$('.arval').html('');
		
		
		document.getElementById('pets_td1').style.display = 'none';
		document.getElementById('smoking_td1').style.display = 'none';
		document.getElementById('pets_td2').style.display = 'none';
		document.getElementById('smoking_td2').style.display = 'none';

	}else{ // Land
		document.getElementById('residential_div').style.display = 'none';
		document.getElementById('commercial_div').style.display = 'none';
		document.getElementById('landsize_div').style.display = 'block';
		document.getElementById('outbuildings_div').style.display = 'block';
		document.getElementById('furnished_div').style.display = 'none';
		document.getElementById('furnished_tr').style.display = 'none';
		document.getElementById('living_space').style.display = 'inline';
		//document.getElementById('work_space').style.display = 'none';
		document.getElementById('space_div').style.display = 'none';
		document.getElementById('parking_div').style.display = 'none';
		document.getElementById('pets_td1').style.display = 'block';
		document.getElementById('smoking_td1').style.display = 'block';
		document.getElementById('pets_td2').style.display = 'block';
		document.getElementById('smoking_td2').style.display = 'block';
		document.getElementById('tr_student_let').style.display = 'none';
		$('.ar_link').hide();
		document.getElementById('annual_rent').value='';
	}
	update_prop_types();
	update_features();
}

function update_prop_types()
{
	jQuery('#property_types_div').html('Updating...');
	var cb = document.getElementById('category').value;
	var url = '/?mod=enquiries&action=get_prop_types&smode=transparent&mode=3&cats='+cb+'&checked=0';
	
	jQuery.post(url, function(data) {
		if(data != '') {
			jQuery('#property_types_div').html(data);
		}
	});
}

function get_list_sell_comm()
{
	var br  = document.getElementById('branch').value;
	var fee = document.getElementById('finder_fee').value;
	var url = 'https://pms.gnomen.co.uk/?mod=properties&action=get_list_sell_comm&smode=transparent&branch='+br+'&fee='+fee;
	
	jQuery.post(url, function(data) {
		
		if(data != '') {
			var parts = data.split('::');
			document.getElementById('listing_commission').value = parts[0];
			document.getElementById('selling_commission').value = parts[1];
			document.getElementById('listing_commission_unit').value = document.getElementById('finder_fee_unit').value;
			document.getElementById('selling_commission_unit').value = document.getElementById('finder_fee_unit').value;
		}
	});
}

function update_features()
{
    var def = '';
	jQuery('#features_div').html('Updating...');
	var cb = document.getElementById('category').value;
	var url = '/?mod=properties&action=get_features&smode=transparent&cat='+cb+'&checked='+def;
	jQuery.post(url, function(data) {
		if(data != '') {
			jQuery('#features_div').html(data);
		}
	});
}

function update_summary()
{
	var tid   = document.getElementById('summary_template').value;
	if(tid == ''){
		return;
	}
	document.getElementById('short_desc').value = 'Updating...';
	var cat   = document.getElementById('category').value;
	var beds  = document.getElementById('beds').value;
	var baths = document.getElementById('baths').value;
	var _for   = document.getElementById('for').value;
	var type  = document.getElementById('property_type').value;
	var area  = document.getElementById('area').value;
	var price = document.getElementById('price_rent').value;
	var ws = document.getElementById('workstations').value;
	
	
	var rp	= document.getElementById('receptions').value;
	var pc	= document.getElementById('postcode').value;
	
	
	
	var cb = document.getElementsByTagName('input');
   	var c = "";
    for (i=0; i<cb.length; i++){
		if (cb[i].getAttribute('type') == "checkbox" && cb[i].getAttribute('name') == 'features[]'){
	 		if (cb[i].checked==true){
	 			c += cb[i].getAttribute('value');
	  			c += ",";
	 		}
		}
    }
	
	var url   = '/?mod=properties&action=get_summary&smode=transparent&tid='+tid+'&cat='+cat+'&beds='+beds+'&baths='+baths+'&ws='+ws+'&for='+_for+'&type='+type+'&town='+area+'&price='+price+'&f='+c+'&rp='+rp+'&pc='+pc;;
	
	jQuery.post(url, function(data) {
		
		if(data != '') {
			document.getElementById('short_desc').value = data;
			word_count(document.getElementById('short_desc'),'wcnt');
		}
	});
}

function capitalise_postcode() {
	document.getElementById('postcode').value = document.getElementById('postcode').value.toUpperCase();
}

function land_size(v,a)
{
	if(v=='s')
	{
		var acre_value 	= parseFloat(prompt("Please enter acre", ""));
		document.getElementById('landsize').value = acre_value * 4046.86;
		$('#ls_sqft').html(' = '+acre_value+' acre');
		
	}
	else
	{
		document.getElementById('landsize').value = a * 4046.86;
		$('#ls_sqft').html(' = '+a+' acre');
	}
	
}

function fill_address(add1, add2, area, county, country, postcode, newarea)
{
	document.getElementById('add1').value = add1;
	document.getElementById('add2').value = add2;
	document.getElementById('county').value = county;
	document.getElementById('country').value = country;
	document.getElementById('postcode').value = postcode;

	if(newarea=='1'){
		document.getElementById('p_town1').style.display = 'none';
		document.getElementById('p_town2').style.display = 'block';
		document.getElementById('area').value = '';
		document.getElementById('town').value = area;
	}else{
		document.getElementById('p_town1').style.display = 'block';
		document.getElementById('p_town2').style.display = 'none';
		document.getElementById('area').value = area;
	}
	close_pc();
}
function close_pc()
{
	document.getElementById('divPC').style.display = 'none';
}

function show_pc()
{
	var winWidth = 0, winHeight = 0;
    if (typeof (window.innerWidth) == 'number') {
        //Non-IE
        winWidth = window.innerWidth;
        winHeight = window.innerHeight;
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode'
        winWidth = document.documentElement.clientWidth;
        winHeight = document.documentElement.clientHeight;
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible
        winWidth = document.body.clientWidth;
        winHeight = document.body.clientHeight;
    }
    
    centre_x = Math.round(winWidth / 2);
    centre_y = Math.round(winHeight/2);
    wleft     = Number(centre_x - 150);
    wtop      = Number(centre_y - 100);
	document.getElementById('divPC').style.left = wleft+'px';
	document.getElementById('divPC').style.top  = wtop+'px';
	document.getElementById('divPC').style.display = 'block';
}

function show_ll_fee(){
	var f_fee = jQuery('#finder_fee').val();
	var m_fee = jQuery('#management_fee').val();
	var landlord = jQuery('#landlord').val();
    var for_val = jQuery('#for').val();
    
	if(landlord != "" ) {alert(for_val);
		var url = '?mod=properties&action=get_ll_fee&smode=transparent&copyrights=0&lid='+landlord+'&for='+for_val;
		
		jQuery.post(url, function(data) {
			if(data != "" ){
				jQuery('#str_price').val(data);
				var temp = data.split('::');                                

				var f_unit = ''
				if(temp[1] == 'perc'){
					f_unit = 'P'
				}
				else{
					f_unit = 'F'
				}
                jQuery('#admin_fee').val(temp[12]);
				jQuery('#finder_fee').val(temp[0]);
				jQuery('#finder_fee_unit').val(f_unit);
				get_list_sell_comm();

				var m_unit = ''
				if (temp[9] == 'perc') {
					m_unit = 'P';
				} else {
					m_unit = 'F';
				}

				jQuery('#management_fee').val(temp[8]);
				jQuery('#management_fee_unit').val(m_unit);
			}
		});
	}
    else
    {
        var url = 'https://pms.gnomen.co.uk/?mod=properties&action=get_config_fee&smode=transparent&copyrights=0&get_conf=1&for='+for_val;
        
        jQuery.post(url, function(data) {
        	alert(data);
            console.log(data);
            if(data != "" ){
                    jQuery('#str_price').val(data);
                    
                    var temp = data.split('::');
                    console.log(temp);
                    var f_unit = ''
                    if(temp[1] == 'perc'){
                        f_unit = 'P'
                    } else {
                        f_unit = 'F'
                    }
                    jQuery('#admin_fee').val(temp[12]);
                    jQuery('#finder_fee').val(temp[0]);
                    jQuery('#finder_fee_unit').val(f_unit);
                    get_list_sell_comm();
					var m_unit = ''
					if (temp[9] == 'perc') {
						m_unit = 'P';
					} else {
						m_unit = 'F';
					}                    
                    jQuery('#management_fee').val(temp[8]);
                    jQuery('#management_fee_unit').val(m_unit);
                    
            }
        });
        
    }
}

/*function word_count(w,x){
	var y=w.value;
	var r = 0;
	a=y.replace(/\s/g,' ');
	a=a.split(' ');
	for (z=0; z<a.length; z++) {if (a[z].length > 0) r++;}
	jQuery('#'+x).html(r);
}*/

function word_count(w,x){
	var y=w.value.length;
	jQuery('#'+x).html(y);
	if(y > 300) {
		if(x == 'wcnt2'){
			jQuery('#sp_ch_limit2').removeClass('colour-light-grey');
			jQuery('#sp_ch_limit2').addClass('colour-red');
			jQuery('#div_war_ch_limit2').show();
		}
		else{
			jQuery('#sp_ch_limit').removeClass('colour-light-grey');
			jQuery('#sp_ch_limit').addClass('colour-red');
			jQuery('#div_war_ch_limit').show();
		}
	}
	else{
		if(x == 'wcnt2'){
			jQuery('#sp_ch_limi2t').removeClass('colour-red');
			jQuery('#sp_ch_limit2').addClass('colour-light-grey');
			jQuery('#div_war_ch_limit2').hide();
		}
		else{
			jQuery('#sp_ch_limit').removeClass('colour-red');
			jQuery('#sp_ch_limit').addClass('colour-light-grey');
			jQuery('#div_war_ch_limit').hide();
		}
	}
}

function sTab(i){
	document.getElementById('room_desc'+i).focus();
}


function room_hint(ele, i, f){
	var metric = document.getElementById('room_metric'+i).value;
	if(metric == 'MT'){ // Meters
		if(f == 'w'){
			if(ele.value == '  4.5'){
				ele.value = '';
				ele.style.color = '#000';
			}else if(ele.value == ''){
				ele.value = '  4.5';
				ele.style.color = '#000';
			}
		}else{
			if(ele.value == '  3.9'){
				ele.value = '';
				ele.style.color = '#000';
			}else if(ele.value == ''){
				ele.value = '  3.9';
				ele.style.color = '#000';
			}
		}
	}else{ // Feet
		if(f == 'w'){
			if(ele.value == "  12'5"){
				ele.value = '';
				ele.style.color = '#000';
			}else if(ele.value == ''){
				ele.value = "  12'5";
				ele.style.color = '#000';
			}
		}else{
			if(ele.value == "  10'8"){
				ele.value = '';
				ele.style.color = '#000';
			}else if(ele.value == ''){
				ele.value = "  10'8";
				ele.style.color = '#000';
			}
		}
	}
}

function update_room_hint(ele, nn)
{
	nm = ele.id;
	nn = nm.substr(nm.length - 2);
	if(isNaN(nn)){
		nn = nm.substr(nm.length - 1);
	}
	//alert(nn);
	if(ele.value == 'MT'){
		if(document.getElementById('room_width'+nn).value == "  12'5"){
			document.getElementById('room_width'+nn).value = "  4.5";
//		}else if(document.getElementById('room_width'+nn).value != ''){
//			document.getElementById('room_width'+nn).value = Math.round(document.getElementById('room_width'+nn).value * 3.2808);
		}
		if(document.getElementById('room_height'+nn).value == "  10'8"){
			document.getElementById('room_height'+nn).value = '  3.9';
//		}else if(document.getElementById('room_height'+nn).value != ''){
//			document.getElementById('room_height'+nn).value = Math.round(document.getElementById('room_height'+nn).value * 3.2808);
		}
	}else{
		if(document.getElementById('room_width'+nn).value == '  4.5'){
			document.getElementById('room_width'+nn).value = "  12'5";
	//	}else if(document.getElementById('room_width'+nn).value != ''){
	//		document.getElementById('room_width'+nn).value *= 0.3048
		}
		if(document.getElementById('room_height'+nn).value == '  3.9'){
			document.getElementById('room_height'+nn).value = "  10'8";
	//	}else if(document.getElementById('room_height'+nn).value != ''){
	//		document.getElementById('room_height'+nn).value *= 0.3048
		}
	}
}

var i = 0;
function add_room(){
	 i++;
	 nn = i;
	 var tt = 'Meters, enter:10.5 <br/>Feet/Inches, enter:10\'s';
	 
	 var n_html = '<li id="'+i+'"><div class="sort_li_div"><table cellpadding="2" cellspacing="2" border="0" width="100%"><tr><td><strong class="colour-red">Title:</strong></td><td><input type="text" name="room_title[]" id="room_title'+i+'" class="form-add-texfield-180-2" /> required</td><td align="right" valign="top" style="padding-right:3px; font-size:14px"><a onfocus="sTab('+i+')" id="room_anc_'+i+'" href="javascript:;" onclick="rem_room('+i+');">X</a></td></tr><tr><td><strong>Description:</strong></td><td><textarea name="room_desc[]" id="room_desc'+i+'" class="form-text-area-99-percent-small-2"></textarea></td><td align="right" valign="top" style="padding-right:3px; font-size:14px"></td></tr><tr><td><strong>Dimensions: (w x l)</strong></td><td><input type="text" name="room_width[]" id="room_width'+i+'" class="form-add-texfield-50-2" value="" style="color:#000"  />&nbsp;<input type="text" name="room_width_comm[]"   value="" id="room_width_comm'+i+'" style="color:#000; font-size:10px" class="form-add-texfield-50-2" value="" /> x <input type="text" name="room_height[]" id="room_height'+i+'" class="form-add-texfield-50-2" style="color:#000" value=""   />&nbsp;<input type="text" name="room_height_comm[]"  this.style.color=\'#000\';"  value="" style="color:#000; font-size:10px" id="room_height_comm'+i+'" class="form-add-texfield-50-2" value="  10.8" />&nbsp;<select id="room_metric'+i+'" name="room_metric[]" onChange="update_room_hint(this, nn)"><option value="FT">Feet</option><option value="MT" selected="selected">Meters</option></select>&nbsp;</td><td align="right" valign="top" style="padding-right:3px; font-size:14px"></td></tr><tr><td></td><td style="background-color:#fff977;">Meters, enter: 10.5 &nbsp;&nbsp;&nbsp; Feet/inches, enter:10\'5" </br>The second and forth box allows you to enter comments like "at widest",etc.</td><td></td></tr></table></div></li>';
	 jQuery('#sortable').append(n_html);
	 document.getElementById('portal_desc_msg_div').innerHTML = '<strong><span class="colour-red">NOTE:</span></strong> You have already entered rooms and measurements, there is no need to complete this field.';
}



function rem_all_rooms()
{
	jQuery('#sortable').html('');
	i = 0;
	document.getElementById('portal_desc_msg_div').innerHTML = '';
}

function set_rooms(n)
{
	c = jQuery('#sortable').html();
	if(c == ''){
		rem_all_rooms();
		for(k=0;k<n;k++){
			add_room();
		}
	}
}

function rem_room(i){
	jQuery('#'+i).remove();
	i--;
	if(i <= 0){
		document.getElementById('portal_desc_msg_div').innerHTML = '';
	}
}

var count=0;
function addField()
{
	count += 1
	if(document.getElementById("counter").value < 10){
		var ni = document.getElementById('myDiv');
		var numi = document.getElementById('theValue');
		var num = (document.getElementById("theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.innerHTML = "<input name=\"attachment"+count+"\" type=\"file\" id=\"attachment"+count+"\" class=\"AdminFormTextField200\">";
		ni.appendChild(newdiv);
		document.getElementById("counter").value = Number(document.getElementById("counter").value) + 1;
	}else{
		alert('maximum 10 attachments are allowed');
	}
}

var count2=0;
function floor_addField() {
	count2 += 1;
	if(document.getElementById("floor_counter").value < 10){
		var ni = document.getElementById('myDiv_floor');
		var numi = document.getElementById('floor_theValue');
		var num = (document.getElementById("floor_theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.innerHTML = "<input name=\"floor_attachment"+count2+"\" type=\"file\" id=\"floor_attachment"+count2+"\" class=\"AdminFormTextField200\">";
		ni.appendChild(newdiv);
		document.getElementById("floor_counter").value = Number(document.getElementById("floor_counter").value) + 1;
	}else{
		alert('maximum 10 attachments are allowed');
	}
}

jQuery(document).ready(function() {
  	var at_limit =  10485760;
	var at_usage = 0;
	var i = 0;
	if(at_usage < at_limit)
	{
	 	 jQuery('#attachments').uploadify({
	    'uploader'  : '/scripts/uploadify/uploadify.swf',
	    'script'    : '/scripts/uploadify/upload.php',
	    'cancelImg' : '/scripts/uploadify/cancel.png',
	    'folder'    : '../uploaded_files/',
	    'auto'      : true,
		'buttonText': 'Upload images',
		'multi'     : true,
		'removeCompleted': true,
		'fileDesc' : 'Image Files *.gif; *.jpg; *.jpeg; *.png',
	    'fileExt' : '*.gif; *.jpg; *.jpeg; *.png',
		'sizeLimit': '1048576',
		'queueSizeLimit': 20, 
		'altContent': '<input name="isFlashUpload" id="isFlashUpload"  type="hidden" value="no"  /><input name="attachment0" id="attachment0"  type="file"  /><input type="hidden" value="0" id="theValue" /><input type="hidden" value="0" id="counter" /><input type="button" name="add" onclick="addField()" value="more attachments..." />',
		'onError'   : function (event,ID,fileObj,errorObj) {
	      //alert(errorObj.type + ' Error: ' + errorObj.info);
	    },
		'onComplete'  : function(event, ID, fileObj, response, data) {
		  i++;
		  var filename = fileObj.name;
		  var filesize = fileObj.size;
		  var filetype = fileObj.type;
		  var tempSrt = filename+'::'+filesize+'::'+i;
		  jQuery('#filestr').val(jQuery('#filestr').val()+filename+'::'+filesize+'::'+i+',');
		  jQuery('#att_links').append('<span id="link'+i+'"><a onclick="remove123('+i+',\''+tempSrt+'\');" href="javascript:;" title="Remove">X</a>&nbsp;&nbsp;'+filename+' <br/></span>');
	    },
		'onAllComplete' : function(event,data) {
			jQuery('#atco').val(i);						
	    }  
	  });
	}
	else
	{		
		jQuery('#mattachments').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
	}
});

function remove123(id,pstr) {
	//alert('here');
	jQuery('#link'+id).remove();
	var str = jQuery('#filestr').val();
	var str = str.substring(0, str.length-1);
	var ar = str.split(',');
	var tempStr = '';
	for(i=0; i<ar.length; i++) {
		if(ar[i] != pstr) {
			tempStr	= tempStr + ar[i]+',';
		}
	}
	//alert(tempStr);
	jQuery('#filestr').val(tempStr);
}

function remove_floor_link(id,pstr) {
	jQuery('#floor_link'+id).remove();
	var str = jQuery('#floor_filestr').val();
	var str = str.substring(0, str.length-1);
	var ar = str.split(',');
	var tempStr = '';
	for(i=0; i<ar.length; i++) {
		if(ar[i] != pstr) {
			tempStr	= tempStr + ar[i]+',';
		}
	}
	jQuery('#floor_filestr').val(tempStr);
}

function remove_prop_link(id,pstr) {
	jQuery('#prop_link'+id).remove();
	var str = jQuery('#prop_filestr').val();
	var str = str.substring(0, str.length-1);
	var ar = str.split(',');
	var tempStr = '';
	for(i=0; i<ar.length; i++) {
		if(ar[i] != pstr) {
			tempStr	= tempStr + ar[i]+',';
		}
	}
	jQuery('#prop_filestr').val(tempStr);
}

// floor plans
jQuery(document).ready(function() {

  	var at_limit =  10485760;
	var at_usage = 0;
	var i = 0;
	if(at_usage < at_limit)
	{
	  jQuery('#floor_attachments').uploadify({
	    'uploader'  : './scripts/uploadify/uploadify.swf',
	    'script'    : './scripts/uploadify/upload.php',
	    'cancelImg' : './scripts/uploadify/cancel.png',
	    'folder'    : './uploaded_files/',
	    'auto'      : true,
		'buttonText': 'Upload floorplans',
		'multi'     : true,
		'removeCompleted': true,
		'fileDesc' : 'Files *.gif; *.jpg; *.jpeg; *.png; *.pdf',
	    'fileExt' : '*.gif; *.jpg; *.jpeg; *.png; *.pdf',
		'sizeLimit': '1048576',
		'queueSizeLimit': 20, 
		'altContent': '<input name="floor_isFlashUpload" id="floor_isFlashUpload"  type="hidden" value="no"  /><input name="floor_attachment0" id="floor_attachment0"  type="file"  /><input type="hidden" value="0" id="floor_theValue" /><input type="hidden" value="0" id="floor_counter" /><input type="button" name="floor_add" onclick="floor_addField()" value="more attachments..." />',
		'onError'   : function (event,ID,fileObj,errorObj) {
	      //alert(errorObj.type + ' Error: ' + errorObj.info);
	      console.log(errorObj.type + ' Error: ' + errorObj.info);
	      console.log(errorObj);
	      console.log(fileObj);
	    },
		'onComplete'  : function(event, ID, fileObj, response, data) {
			
		  i++;
		  var filename = fileObj.name;
		  var filesize = fileObj.size;
		  var filetype = fileObj.type;
		  var tempSrt = filename+'::'+filesize+'::'+i;
		  $("#floorplans_file").val(filename);
		  jQuery('#floor_filestr').val(jQuery('#floor_filestr').val()+filename+'::'+filesize+'::'+i+',');
		  jQuery('#floor_att_links').append('<span id="floor_link'+i+'"><a onclick="remove_floor_link('+i+',\''+tempSrt+'\');" href="javascript:;" title="Remove">X</a>&nbsp;&nbsp;'+filename+' <br/></span>');
	    },
		'onAllComplete' : function(event,data) {
			jQuery('#floor_atco').val(i);		
	    }  
	  });
	}
	else
	{
		jQuery('#fpupload').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
	}
});

var count3=0;
function prop_addField() {
	count3 += 1;
	if(document.getElementById("prop_counter").value < 10){
		var ni = document.getElementById('myDiv_prop');
		var numi = document.getElementById('prop_theValue');
		var num = (document.getElementById("prop_theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.innerHTML = "<input name=\"floor_attachment"+count3+"\" type=\"file\" id=\"prop_attachment"+count3+"\" class=\"AdminFormTextField200\">";
		ni.appendChild(newdiv);
		document.getElementById("prop_counter").value = Number(document.getElementById("prop_counter").value) + 1;
	}else{
		alert('maximum 10 attachments are allowed');
	}
}

jQuery(document).ready(function() {
  
 	var i = 0;
 	var at_limit =  10485760;
	var at_usage = 0;
	
	if(at_usage < at_limit)
	{
	  jQuery('#attachments_prop').uploadify({
	    'uploader'  : './scripts/uploadify/uploadify.swf',
	    'script'    : './scripts/uploadify/upload.php',
	    'cancelImg' : './scripts/uploadify/cancel.png',
	    'folder'    : '/scripts/uploadify/',
	    'auto'      : true,
		'buttonText': 'Attach files',
		'multi'     : true,
		'removeCompleted': true,
		'altContent': '<input name="prop_isFlashUpload" id="prop_isFlashUpload"  type="hidden" value="no"  /><input name="prop_attachment0" id="prop_attachment0"  type="file"  /><input type="hidden" value="0" id="prop_theValue" /><input type="hidden" value="0" id="prop_counter" /><input type="button" name="add" onclick="prop_addField()" value="more attachments..." />',
		'onError'   : function (event,ID,fileObj,errorObj) {
	      //alert(errorObj.type + ' Error: ' + errorObj.info);
	    },
		'onComplete'  : function(event, ID, fileObj, response, data) {		
			i++;
			var filename = fileObj.name.replace(/,/g ,"-");
			var filesize = fileObj.size;
			var filetype = fileObj.type;
			var tempSrt = filename+'::'+filesize+'::'+i;
			$("#attachments_file").val(filename);
			jQuery('#prop_filestr').val(jQuery('#prop_filestr').val()+filename+'::'+filesize+'::'+i+',');
			jQuery('#prop_att_links').append('<span id="prop_link'+i+'"><a onclick="remove_prop_link('+i+',\''+tempSrt+'\')" href="javascript:;" title="Remove">X</a>&nbsp;&nbsp;<a target="_blank" href="http://images2.gnomen-europe.com/b61f07a5edecc4cbf43de24e557ee32f/temp/'+filename+'">'+filename+'</a> <br/></span>');
	    },
		'onAllComplete' : function(event,data) {
	     	jQuery('#prop_atco').val(i);	
	    }  
	  });
	}
	else
	{
		jQuery('#mattachments').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
	}
});



function show_epc(vlu) 
{
	
	var at_limit =  10485760;
	var at_usage = 0;
	if(vlu == 'cepc' )
	{
			jQuery('#c_epc').show();
			jQuery('#u_epc').hide();						
	}
	else
	{
		if(at_usage < at_limit)
		{
			if(vlu == 'uepc' )
			{
				jQuery('#c_epc').hide();
				jQuery('#u_epc').show();						
			}
		}
		else
		{
			jQuery('#u_epc').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
			
			jQuery('#c_epc').hide();
			jQuery('#u_epc').show();	
		}
	}
}

function show_epcr(vlu) {

	var at_limit =  10485760;
	var at_usage = 0;
	if(vlu == 'url_epcr' )
	{
		jQuery('#u_epc_rep').hide();
		jQuery('#url_epc_rep').show();				
	}
	
	else
	{
		if(at_usage < at_limit)
		{
			if(vlu == 'uepcr' )
			{
						
				jQuery('#u_epc_rep').show();				
			}
		}
		else
		{
			
			jQuery('#u_epc_rep').html('<div align="left" class="info_message2_noWidth" id="messageDiv">Attachment limit exceeded. Please <a href="/?mod=systems&action=deleteattachments" target="_blank">remove your old attachments</a> before uploading new ones!</div>');
			jQuery('#url_epc_rep').hide();
			jQuery('#u_epc_rep').show();
		}
	}
}


function showarea(flag) {
	if(flag == 1) {
		jQuery('#p_town1').hide();
		jQuery('#p_town2').show();
		jQuery('#town').val('');
		
	}
	if(flag == 2) {
		jQuery('#p_town1').show();
		jQuery('#p_town2').hide();
		jQuery('#area').val('');
	}
}
function show_sub_region(c)
{
	if(c=='United Kingdom')
	{
		//jQuery('#sub_region_row').hide();
		//document.getElementById('sub_region').value = '';
	}
	else
	{
		//jQuery('#sub_region_row').show();
	}
}
function check_lettype(f) {
	cat_4 = 'Commercial';
	cat_5 = 'Land';
	cat_2 = 'New Development';
	cat_6 = 'Overseas';
	cat_1 = 'Residential';	

	cat = document.getElementById('category').value;

	w = eval('cat_'+cat);
	
	reset_portal_for(f)
	if(f == 2) {
		jQuery('#h3_cap_sale').html('Finders fee');
		jQuery('#table_let_type').show();
		jQuery('#tr_student_let').show();
		jQuery('#tr_renewal_fee1').show();
		jQuery('#tr_renewal_fee2').show();
		reset_status(2);
		document.getElementById('currency').value = 1;
		document.getElementById('currency').disabled = true;
		document.getElementById('currency2').disabled = true;
		document.getElementById('price_rent_title').innerHTML = 'Rent (PW)';
		document.getElementById('tenure').value = '';
		document.getElementById('tenure_div').style.display = 'none';
		document.getElementById('portal_for').value = 1;
		
		jQuery('#h3_man').show();
		jQuery('#td_man1').show();
		jQuery('#td_man2').show();
	//	jQuery('#let_options').show();
		
		if(w == 'Commercial')
		$('.ar_link').show();
		$('.arval').html('');
		
		if(w == 'Commercial' || w == 'land'){
			jQuery('#tr_student_let').hide();
		}
	}
	else {
		jQuery('#h3_cap_sale').html('Sales fee');
		jQuery('#table_let_type').hide();
		jQuery('#tr_student_let').hide();
		jQuery('#tr_pr_rent1').show();
		jQuery('#tr_pr_rent2').show();
		jQuery('#tr_stu_pr_rent1').hide();
		jQuery('#tr_stu_pr_rent2').hide();
		jQuery('#tr_renewal_fee1').hide();
		jQuery('#tr_renewal_fee2').hide();
		document.getElementById('student_let').checked = false;
		document.getElementById('water_inc').checked = false;
		document.getElementById('gas_inc').checked = false;
		document.getElementById('elec_inc').checked = false;
		document.getElementById('tv_inc').checked = false;
		document.getElementById('tv_sub_inc').checked = false;
	//	jQuery('#let_options').hide();
		
		reset_status(1);
		document.getElementById('currency').disabled = false;
		document.getElementById('price_rent_title').innerHTML = 'Price';
		//document.getElementById('tenure').value = '';
		document.getElementById('tenure_div').style.display = 'block';
		document.getElementById('portal_for').value = 2;
		
		jQuery('#h3_man').hide();
		jQuery('#td_man1').hide();
		jQuery('#td_man2').hide();
		
		$('.ar_link').hide();
		document.getElementById('annual_rent').value='';
	}
	update_fee();

	showPricebox();
	check_student_options(document.getElementById('portal_for').value);
	if(0 == 1){
		jQuery('#tr_renewal_fee1').hide();
		jQuery('#tr_renewal_fee2').hide();
		jQuery('#freeholderinfo').hide();
	}
}

function reset_status(v)
{
	//alert(v);
	s = document.getElementById('status');
	if(v == 1){
		removeAllOptions(s);
		addOption(s, 'For sale', 'For sale');
		addOption(s, 'Coming soon', 'Coming soon');
		addOption(s, 'New instruction', 'New instruction');
		addOption(s, 'Awaiting review', 'Awaiting review');
		addOption(s, 'Awaiting valuation', 'Awaiting valuation');
		addOption(s, 'Price reduction', 'Price reduction');
		addOption(s, 'Under offer', 'Under offer');
		addOption(s, 'Sold STC', 'Sold STC');
		addOption(s, 'Sold', 'Sold');
		addOption(s, 'Withdrawn', 'Withdrawn');
	}else{
		removeAllOptions(s);
		addOption(s, 'To let', 'To let');
		addOption(s, 'Coming soon', 'Coming soon');
		addOption(s, 'New instruction', 'New instruction');
		addOption(s, 'Short let', 'Short let');
		addOption(s, 'Awaiting review', 'Awaiting review');
		addOption(s, 'Awaiting valuation', 'Awaiting valuation');
		addOption(s, 'Under offer', 'Under offer');
		addOption(s, 'Let agreed', 'Let agreed');
		addOption(s, 'Let', 'Let');
		addOption(s, 'Let and Managed', 'Let and Managed');
		addOption(s, 'Managed', 'Managed');
		addOption(s, 'Withdrawn', 'Withdrawn');
	}
//	document.getElementById('status').value = 'New instruction';
	s.value = 'New instruction';
}

function reset_portal_for(v)
{
	s = document.getElementById('portal_for');
	if(v == 2){
		removeAllOptions(s);
		addOption(s, '1', 'Rental');
		addOption(s, '4', 'Student let');
	}else{
		removeAllOptions(s);
		addOption(s, '2', 'Sale (Freehold)');
		addOption(s, '3', 'Sale (Leasehold)');
	}
}

function check_multilet() {

	var let_value = jQuery('#let_type').val();
	if(let_value == 1) {
		jQuery('#ch_multi_let').val(1);		
		jQuery('#published').hide();
		jQuery('#finish3').show();
		jQuery('#finish4').show();
		jQuery('#button41').hide();
		jQuery('#button42').hide();
		
	}
	else{
		jQuery('#ch_multi_let').val(0);
		jQuery('#published').show();
		jQuery('#button41').show();
		jQuery('#button42').show();
		jQuery('#finish3').hide();
		jQuery('#finish4').hide();
	}
	
}

function ch_stu_let(ch){
	if(ch){
		jQuery('#tr_pr_rent1').hide();
		jQuery('#tr_pr_rent2').hide();
		jQuery('#tr_stu_pr_rent1').show();
		jQuery('#tr_stu_pr_rent2').show();
		jQuery('#tr_deposit').show();
		
		document.getElementById('portal_for').value = 4;
		cal_rent(1);
		
		//check stuRents enabled or not
		var dis_sr = 'none';
		if(dis_sr == 'block')
		{
			jQuery('#send_to_sr_box').show();
			//document.getElementById("send_to_sr").checked =true;
		}
		else
		{
			document.getElementById("send_to_sr").checked =false;
			jQuery('#send_to_sr_box').hide();
		}
	
	}
	else{
		jQuery('#tr_pr_rent1').show();
		jQuery('#tr_pr_rent2').show();
		jQuery('#tr_stu_pr_rent1').hide();
		jQuery('#tr_stu_pr_rent2').hide();
		
		
		//stuRents
		jQuery('#send_to_sr_box').hide();
		document.getElementById("send_to_sr").checked =false;
		jQuery('#tr_deposit').hide();
	}
	check_student_options(document.getElementById('portal_for').value);
}

function copy_desc(){
	var s_desc = jQuery('#short_desc').val();
	jQuery('#portal_summary').val(s_desc);
	
	var desc = jQuery('#description').val();
	if(desc == ''){
		var text = tinyMCE.get('description').getContent();
		if(text != ''){
			var url = '?mod=properties&action=plan_text&smode=transparent&copyrights=0';
			var params = { txt: text};
			jQuery.post(url, params,
			function(data) {
				jQuery('#portal_details').val(data);
			});
		}
	}
	else{
		jQuery('#portal_details').val(desc);
	}
	word_count(document.getElementById('portal_summary'),'wcnt2');
}

function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}

function ch_portals(){
	var field = document.getElementsByName('portals[]')
	var web = jQuery('#publish').val();
	var ppv = jQuery('#portal_publish').val();

		if(web == 0 && ppv == 1)
		{
			if(confirm('Do you want to enable the web upload as well?')){
				jQuery('#publish').val(1);
			}
		}else if(web == 1 && ppv == 0)
		{
			if(confirm('Do you want to disable the web upload as well?')){
				jQuery('#publish').val(0);
			}
		}

	for (i = 0; i < field.length; i++){
		if(ppv == 1){
			//field[i].checked = true ;
		}else{
			field[i].checked = false ;
		}
	}

}

function update_publish(s){
	var ppv = jQuery('#portal_publish').val();
	if(s == 0 && ppv == 1){
		if(confirm('Do you want to disable the portal upload as well?')){
			jQuery('#portal_publish').val(0);
			ch_portals();
		}
	}else if(s == 1 && ppv == 0){
		if(confirm('Do you want to enable the portal upload as well?')){
			jQuery('#portal_publish').val(1);
			ch_portals();
		}
	}
}



function showPricebox()
{
	f = document.getElementById('for').value;
	if(f == '1'){ // sale
		document.getElementById('let-show').style.display = 'none';
		document.getElementById('sales-show').style.display = 'inline';
		document.getElementById('let-sales-show').style.display = 'none';
			document.getElementById('let-show2').style.display = 'none';
		document.getElementById('sales-show2').style.display = 'inline';
		document.getElementById('let-sales-show2').style.display = 'none';
				document.getElementById('let-show3').style.display = 'none';
//		document.getElementById('sales-show3').style.display = 'inline';
//		document.getElementById('let-sales-show3').style.display = 'none';
		
					document.getElementById('let-show4').style.display = 'none';
		document.getElementById('sales-show4').style.display = 'inline';
		document.getElementById('let-sales-show4').style.display = 'none';
		
	//				document.getElementById('let-show5').style.display = 'none';
//		document.getElementById('sales-show5').style.display = 'inline';
//		document.getElementById('let-sales-show5').style.display = 'none';
//		
//					document.getElementById('let-show6').style.display = 'none';
//		document.getElementById('sales-show6').style.display = 'inline';
//		document.getElementById('let-sales-show6').style.display = 'none';
//		
//					document.getElementById('let-show7').style.display = 'none';
//		document.getElementById('sales-show7').style.display = 'inline';
//		document.getElementById('let-sales-show7').style.display = 'none';
		
	}else if(f == '2'){ // let
		document.getElementById('let-show').style.display = 'inline';
		document.getElementById('sales-show').style.display = 'none';
		document.getElementById('let-sales-show').style.display = 'none';
			document.getElementById('let-show2').style.display = 'inline';
		document.getElementById('sales-show2').style.display = 'none';
		document.getElementById('let-sales-show2').style.display = 'none';
				document.getElementById('let-show3').style.display = 'inline';
//		document.getElementById('sales-show3').style.display = 'none';
//		document.getElementById('let-sales-show3').style.display = 'none';
		
		document.getElementById('let-show4').style.display = 'inline';
		document.getElementById('sales-show4').style.display = 'none';
		document.getElementById('let-sales-show4').style.display = 'none';
		
	//	document.getElementById('let-show5').style.display = 'inline';
//		document.getElementById('sales-show5').style.display = 'none';
//		document.getElementById('let-sales-show5').style.display = 'none';
//		
//		document.getElementById('let-show6').style.display = 'inline';
//		document.getElementById('sales-show6').style.display = 'none';
//		document.getElementById('let-sales-show6').style.display = 'none';
//		
//		document.getElementById('let-show7').style.display = 'inline';
//		document.getElementById('sales-show7').style.display = 'none';
//		document.getElementById('let-sales-show7').style.display = 'none';
	}
	else{
		document.getElementById('let-sales-show').style.display = 'inline';
	}
}

function copyAddress() {
	var vlu_ll = jQuery('#landlord').val();
	if(vlu_ll != '') {
		var url = '?mod=valuation&action=copy_lladdress&smode=transparent&copyrights=0&usr='+vlu_ll;

		jQuery.post(url, function(data) {
			if(data != ''){
				temp = data.split('::');
				jQuery('#add1').val(temp[0]);
				jQuery('#add2').val(temp[1]);
				jQuery('#town').val(temp[2]);
				jQuery('#county').val(temp[3]);
				jQuery('#country').val(temp[4]);
				jQuery('#postcode').val(temp[5]);
			}
		});
	}
	else {
		alert('Please select landlord first, to copy the address.');
		
	}
}

function showOccupantInfo() {
	jQuery('#occupantinfo').slideToggle('slow');
}

function showFreeholderInfo() {
	jQuery('#freeholderinfo').slideToggle('slow');
}

function convertSQFT()
{
	var sqm = document.getElementById('livingspace').value;
	var sqft = sqm *'10.7639';
	$('#sqm_sqft').html(' = '+formatCurrency(sqft)+' sqft');
}


function show_annual_rent()
{
	var a_rate_value 	= parseFloat(prompt("Please enter annual rent", ""));
	
	var tenure 	= 'PW';
    
    if (a_rate_value != '' && !isNaN(a_rate_value))
    {
        if(tenure == 'PCM')
		{
			num = a_rate_value / 12;
			document.getElementById('price_rent').value = num.toFixed(2);
		}
		else
		{
			num = a_rate_value / 52;
			document.getElementById('price_rent').value = num.toFixed(2);
		}
		$(".arval").html('('+formatCurrency(a_rate_value.toFixed(2))+')');
	}
	
	document.getElementById('annual_rent').value = a_rate_value;
}

function cal_rent(ch)
{
	if(ch ==1)
	{
		var a_rate_value = document.getElementById('annual_rent').value;
		
		document.getElementById('price_rent2').value = Math.round(a_rate_value / 52);
	}
}

function hide_button(){
   $('.finish').hide();
   $('.form-top').hide();
   $('.cancel').hide();
}

function callFromDialog(lat,lon)
{

	document.getElementById('latitude').value = lat;
	document.getElementById('longitude').value = lon;
}
