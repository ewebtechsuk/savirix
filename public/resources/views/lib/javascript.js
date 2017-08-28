function getHint(tbl, fld, term, obj, mask){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById('hintLayer');
				if(x.responseText != ""){
					el.style.display = "block";
					el.style.left = getRealLeft(obj);
					el.style.top = getRealTop(obj)+20;
					el.innerHTML = x.responseText;
				}else{
					el.style.display = "none";
					el.innerHTML = "";
				}
			}
		}
		x.open("GET", "?mod=hints&module="+tbl+"&smode=transparent&field="+fld+"&term="+term+"&fill="+obj+"&mask="+mask, true);
		x.send(null);
	}
}

function getSSHint(e,term)
{
	if(term.length < 3){
		hideLayer('sshintLayer');
		//hideLayer('smart-search-options');
		return false;
	}
	//enter / return key press
	if(e.which == 13)
	{
		document.getElementById('btnGo').onclick();
	}
	
	var disp = document.getElementById('smart-search-options').style.display;
	if(disp == 'block' || disp == ''){
		hideLayer('sshintLayer');				
		//hideLayer('smart-search-options');
		return false;
	}
	
	url = document.location.href;
	if(url.indexOf('smart_search') > 0){
		return false;
	}
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById('sshintLayer');
				if(x.responseText != ""){
					el.style.display = "block";
					el.style.left = getRealLeft('q')-3+'px';
					el.style.top = getRealTop('q')+20+'px';
					//el.innerHTML = x.responseText;
					document.getElementById('tb_ss_list').innerHTML = x.responseText;
				}else{
					el.style.display = "none";
					el.innerHTML = "";
				}
			}
		}
		x.open("GET", "/?mod=smart_search&action=hint&smode=transparent&copyrights=0&term="+term, true);
		x.send(null);
	}
}


function getImages(pid,lyr,modId,n,tab){

	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){

					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
			
		if(modId==2)
		{

			x.open("GET", "?mod=landlords&action=preview&smode=transparent&copyrights=0&id="+pid+'&n='+n+'&tab='+tab, true);
			x.send(null);
		}else if(modId==3){
			
			x.open("GET", "?mod=tenants&action=preview&smode=transparent&copyrights=0&id="+pid+'&n='+n+'&tab='+tab, true);
			x.send(null);
		}else if(modId==4){
			
			x.open("GET", "?mod=enquiries&action=preview&smode=transparent&copyrights=0&id="+pid+'&n='+n+'&tab='+tab, true);
			x.send(null);
		}else if(modId==5){
			
			x.open("GET", "?mod=cdirectory&action=preview&smode=transparent&copyrights=0&id="+pid+'&n='+n+'&tab='+tab, true);
			x.send(null);
		}else{
			x.open("GET", "?mod=properties&action=preview&smode=transparent&copyrights=0&id="+pid+"&modid=1&n="+n+'&tab='+tab, true);
			x.send(null);
		}
	}
}


function getApplicant(tid,lyr){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){

					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=enquiries&action=preview&smode=fullscreen&copyrights=0&id="+tid, true);
		x.send(null);
	}
}


function getRealLeft(imgElem) {
	xPos = document.getElementById(imgElem).offsetLeft;
	tempEl = document.getElementById(imgElem).offsetParent;
	while (tempEl != null) {
		xPos += tempEl.offsetLeft;
		tempEl = tempEl.offsetParent;
	}
	return xPos;
}

function confirmDel(){
	d = confirm("Are you sure to delete");
	return d;
}

function getRealTop(imgElem) {//
	yPos = document.getElementById(imgElem).offsetTop;
	tempEl = document.getElementById(imgElem).offsetParent;
	while (tempEl != null) {
		yPos += tempEl.offsetTop;
		tempEl = tempEl.offsetParent;
	}
	return yPos;
}

function fillsrcfld(v, obj){
	document.getElementById(obj).value = v;
	//	el = document.getElementById('hintLayer');
	//	el.style.display = "none";
	//	document.searchForm.submit();
}

