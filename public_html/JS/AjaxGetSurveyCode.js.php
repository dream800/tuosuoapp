<?php
//dezend by http://www.yunlu99.com/
echo '' . "\r\n" . 'var http_request = false;' . "\r\n" . 'function AjaxChangeRequest(url)' . "\r\n" . '{' . "\r\n" . '	http_request = false;' . "\r\n" . '	if(window.ActiveXObject)' . "\r\n" . '	{' . "\r\n" . '		try  // IE' . "\r\n" . '		{' . "\r\n" . '			http_request = new ActiveXObject("Msxml2.XMLHTTP");' . "\r\n" . '		}' . "\r\n" . '		catch (e)' . "\r\n" . '		{' . "\r\n" . '			try' . "\r\n" . '			{' . "\r\n" . '				http_request = new ActiveXObject("Microsoft.XMLHTTP");' . "\r\n" . '			}' . "\r\n" . '			catch (e) {}' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	else if(window.XMLHttpRequest)' . "\r\n" . '	{' . "\r\n" . '		// Mozilla, Safari,...' . "\r\n" . '		http_request = new XMLHttpRequest();' . "\r\n" . '		if (http_request.overrideMimeType)' . "\r\n" . '		{' . "\r\n" . '			http_request.overrideMimeType(\'text/xml\');' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	' . "\r\n" . '	if (!http_request)' . "\r\n" . '	{' . "\r\n" . '		alert("Cannot create an XMLHTTP instance");' . "\r\n" . '		return false;' . "\r\n" . '	}' . "\r\n" . '	http_request.onreadystatechange = AlertChangeContents;' . "\r\n" . '	http_request.open(\'GET\', url, true);' . "\r\n" . '	http_request.send(null);' . "\r\n" . '}' . "\r\n" . 'function AlertChangeContents()' . "\r\n" . '{' . "\r\n" . '	if (http_request.readyState == 4)' . "\r\n" . '	{' . "\r\n" . '		if(http_request.status == 200)' . "\r\n" . '		{' . "\r\n" . '	        results = http_request.responseText.split(\'|\');' . "\r\n" . '			document.getElementById(\'code0\').innerHTML = results[0];' . "\r\n" . '			document.getElementById(\'code1\').innerHTML = results[1];' . "\r\n" . '			document.getElementById(\'code2\').innerHTML = results[2];' . "\r\n" . '			document.getElementById(\'code3\').innerHTML = results[3];' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			alert(\'���紫������\');' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '}' . "\r\n" . '';

?>