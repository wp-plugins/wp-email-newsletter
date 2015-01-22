// JavaScript Document

function _wmail_submit()
{
	if(document.wmail_form.wmail_subject.value=="")
	{
		alert("Please enter the email subject.")
		document.wmail_form.wmail_subject.focus();
		return false;
	}
	else if(document.wmail_form.wmail_content.value=="")
	{
		alert("Please enter the email content.")
		return false;
	}
	else if(document.wmail_form.wmail_status.value=="" || document.wmail_form.wmail_status.value=="Select")
	{
		alert("Please select the display status.")
		document.wmail_form.wmail_status.focus();
		return false;
	}
}

function _wmail_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_wmail_display.action="admin.php?page=compose-email&ac=del&did="+id;
		document.frm_wmail_display.submit();
	}
}

function _wmail_redirect()
{
	window.location = "admin.php?page=compose-email";
}