function hideLayer(obj){
	o = document.getElementById(obj);
	o.style.display = 'none';
}

function toggleDiv(id) {

	var obj=document.getElementById(id)

	if (obj.style.display=="block")
	{
		obj.style.display="none"
	}else{
		obj.style.display="block"
	}
}

function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure ){
	var cookie_string = name + "=" + escape ( value );

	if ( exp_y ) {
		var expires = new Date ( exp_y, exp_m, exp_d );
		cookie_string += "; expires=" + expires.toGMTString();
	}

	if ( path )
	cookie_string += "; path=" + escape ( path );

	if ( domain )
	cookie_string += "; domain=" + escape ( domain );

	if ( secure )
	cookie_string += "; secure";

	document.cookie = cookie_string;
}

function get_cookie ( cookie_name )
{
	var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );

	if ( results )
	return ( unescape ( results[1] ) );
	else
	return null;
}

function delete_cookie ( cookie_name )
{
	var cookie_date = new Date ( );
	cookie_date.setTime ( cookie_date.getTime() - 1 );
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function pmsshowHide(ob, icon, templ){
	o = document.getElementById(ob);
	icn = document.getElementById(icon);
	if(o.style.display == "none"){
		//	o.style.display = "block";
		new Effect.SlideDown(ob);
		icn.src = "templates/"+templ+"/folder_images/minimise.gif";
	}else{
		//	o.style.display = "none";
		new Effect.SlideUp(ob);
		icn.src = "templates/"+templ+"/folder_images/maximise.gif";
	}
	//	if(usecookie == 1){
	set_cookie(ob,o.style.display);
	//	}
}

function checkState(ww, ii, temp)
{
	winarray=ww;
	imgarray=ii;
	//alert(winarray);
	var x = winarray.length;
	for (i = 0 ; i < x ; i++)
	{
		var obj=document.getElementById(winarray[i]);
		var status = get_cookie(winarray[i]);
		var icn = document.getElementById(imgarray[i]);
		if (status == "block") {
			if(obj){
				obj.style.display="block";
				icn.src = "templates/"+temp+"/folder_images/minimise.gif";
			}
		} else if(status == "none") {
			if(obj){
				obj.style.display="none";
				icn.src = "templates/"+temp+"/folder_images/maximise.gif";
			}
		}
	}
}

function formtopopup (form, features, windowName) {
	if (!windowName)
	windowName = 'formTarget' + (new Date().getTime());
	form.target = windowName;
	open ('', windowName, features);
}

function formtopopup2 (form, features, windowName) {
	if (!windowName)
	windowName = 'formTarget';
	form.target = windowName;
	window.open(form.action, windowName, features);
}

function _get( name ){
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
	return "";
	else
	return results[1];
}
function currencyOnly(evt, value) {
	evt = (evt) ? evt : event;
	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
	((evt.which) ? evt.which : 0));
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		dot = value.indexOf('.',0);
		if(charCode == 46 && dot < 0){
			return true;
		}else{
			return false;
		}
	}
	return true;
}
function roundNumber(value) {
	var rnum = value;
	var rlength = 2; // The number of decimal places to round to
	if (rnum > 8191 && rnum < 10485) {
		rnum = rnum-5000;
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
		newnumber = newnumber+5000;
	} else {
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
	}
	return newnumber;
}
function formatCurrency(num, m) {
	if(m == null){
		m = 1;
	}
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	if(m == 1){
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
//	if(m == 1){
		num = num.substring(0,num.length-(4*i+3))+','+
//	}
	num.substring(num.length-(4*i+3));
	}
	return (((sign)?'':'-') + num + '.' + cents);
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	selectbox.options.add(optn);
}
function moveOption(frombox, tobox, errmsg)
{
	if(errmsg == null){
		errmsg = 'Please select an option';
	}
	if(frombox.value == ''){
		alert(errmsg);
		return false;
	}
	// add selected option to the other box
	addOption(tobox, frombox.value, frombox.options[frombox.selectedIndex].text);
	// removes the selected from first box
	removeSelectedOption(frombox);
}
function removeSelectedOption(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--){
		if(selectbox.options[i].selected){
			selectbox.remove(i);
		}
	}
}

