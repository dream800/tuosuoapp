<?php
//dezend by http://www.yunlu99.com/
if (!defined('ROOT_PATH')) {
	exit('EnableQ Security Violation');
}

$i = 1;

for (; $i <= $theQtnArray['maxSize']; $i++) {
	$this_fields_list .= 'option_' . $questionID . '_' . $i . '|';
	$this_fileds_type .= 'int|';
	$this_index_fields .= 'option_' . $questionID . '_' . $i . '|';
}

?>
