<?php
//dezend by http://www.yunlu99.com/
if ((ob_get_length() === false) && !ini_get('zlib.output_compression') && (ini_get('output_handler') != 'ob_gzhandler') && (ini_get('output_handler') != 'mb_output_handler')) {
	ob_start('ob_gzhandler');
}

header('Cache-Control: public');
header('Pragma: cache');
$offset = 2592000;
$ExpStr = 'Expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT';
$LmStr = 'Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(__FILE__)) . ' GMT';
header($ExpStr);
header($LmStr);
header('Content-Type: text/javascr��pt; charset: UTF-8');
echo '' . "\r\n" . '//�ļ��ɹ�ѡ��󴥷����¼�' . "\r\n" . 'function fileQueued(file) {' . "\r\n" . '	try {' . "\r\n" . '		var progress = new FileProgress(file, this.customSettings.progressTarget);' . "\r\n" . '		progress.setStatus("Pending...");' . "\r\n" . '		progress.toggleCancel(true, this);' . "\r\n" . '' . "\r\n" . '	} catch (ex) {' . "\r\n" . '		this.debug(ex);' . "\r\n" . '	}' . "\r\n" . '' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . 'function fileQueueError(file, errorCode, message) {' . "\r\n" . '	try {' . "\r\n" . '		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {' . "\r\n" . '			$.notification("You have attempted to queue too many files.\\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));' . "\r\n" . '			return;' . "\r\n" . '		}' . "\r\n" . '' . "\r\n" . '		var progress = new FileProgress(file, this.customSettings.progressTarget);' . "\r\n" . '		progress.setError();' . "\r\n" . '		progress.toggleCancel(false);' . "\r\n" . '' . "\r\n" . '		switch (errorCode) {' . "\r\n" . '		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:' . "\r\n" . '			progress.setStatus("File is too big.");' . "\r\n" . '			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:' . "\r\n" . '			progress.setStatus("Cannot upload Zero Byte files.");' . "\r\n" . '			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:' . "\r\n" . '			progress.setStatus("Invalid File Type.");' . "\r\n" . '			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:' . "\r\n" . '			$.notification("You have selected too many files.  " +  (message > 1 ? "You may only add " +  message + " more files" : "You cannot add any more files."));' . "\r\n" . '			break;' . "\r\n" . '		default:' . "\r\n" . '			if (file !== null) {' . "\r\n" . '				progress.setStatus("Unhandled Error");' . "\r\n" . '			}' . "\r\n" . '			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		}' . "\r\n" . '	} catch (ex) {' . "\r\n" . '        this.debug(ex);' . "\r\n" . '    }' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . 'function fileDialogComplete(numFilesSelected, numFilesQueued) {' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . '//�ϴ���ʼʱ�����¼�' . "\r\n" . 'function uploadStart(file) {' . "\r\n" . '	try {' . "\r\n" . '		if( document.getElementById(\'SurveyNextSubmit\') != null ) document.getElementById(\'SurveyNextSubmit\').disabled = true;' . "\r\n" . '		if( document.getElementById(\'SurveyOverSubmit\') != null ) document.getElementById(\'SurveyOverSubmit\').disabled = true;' . "\r\n" . '' . "\r\n" . '		var progress = new FileProgress(file, this.customSettings.progressTarget);' . "\r\n" . '		progress.setStatus("Uploading...");' . "\r\n" . '		progress.toggleCancel(true, this);' . "\r\n" . '	}' . "\r\n" . '	catch (ex) {' . "\r\n" . '	}' . "\r\n" . '	' . "\r\n" . '	return true;' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . '//�ļ��ϴ������д����¼�' . "\r\n" . 'function uploadProgress(file, bytesLoaded, bytesTotal) {' . "\r\n" . '' . "\r\n" . '	try {' . "\r\n" . '		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);' . "\r\n" . '' . "\r\n" . '		var progress = new FileProgress(file, this.customSettings.progressTarget);' . "\r\n" . '		progress.setProgress(percent);' . "\r\n" . '		progress.setStatus("Uploading...");' . "\r\n" . '	} catch (ex) {' . "\r\n" . '		this.debug(ex);' . "\r\n" . '	}' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . '//�ļ���������г��������¼�' . "\r\n" . 'function uploadError(file, errorCode, message) {' . "\r\n" . '	try {' . "\r\n" . '		var progress = new FileProgress(file, this.customSettings.progressTarget);' . "\r\n" . '		progress.setError();' . "\r\n" . '		progress.toggleCancel(false);' . "\r\n" . '' . "\r\n" . '		switch (errorCode) {' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:' . "\r\n" . '			progress.setStatus("Upload Error: " + message);' . "\r\n" . '			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:' . "\r\n" . '			progress.setStatus("Upload Failed.");' . "\r\n" . '			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.IO_ERROR:' . "\r\n" . '			progress.setStatus("Server (IO) Error");' . "\r\n" . '			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:' . "\r\n" . '			progress.setStatus("Security Error");' . "\r\n" . '			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:' . "\r\n" . '			progress.setStatus("Upload limit exceeded.");' . "\r\n" . '			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:' . "\r\n" . '			progress.setStatus("Failed Validation.  Upload skipped.");' . "\r\n" . '			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:' . "\r\n" . '			progress.setStatus("Cancelled");' . "\r\n" . '			progress.setCancelled();' . "\r\n" . '			break;' . "\r\n" . '		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:' . "\r\n" . '			progress.setStatus("Stopped");' . "\r\n" . '			break;' . "\r\n" . '		default:' . "\r\n" . '			progress.setStatus("Unhandled Error: " + errorCode);' . "\r\n" . '			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);' . "\r\n" . '			break;' . "\r\n" . '		}' . "\r\n" . '	} catch (ex) {' . "\r\n" . '        this.debug(ex);' . "\r\n" . '    }' . "\r\n" . '}' . "\r\n" . '' . "\r\n" . 'function uploadComplete(file){}' . "\r\n" . '';

?>