function showPreview(n, pid, xoffset, yoffset, which, tab)
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
    wleft     = Number(centre_x - 425);
    wtop      = Number(centre_y - 200);
    
    
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	if(which == null){
		which = 1;
	}
	if(tab == null){
		tab = 0;
	}
	l 	= document.getElementById('ImagesDiv');

	l.innerHTML = '<p align="center"><img src="/templates/standard/images/loading.gif"><br>Loading...</p>';
	getImages(pid, 'ImagesDiv',which,n, tab);
//	lft = getRealLeft('pimg_'+n);
//	tp  = getRealTop('pimg_'+n);

	l.style.display = "block";
//	if(lft > (winWidth-600)){
//		left_ = lft-Number(250)-Number(xoffset);
//	}else{
//		left_ = lft-Number(xoffset);
//	}
//	if(left_ < 20){
//		left_ = 20;
//	}
//	l.style.left = left_+'px';
	l.style.left = wleft+'px';
	l.style.top  = wtop+'px';
//	if(tp > (winHeight-200)){
//		l.style.top  = (tp - yoffset - 250)+'px';
//	}else{
//		l.style.top  = (tp - yoffset)+'px';
//	}
}

function show_acc_preview(elm, mod, itm, xoffset, yoffset)
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
	wleft     = Number(centre_x - 425);
    wtop      = Number(centre_y - 200 + window.pageYOffset);
	
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	l 	= document.getElementById('acc_quick_preivew');
	//l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'acc_quick_preivew\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/standard/images/loading.gif"><br>Loading...</p>';
	get_account_info(mod, itm);
	//lft = getRealLeft(elm);
	//tp  = getRealTop(elm);
	
	l.style.display = "block";
	l.style.left = wleft+'px';
	l.style.top  = wtop+'px';
}


function get_account_info(mod, itm){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		//html = '<span align="right"><b><a href="#" onclick="document.getElementById(\'acc_quick_preivew\').style.display=\'none\'; return false;">Close</a></b></span>';
		html = '';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById('acc_quick_preivew');
				if(x.responseText != ""){
					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=accounts&action=qp&smode=transparent&copyrights=0&modid="+mod+"&itemid="+itm, true);
		x.send(null);
	}
}

var myfolders_load = 0;

function showMyFolders(xoffset, yoffset)
{
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	l 	= document.getElementById('myfoldersframe');
	//	l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'MyFoldersDiv\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';

	if(myfolders_load == 0){
		l.src = '/?mod=myfolders&smode=fullscreen&copyrights=0';
		myfolders_load = 1;
	}

	lft = getRealLeft('myfolder');
	tp  = getRealTop('myfolder');

	l.style.display = "block";
	l.style.left = lft-xoffset;
	l.style.top  = tp - yoffset;
}

var omodid  = '';
var oitemid = '';
var oitemname = '';

function lookup_change(mod, item)
{
	modid    = document.getElementById(mod).value;
	itemid   = document.getElementById(item).value;
	itemname = document.getElementById(item+'_name').value;
	if(modid == omodid){
		document.getElementById(item).value = oitemid;
		document.getElementById(item+'_name').value = oitemname;
	}else{
		omodid  = modid;
		oitemid = itemid;
		oitemname = itemname;
		document.getElementById(item).value = '';
		document.getElementById(item+'_name').value = '';
	//	alert(omodid+' '+oitemid);
	}
}

