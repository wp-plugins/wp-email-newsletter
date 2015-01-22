function _wmail_redirect()
{
	window.location = "admin.php?page=general-information";
}

function _wmail_help()
{
//	window.open("http://");
}

function _email_setting()
{
	if(document.wmail_form.wmail_admin_email_option.value=="")
	{
		alert("Please select admin email option (Send auto email to admin).")
		document.wmail_form.wmail_admin_email_option.focus();
		return false;
	}
	else if(document.wmail_form.wmail_user_email_option.value == "")
	{
		alert("Please select user email option (Send auto email to subscriber).")
		document.wmail_form.wmail_user_email_option.focus();
		return false;
	}
}