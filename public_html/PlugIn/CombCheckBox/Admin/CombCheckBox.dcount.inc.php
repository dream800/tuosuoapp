<?php
//dezend by http://www.yunlu99.com/
if (!defined('ROOT_PATH')) {
	exit('EnableQ Security Violation');
}

$EnableQCoreClass->setTemplateFile('ShowOption' . $questionID . 'File', 'DeCount1D.html');
$EnableQCoreClass->set_CycBlock('ShowOption' . $questionID . 'File', 'OPTION', 'option' . $questionID);
$EnableQCoreClass->replace('option' . $questionID, '');
$EnableQCoreClass->replace('questionName', qnospecialchar($theQtnArray['questionName']));

if ($theQtnArray['isHaveOther'] == '1') {
	$OptionCountSQL = ' SELECT COUNT(*) AS skipAnswerNum FROM ' . $table_prefix . 'response_' . $surveyID . ' b WHERE b.option_' . $questionID . ' = \'\' AND b.TextOtherValue_' . $questionID . ' = \'\' and ' . $dataSource;
}
else {
	$OptionCountSQL = ' SELECT COUNT(*) AS skipAnswerNum FROM ' . $table_prefix . 'response_' . $surveyID . ' b WHERE b.option_' . $questionID . ' = \'\' and ' . $dataSource;
}

$OptionCountRow = $DB->queryFirstRow($OptionCountSQL);
$EnableQCoreClass->replace('skipAnswerNum', $OptionCountRow['skipAnswerNum']);
$skipAnswerNum = $OptionCountRow['skipAnswerNum'];
$EnableQCoreClass->replace('skipAnswerPercent', countpercent($skipAnswerNum, $totalRepAnswerNum));
$thisOptionResponseNum = $totalRepAnswerNum - $skipAnswerNum;
$EnableQCoreClass->replace('repAnswerNum', $thisOptionResponseNum);
$EnableQCoreClass->replace('repAnswerPercent', countpercent($thisOptionResponseNum, $totalRepAnswerNum));
$OptionSQL = ' SELECT a.question_checkboxID,count(*) as optionResponseNum FROM ' . QUESTION_CHECKBOX_TABLE . ' a,' . $table_prefix . 'response_' . $surveyID . ' b WHERE a.questionID = \'' . $questionID . '\' AND FIND_IN_SET(a.question_checkboxID,b.option_' . $questionID . ') and ' . $dataSource;
$OptionSQL .= ' GROUP BY a.question_checkboxID ORDER BY optionResponseNum DESC';
$OptionResult = $DB->query($OptionSQL);
$allResponseOptionID = array();
$allOptionResponseNum = array();

while ($OptionRow = $DB->queryArray($OptionResult)) {
	$allResponseOptionID[] = $OptionRow['question_checkboxID'];
	$allOptionResponseNum[$OptionRow['question_checkboxID']] = $OptionRow['optionResponseNum'];
}

foreach ($CheckBoxListArray[$questionID] as $question_checkboxID => $theQuestionArray) {
	$EnableQCoreClass->replace('optionName', qnospecialchar($theQuestionArray['optionName']));

	if (in_array($question_checkboxID, $allResponseOptionID)) {
		$EnableQCoreClass->replace('answerNum', $allOptionResponseNum[$question_checkboxID]);
		$EnableQCoreClass->replace('optionPercent', countpercent($allOptionResponseNum[$question_checkboxID], $totalRepAnswerNum));
		$EnableQCoreClass->replace('optionValidPercent', countpercent($allOptionResponseNum[$question_checkboxID], $thisOptionResponseNum));
	}
	else {
		$EnableQCoreClass->replace('answerNum', 0);
		$EnableQCoreClass->replace('optionPercent', 0);
		$EnableQCoreClass->replace('optionValidPercent', 0);
	}

	$EnableQCoreClass->parse('option' . $questionID, 'OPTION', true);
}

unset($allResponseOptionID);
unset($allOptionResponseNum);
$DataCrossHTML = $EnableQCoreClass->parse('ShowOption' . $questionID, 'ShowOption' . $questionID . 'File');
$DataCrossHTML = preg_replace('/<!-- BEGIN OTHER -->(.*)<!-- END OTHER -->/s', '', $DataCrossHTML);

?>