/*function show_mod_selector(fldname, mod, itm, nomod, noprop, ltd, url,pos_flag)
{

	l 	= document.getElementById('modselectorframe');
	if(url == null){
		l.src = '/?mod=lookup&smode=fullscreen&f='+itm+'&m='+mod+'&nomod='+nomod+'&noprop='+noprop+'&ltd='+ltd+'&mode=1&modid='+(document.getElementById(mod) ? document.getElementById(mod).value : '');
	}else{
		l.src = url;
	}
	lft = getRealLeft(fldname);
	tp  = getRealTop(fldname);
	if(lft < 150){
		lft += 150;
	}
	
	l.style.display = "block";
	if(pos_flag == 1){
		l.style.left = (lft+0)+'px';
	}
	else{
		l.style.left = (lft-100)+'px';
	}
	//l.style.top  = (tp-60)+'px';
	
	var f = document.getElementById('filter');
	if(f == null) {
		l.style.top  = (tp-60)+'px';
	}
	else{
		tp2  = getRealTop('filter');
		l.style.top  = (tp2+20)+'px';
		l.style.left = (lft-200)+'px';
	}
}*/

function show_mod_selector(fldname, mod, itm, nomod, noprop, ltd, url, pos_flag, callback)
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
    
	wleft     = Number(centre_x - 375);
    wtop      = Number(centre_y - 220);
	
	
	l 	= document.getElementById('modselectorframe');
	if(url == null || url == ''){
		l.src = '/?mod=lookup&smode=fullscreen&f='+itm+'&m='+mod+'&nomod='+nomod+'&noprop='+noprop+'&ltd='+ltd+'&callback='+callback+'&mode=1&modid='+(document.getElementById(mod) ? document.getElementById(mod).value : '');
	}else{
		l.src = url;
	}
	
	l.style.display = "block";
	l.style.top  = wtop+'px';
	l.style.left = wleft+'px';

}


function filllookup(fl, vl)
{
	
	if(document.getElementById(fl)){
		document.getElementById(fl).value = vl;
		document.getElementById('modselectorframe').style.display = 'none';
	}
	if(window.show_ll_fee){
		show_ll_fee();
	}
	else{
		//alert('not exist');
	}
	
	if(window.show_deposite_fee){
		show_deposite_fee(1);
	}
	else{
		//alert('not exist');
	}
	
	if(window.show_wo_msg){
		show_wo_msg();
	}
	else{
		//alert('not exist');
	}
		
	if(window.fill_prop_details){
		fill_prop_details();
	}
	else{
		//alert('not exist');
	}
	
}

function close_mod_selector()
{
	document.getElementById('modselectorframe').style.display = 'none';
}
function close_commlog()
{
	document.getElementById('commlogframe').style.display = 'none';
}
var todo_load = 0;
function showTodo(xoffset, yoffset)
{
	if(xoffset == null){
		xoffset = 400;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	l 	= document.getElementById('todoframe');

	if(todo_load == 0){
		l.src = '/?mod=todo&smode=fullscreen&copyrights=0';
		todo_load = 1;
	}

	lft = getRealLeft('todoicon');
	tp  = getRealTop('todoicon');

	l.style.display = "block";
	l.style.left = lft-xoffset;
	l.style.top  = tp - yoffset;
}
function add_search_provider()
{
	if(window.external && ("AddSearchProvider" in window.external)){
		var browserName = navigator.appName;
		var browserVer  = parseInt(navigator.appVersion);
		//	alert(browserVer);
		if(browserName == 'Microsoft Internet Explorer' && browserVer >= 4){
			window.external.AddSearchProvider("http://pms3.gnomen.co.uk/sp.xml");
		}else if(browserName == 'Netscape' && browserVer >= 3){
			//	document.location.href = 'sp_ff.xml';
			window.external.AddSearchProvider("http://pms3.gnomen.co.uk/sp_ff.xml");
		}else{
			alert('You need Internet Explorer 7+ or Firefox 3+ to use this feature');
		}
	}else{
		alert('This feature is not supported by your browser');
	}
}

function mailbox(n, pid, xoffset, yoffset, which)
{

	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	if(which == null){
		which = 1;
	}
	l 	= document.getElementById('MailDiv');

	l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'MailDiv\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';
	if(which == 1){
		getPreview(pid, 'MailDiv');
	}else if(which == 4){
		getApplicants(pid, 'MailDiv');
	}
	lft = getRealLeft('pimg');
	tp  = getRealTop('pimg');

	l.style.display = "block";
	//	l.style.left = lft-xoffset;
	//	l.style.top  = tp - yoffset;

	l.style.top  = 10;

}


function getPreview(pid,lyr){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '<span align="right"><b><a href="#" onclick="document.getElementById(\'MailDiv\').style.display=\'none\'; return false;">Close</a></b></span>';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){
					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=messages&action=preview&smode=fullscreen&copyrights=0&id="+pid, true);
		x.send(null);
	}
}

