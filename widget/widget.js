// JavaScript Document

function wmail_mail_ajax_submit(url,app_id)
{   
	txt_email_newsletter = document.getElementById("wmail_txt_email");

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(txt_email_newsletter.value=="")
    {
        alert("Please enter email address.");
        txt_email_newsletter.focus();
        return false;    
    }
	if(txt_email_newsletter.value!="" && (txt_email_newsletter.value.indexOf("@",0)==-1 || txt_email_newsletter.value.indexOf(".",0)==-1))
    {
        alert("Please provide a valid email address.")
        txt_email_newsletter.focus();
        txt_email_newsletter.select();
        return false;
    }
	if (!filter.test(txt_email_newsletter.value)) 
	{
		alert('Please provide a valid email address.');
		txt_email_newsletter.focus();
        txt_email_newsletter.select();
		return false;
	}

	document.getElementById("wmail_msg").innerHTML="loading...";
	var date_now = "";
    var mynumber = Math.random();
	var str= "txt_email_newsletter="+ encodeURI(txt_email_newsletter.value) + "&timestamp=" + encodeURI(date_now) + "&action=" + encodeURI(mynumber);
	wmail_submitpostrequest(url+'/wmail_subscribe.php', str);
}

var http_req = false;
function wmail_submitpostrequest(url, parameters) 
{
	http_req = false;
	if (window.XMLHttpRequest) 
	{
		http_req = new XMLHttpRequest();
		if (http_req.overrideMimeType) 
		{
			http_req.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) 
	{
		try 
		{
			http_req = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) 
		{
			try 
			{
				http_req = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch (e) 
			{
				
			}
		}
	}
	if (!http_req) 
	{
		alert('Cannot create XMLHTTP instance');
		return false;
	}
	http_req.onreadystatechange = wmail_submitresult;
	http_req.open('POST', url, true);
	http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_req.setRequestHeader("Content-length", parameters.length);
	http_req.setRequestHeader("Connection", "close");
	http_req.send(parameters);
}


function wmail_submitresult() 
{
	//alert(http_req.readyState);
	//alert(http_req.responseText); 
	if (http_req.readyState == 4) 
	{
		if (http_req.status == 200) 
		{
		 	if (http_req.readyState==4 || http_req.readyState=="complete")
			{ 
				if((http_req.responseText).trim() == "subscribed-successfully")
				{
					document.getElementById("wmail_msg").innerHTML = "Subscribed successfully.";
					document.getElementById("wmail_txt_email").value="";
				}
				else if((http_req.responseText).trim() == "subscribed-pending-doubleoptin")
				{
					alert('You have successfully subscribed to the newsletter. You will receive a confirmation email in few minutes.\nPlease follow the link in it to confirm your subscription.\n');
					document.getElementById("wmail_msg").innerHTML = "Subscribed successfully.";
				}
				else if((http_req.responseText).trim() == "already-exist")
				{
					document.getElementById("wmail_msg").innerHTML = "Email already exist.";
				}
				else if((http_req.responseText).trim() == "unexpected-error")
				{
					document.getElementById("wmail_msg").innerHTML = "Oops.. Unexpected error occurred.";
				}
				else if((http_req.responseText).trim() == "invalid-email")
				{
					document.getElementById("wmail_msg").innerHTML = "Invalid email address.";
				}
				else
				{
					document.getElementById("wmail_msg").innerHTML = "Please try after some time.";
					document.getElementById("wmail_txt_email").value="";
				}
			} 
		}
		else 
		{
			alert('There was a problem with the request.');
		}
	}
}