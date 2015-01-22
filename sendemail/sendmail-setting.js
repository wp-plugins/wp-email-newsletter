function _wmail_redirect()
{
	window.location = "admin.php?page=general-information";
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

function _wmail_send_email_submit()
{
	if(document.form_wmail.wmail_subject_drop.value=="")
	{
		alert("Please select email subject.")
		return false;
	}
	
	if(confirm("Are you sure you want to send email to all selected email address?"))
	{
		document.form_wmail.submit();
	}
}

function _wmail_help()
{
//	window.open("http://");
}

function _wmail_send_email_testing()
{
	wmail_email_1 = document.getElementById("wmail_email_1");
	wmail_email_2 = document.getElementById("wmail_email_2");
	wmail_email_3 = document.getElementById("wmail_email_3");
	if(document.form_wmail.wmail_subject_drop.value == "")
	{
		alert("Please select email subject.")
		return false;
	}
	else if(document.form_wmail.wmail_email_1.value == "")
	{
		alert("Please enter email address 1.")
		document.form_wmail.wmail_email_1.focus();
        document.form_wmail.wmail_email_1.select();
		return false;
	}
	else if(wmail_email_1.value!="" && (wmail_email_1.value.indexOf("@",0)==-1 || wmail_email_1.value.indexOf(".",0)==-1))
    {
        alert("Please provide a valid email address 1.")
        document.form_wmail.wmail_email_1.focus();
        document.form_wmail.wmail_email_1.select();
        return false;
    }
	else if(wmail_email_2.value!="" && (wmail_email_2.value.indexOf("@",0)==-1 || wmail_email_2.value.indexOf(".",0)==-1))
    {
        alert("Please provide a valid email address 2.")
        document.form_wmail.wmail_email_1.focus();
        document.form_wmail.wmail_email_1.select();
        return false;
    }
	else if(wmail_email_3.value!="" && (wmail_email_3.value.indexOf("@",0)==-1 || wmail_email_3.value.indexOf(".",0)==-1))
    {
        alert("Please provide a valid email address 3.")
        document.form_wmail.wmail_email_1.focus();
        document.form_wmail.wmail_email_1.select();
        return false;
    }
}