function getApplicants(tid,lyr){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '<span align="right"><b><a href="#" onclick="document.getElementById(\'MailDiv\').style.display=\'none\'; return false;">Close</a></b></span>';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){
					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=messages&action=preview&smode=fullscreen&copyrights=0&id="+tid, true);
		x.send(null);
	}
}

function DisplayFormValues()
{

	var str = '';
	var str1 = '';
	var elem = document.getElementById('messageform').elements;

	for(var i = 1; i < elem.length-1; i++)
	{

		if(elem[i].type=='checkbox')
		{
			var elemntname=elem[i].name;
			if(elem[i].checked==true)
			{

				str +=elem[i].value+",";

				str1 +="<input type='hidden' value="+elem[i].name+" name='tofield[]'>";
			}
		}

	}
	document.getElementById('lblValues').innerHTML = str1;
	document.getElementById('to').value = str.replace(/,$/,'');


}

function emailfilllookup(f,elem)
{

	var str = '';
	//elem=document.getElementById('emaillookup').elements;
	
	for(var i = 1; i < elem.length-1; i++)
	{

		if(elem[i].type=='checkbox')
		{
			var elemntname=elem[i].name;

			if(elem[i].checked==true)
			{

				str +=elem[i].value+",";

			}
		}

	}

	document.getElementById(f).value = str.replace(/,$/,'');

	document.getElementById('modselectorframe').style.display = 'none';



}
function returntoBox()
{

	document.getElementById('MailDiv').style.display='none'; return false;
	document.getElementById('to').readonly = true;
}

function checkall()
{
	if(document.getElementById('allcheck').checked==true)
	{
		var elem = document.getElementById('messageform').elements;
		for(var i = 1; i < elem.length-1; i++)
		{

			elem[i].checked=true;
		}



	}
	else
	{
		var elem = document.getElementById('messageform').elements;
		for(var i = 1; i < elem.length-1; i++)
		{

			elem[i].checked=false;
		}

	}
}

function checkallemail()
{

	if(document.getElementById('checkall').checked==true)
	{
		var elem = document.getElementById('emaillookup').elements;
		for(var i = 1; i < elem.length-1; i++)
		{

			elem[i].checked=true;
		}



	}
	else
	{
		var elem = document.getElementById('emaillookup').elements;
		for(var i = 1; i < elem.length-1; i++)
		{

			elem[i].checked=false;
		}

	}
}


function showPreviewProperty(n, pid, xoffset, yoffset, which)
{

	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	if(which == null){
		which = 1;
	}
	l 	= document.getElementById('ProperyDiv');


	l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'ProperyDiv\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';

	if(which == 1){

		getPropertyImages(pid, 'PropertyDiv');
	}else if(which == 4){

		getPropertyApplicant(pid, 'PropertyDiv');
	}
	lft = getRealLeft('pimge_'+n);
	tp  = getRealTop('pimge_'+n);

	l.style.display = "block";
	l.style.left = lft-xoffset;
	l.style.top  = tp - yoffset;
}



function getPropertyApplicant(tid,lyr){


	if (document.getElementById) {

		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();

	}
	if (x){
		html = '<span align="right"><b><a href="#" onclick="document.getElementById(\'PropertyDiv\').style.display=\'none\'; return false;">Close</a></b></span>';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){
				//	alert(x.responseText);
					el.innerHTML = html+x.responseText;
				}else{

					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=properties&action=propreview&smode=fullscreen&copyrights=0&id="+tid, true);
		x.send(null);
	}
}


