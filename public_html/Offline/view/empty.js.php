<?php
//dezend by http://www.yunlu99.com/
echo '' . "\r\n" . 'function view_empty_data(questionID)' . "\r\n" . '{' . "\r\n" . '	//��ʾ��Ŀ����' . "\r\n" . '	var questionName = \'\';' . "\r\n" . '	questionName += QtnListArray[questionID].questionName;' . "\r\n" . '	questionName += \'&nbsp;[����]\';' . "\r\n" . '	dataqtn = "{";' . "\r\n" . '	dataqtn += " questionName:\'"+qJsonCharFilter(questionName)+"\',";' . "\r\n" . '' . "\r\n" . '	//��ʾ��Ŀѡ��' . "\r\n" . '	var optionID = \'option_\'+questionID;' . "\r\n" . '	var theOptionValue = dataRow.rows[0][dataIndex[optionID]];' . "\r\n" . '	if( theOptionValue != \'\')' . "\r\n" . '	{' . "\r\n" . '		if( parseInt(theOptionValue) == 1 )' . "\r\n" . '		{' . "\r\n" . '			dataqtn += " optionName:\'true\'";' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			dataqtn += " optionName:\'false\'";' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	else' . "\r\n" . '	{' . "\r\n" . '		dataqtn += " optionName:\'����\'";' . "\r\n" . '	}' . "\r\n" . '	dataqtn += "}";' . "\r\n" . '' . "\r\n" . '	var tplText = \'<table width="100%"><tr><td class="question">{$questionName}</td></tr><tr><td><table cellSpacing=0 cellPadding=0><tr><td height=25 class="option">&nbsp;<font color=red>{$optionName}</font></td></tr></table></td></tr></table>\';' . "\r\n" . '' . "\r\n" . '    var jsondata = eval(\'(\'+dataqtn+\')\');' . "\r\n" . '	var t = new jSmart(tplText);' . "\r\n" . '    survey_content_data_html += t.fetch(jsondata);' . "\r\n" . '	jsondata = null;' . "\r\n" . '}';

?>