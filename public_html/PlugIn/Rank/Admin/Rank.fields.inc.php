<?php
//dezend by http://www.yunlu99.com/
if (!defined('ROOT_PATH')) {
	exit('EnableQ Security Violation');
}

foreach ($RankListArray[$questionID] as $question_rankID => $theQuestionArray) {
	$this_fields_list .= 'option_' . $questionID . '_' . $question_rankID . '|';
	$this_fileds_type .= 'int|';
	$this_index_fields .= 'option_' . $questionID . '_' . $question_rankID . '|';
}

if ($theQtnArray['isHaveOther'] == '1') {
	$this_fields_list .= 'option_' . $questionID . '_0' . '|';
	$this_fileds_type .= 'int|';
	$this_fields_list .= 'TextOtherValue_' . $questionID . '|';
	$this_fileds_type .= 'otherchar|';
}

if ($theQtnArray['isHaveWhy'] == '1') {
	$this_fields_list .= 'TextWhyValue_' . $questionID . '|';
	$this_fileds_type .= 'text|';
}

?>