function getPropertyImages(pid,lyr){
	//	alert(term);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '<span align="right"><b><a href="#" onclick="document.getElementById(\'PropertyDiv\').style.display=\'none\'; return false;">Close</a></b></span>';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById(lyr);
				if(x.responseText != ""){
				//	alert(x.responseText);
					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = html+'<span align="center">Loading...</span>';
				}
			}
		}
		x.open("GET", "?mod=properties&action=propreview&smode=fullscreen&copyrights=0&id="+pid, true);
		x.send(null);
	}
}


function showcommunicationlog(xoffset, yoffset, id,itemid,modid)
{
	
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	l 	= document.getElementById('commlogframe');
		

//	if(myfolders_load == 0){
		l.src = "/?mod=commlog&action=show&modid="+modid+"&itemid="+itemid+"&smode=fullscreen&copyrights=0&showclose=1";
//		l.style.width = '600px';
	//	myfolders_load = 1;
//	}
//l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'modselectorframe\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';

	l.style.display = "block";
	lft = getRealLeft('comlog_'+id);
	tp  = getRealTop('comlog_'+id);

	l.style.left = lft-xoffset;
	l.style.top  = tp - yoffset;
}

function showappointments(xoffset, yoffset, id, itemid, pid)
{
	
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}
	l 	= document.getElementById('commlogframe');
		

//	if(myfolders_load == 0){
		l.src = "/?mod=commlog&action=app&itemid="+itemid+"&pid="+pid+"&smode=fullscreen&copyrights=0&showclose=1";
//		l.style.width = '600px';
	//	myfolders_load = 1;
//	}
//l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'modselectorframe\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';

	l.style.display = "block";
	lft = getRealLeft('comlog_'+id);
	tp  = getRealTop('comlog_'+id);

	l.style.left = lft-xoffset;
	l.style.top  = tp - yoffset;
} 

function showSmartSearch(fldname,modid,type,xoffset, yoffset)
{
	if(xoffset == null){
		xoffset = 0;
	}
	if(yoffset == null){
		yoffset = 50;
	}


		l 	= document.getElementById('modselectorframe');
//		l.innerHTML = '<span align="right"><b><a href="#" onclick="document.getElementById(\'modselectorframe\').style.display=\'none\'; return false;">Close</a></b></span><p align="center"><img src="/templates/default/folder_images/loading.gif"><br>Loading...</p>';
//
////	if(myfolders_load == 0){
		if(type=='sms'){
			l.src = "/?mod=smart_search&action=view&modid="+modid+"&type=sms&smode=fullscreen&copyrights=0";
		}else{
			l.src = "/?mod=smart_search&action=view&modid="+modid+"&smode=fullscreen&copyrights=0";
		}
//	//	myfolders_load = 1;
////	}
	
//	lft = getRealLeft(fldname);
//	tp  = getRealTop(fldname);
//
	l.style.display = "block";
//	l.style.left = lft-100;
//	l.style.top  = tp-60;
}
function hl_fld(obj)
{
	new Effect.Highlight(obj, { startcolor: '#CC9900', restorecolor: true });
//	new Effect.Scale(obj, 105);
}
function resize_elm(obj, v)
{
	new Effect.Scale(obj, v);
}

function tablefilter (phrase, _id){
	var untick = 1;
//	alert(document.getElementById('_disableautountick'));
	if(document.getElementById('_disableautountick') != null){
		if(document.getElementById('_disableautountick').checked == true){
			var untick = 0;
		}
	}
//	alert(untick);
	var words = phrase.value.toLowerCase().split(" ");
	var table = document.getElementById(_id);
	var ele;
	for (var r = 1; r < table.rows.length; r++){
		ele = table.rows[r].innerHTML.replace(/<[^>]+>/g,"");
	        var displayStyle = 'none';
	        for (var i = 0; i < words.length; i++) {
		 	   if (ele.toLowerCase().indexOf(words[i])>=0)
					displayStyle = '';
				else {
					displayStyle = 'none';
					if(table.rows[r].id){
						if(untick == 1){
							disable_checkbox_in_row(table.rows[r].id);
						}
					}
			break;
		    }
	        }
		table.rows[r].style.display = displayStyle;
	}
}

