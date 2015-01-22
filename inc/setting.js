
function wmail_submit()
{
	if(document.form_wmail.wmail_subject.value=="")
	{
		alert("Please enter the email subject.")
		document.form_wmail.wmail_subject.focus();
		return false;
	}
	else if(document.form_wmail.wmail_content.value=="")
	{
		alert("Please enter the email body.")
		return false;
	}
	else if(document.form_wmail.wmail_status.value=="")
	{
		alert("Please select the display status.")
		document.form_wmail.wmail_status.focus();
		return false;
	}
}

function _wmail_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_wmail_display.action="admin.php?page=add_admin_menu_email_compose&AC=DEL&DID="+id;
		document.frm_wmail_display.submit();
	}
}	


function _wmail_subscriberdealdelete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		var searchquery = document.form_subscriber.searchquery.value;
		document.form_subscriber.action="admin.php?page=add_admin_menu_view_subscriber&AC=DEL&DID=" + id + "&Search=" + searchquery;
		document.form_subscriber.submit();
	}
}	

function _wmail_subscribermultipledelete()
{
	if(confirm("Do you want to delete the selected record(s)?"))
	{
		if(confirm("Are you sure you want to delete?"))
		{
			var searchquery = document.form_subscriber.searchquery.value;
			document.form_subscriber.action="admin.php?page=add_admin_menu_view_subscriber&Search=" + searchquery;
			document.form_subscriber.submit();
		}
	}
}

function wmail_send_email_submit()
{
	if(document.form_wmail.wmail_subject_drop.value=="")
	{
		alert("Please select the email subject.")
		return false;
	}
}

function _wmail_redirect()
{
	window.location = "admin.php?page=add_admin_menu_email_compose";
}

function wmail_import()
{
	if(document.form_importemails.importemails.value=="")
	{
		alert("Please enter the email address.")
		document.form_importemails.importemails.focus();
		return false;
	}
	
	entry = document.form_importemails.importemails.value;
	var last = entry.charAt(entry.length-1); 
	if (last == ',') 
	{
		alert("Comma not allowed at the end."); 
		document.form_importemails.importemails.focus();
		return false;
	}
	
	var tarr = entry.split(',');
	var str = '';
	var j = 1;
	for (var i=0; i<tarr.length; i++) 
	{
		if (tarr[i] == '') 
		{ 
			str += 'Empty value on the position '+j+'\n'; 
			j = j+1;
		} 
		else
		{
			j = j+1;
		}
	}
	
	if (str != '') 
	{ 
		alert(str); 
		document.form_importemails.importemails.focus();
		return false;
	}
	
	if(j > 25)
	{
		alert("Maximum 25 emails only allowed at one time."); 
		document.form_importemails.importemails.focus();
		return false;
	}
	
}

function wamil_SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}


function wmail_exportcsv(url, option)
{
	if(confirm("Do you want to export the emails?"))
	{
		//document.frm_emailnewsletter.action="admin.php?page=add_admin_menu_export_csv&option="+option;
		document.frm_emailnewsletter.action= url+"?option="+option;
		document.frm_emailnewsletter.submit();
	}
}