function disable_checkbox_in_row( rowID ){
	var r = document.getElementById( rowID )
	var rA = r.getElementsByTagName('*');
	var x, i=0;

	while ( x = rA[i++] ) {
		if( x.nodeName == 'INPUT' && x.type == 'checkbox')
		document.getElementById(x.id).checked = false;
	//	alert(x.id);
	}
}

function isNumeric(o)
{
	return typeof o === 'number' && isFinite(o);
}

function show_stats(mod)
{
	if(document.getElementById('stats_div').style.display == 'none'){
		document.getElementById('stats_div').style.display = 'block';
	}else{
		document.getElementById('stats_div').style.display = 'none';
	}
	if(document.getElementById('stats_div').innerHTML == ''){
		document.getElementById('stats_div').innerHTML = '<div style="background-color:#fff; padding:10px; width:530px; border:1px solid #ccc">Loading stats...</div>';
		// load stats through ajax
		load_stats(mod);
	}
	document.getElementById('stats_div').style.left = getRealLeft('statsicon')-510+'px';
	document.getElementById('stats_div').style.top  = getRealTop('statsicon')+36+'px';
}

function load_stats(mod){
	//alert(mod);
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x){
		html = '';
		x.onreadystatechange = function(){
			if (x.readyState == 4 && x.status == 200){
				el = document.getElementById('stats_div');
				if(x.responseText != ""){
				//	alert(x.responseText);
					el.innerHTML = html+x.responseText;
				}else{
					el.innerHTML = '<div style="background-color:#fff; padding:10px; width:550px; border:1px solid #ccc">Loading stats...</div>';
				}
			}
		}
		if(mod == 1){
			m='properties';
		}else if(mod == 2){
			m='landlords';
		}else if(mod == 3){
			m='tenants';
		}else if(mod == 4){
			m='enquiries';
		}else if(mod == 5){
			m='cdirectory';
		}else if(mod == 6){
			m='valuation';
		}else if(mod == 9){
			m='sales';
		}else if(mod == 10){
			m='lettings';
		}
		x.open("GET", "?mod="+m+"&action=stats&smode=fullscreen&copyrights=0", true);
		x.send(null);
	}
}

function show_left_panel()
{
	document.getElementById('left_panel').style.left = '-2px';	
	document.getElementById('lsterm').focus();
}
function hide_left_panel(f)
{
	if(f == null){
		document.getElementById('left_panel').style.left = '-220px';
	}else{
		document.getElementById('left_panel').style.left = '-230px';
	}
}

function show_prop_adv_options()
{
	if(document.getElementById('advanced_options_div').style.display == 'none'){
		Effect.SlideDown('advanced_options_div');
	//	document.getElementById('advanced_options_div').style.display = 'block';
	}else{
		Effect.SlideUp('advanced_options_div');
	//	document.getElementById('advanced_options_div').style.display = 'none';
	}
}

function ss_update_m(v)
{
	if(v == 1){
		document.getElementById('ss_ao_prop').style.display = 'block';
		document.getElementById('ss_ao_enq').style.display = 'none';
	}else if(v == 4){
		document.getElementById('ss_ao_enq').style.display = 'block';
		document.getElementById('ss_ao_prop').style.display = 'none';
	}else{
		document.getElementById('ss_ao_prop').style.display = 'none';
		document.getElementById('ss_ao_enq').style.display = 'none';
	}
}

function body_click()
{
	document.getElementById('smart-search-options').style.display = 'none';
//	document.getElementById('QuickAddMain').style.display = 'none';
}

function show_msg_panel(){
	var url = '/?mod=message&smode=transparent';
	jQuery.post(url, function(data) {
		jQuery('#messages-panel').html(data);
	});
}

function show_full_msg(flag){
	//alert('show full msg');
	jQuery('#messages-panel').css("height",'auto');
	jQuery('#messages-panel').css("width",'450px');
	var url = '/?mod=message&action=full&smode=transparent&view_flag='+flag;
	jQuery.post(url, function(data) {
		jQuery('#messages-panel').html(data);
	});
}

function show_msg_small(){
	jQuery('#messages-panel').css("height",'42px');
	jQuery('#messages-panel').css("width",'120px');
	var url = '/?mod=message&smode=transparent';
	jQuery.post(url, function(data) {
		jQuery('#messages-panel').html(data);
	});
}

function get_next_event(){
	var url = '/?mod=diary&action=nextevent&smode=transparent&copyrights=0';
	jQuery.post(url, function(data) {
		var tmp = data.split('::::')
		jQuery('#trs').html(tmp[0]);
		jQuery('#trs_first').html(tmp[1]);
	});
}

var netconnected = true; 

function hostReachable() {

	return true;
  // Handle IE and more capable browsers
  var xhr_a = new ( window.ActiveXObject || XMLHttpRequest )( "Microsoft.XMLHTTP" );
  var status;
  // Open new request as a HEAD to the root hostname with a random param to bust the cache
  xhr_a.open( "HEAD", "//" + window.location.hostname + "/?rand=" + Math.floor((1 + Math.random()) * 0x10000), false );
 // xhr.open( "HEAD", "http://www.gnomen.co.uk/media/gnomen.co.uk/images-pms4/logo.gif", false );
  // Issue request and handle response
  try {
	  xhr_a.send();
    var result = ( xhr_a.status >= 200 && xhr_a.status < 300 || xhr_a.status === 304 );
    if(result){
    	if(document.getElementById('no_internet_div')){
    		if(netconnected == false){
    			document.getElementById('internet_back_div').style.display = 'block';
    			netconnected = true;
    			clearInterval(int);
    			hidenetback = self.setInterval(function(){hide_internet_back_div()},60000);
    		}
    		document.getElementById('no_internet_div').style.display = 'none';
    	}
    }
  } catch (error) {
	if(document.getElementById('no_internet_div')){
		document.getElementById('no_internet_div').style.display = 'block';
		netconnected = false;
		int = self.setInterval(function(){hostReachable()},30000);
	}
    return false;
  }
}

function hide_internet_back_div()
{
	document.getElementById('internet_back_div').style.display = 'none';
	clearInterval(hidenetback);
}

function openpopup(url, name, args) {

    if(typeof(popupWin) != "object" || popupWin.closed)  { 
        popupWin =  window.open(url, name, args); 
    } 
    else{ 
        popupWin.location.href = url; 
    }

    popupWin.focus(); 
 }

function insert_at_cursor(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
    	"ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
    	txtarea.focus();
    	var range = document.selection.createRange();
    	range.moveStart ('character', -txtarea.value.length);
    	strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
    	txtarea.focus();
    	var range = document.selection.createRange();
    	range.moveStart ('character', -txtarea.value.length);
    	range.moveStart ('character', strPos);
    	range.moveEnd ('character', 0);
    	range.select();
    }
    else if (br == "ff") {
    	txtarea.selectionStart = strPos;
    	txtarea.selectionEnd = strPos;
    	txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

//function show_left_panel()
//{
//var slidingDiv = document.getElementById("left_panel");
//var stopPosition = 0;
//if (parseInt(slidingDiv.style.left) < stopPosition )
//{
//slidingDiv.style.left = parseInt(slidingDiv.style.left) + 2 + "px";
//setTimeout(show_left_panel, 1);
//}
//}

//function hide_left_panel()
//{
//var slidingDiv = document.getElementById("left_panel");
//var stopPosition = -220;
//if (parseInt(slidingDiv.style.left) > stopPosition )
//{ 
//slidingDiv.style.left = parseInt(slidingDiv.style.left) - 2 + "px";
//setTimeout(hide_left_panel, 1);
//}
//}