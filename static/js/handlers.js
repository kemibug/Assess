/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileQueued(file) {
	try {
		this.customSettings.tdFilesQueued.innerHTML = this.getStats().files_queued;
	} catch (ex) {
		this.debug(ex);
	}

}

function fileDialogComplete() {
	this.startUpload();
}

function uploadStart(file) {
	try {
		updateDisplay.call(this, file);
	}
	catch (ex) {
		this.debug(ex);
	}
	
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		updateDisplay.call(this, file);
	} catch (ex) {
		this.debug(ex);
	}
	
}

function uploadSuccess(file, serverData) {
	try {
		updateDisplay.call(this, file);
		myhandler(serverData);
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccessForAd(file, serverData) {
	try {
//		updateDisplay.call(this, file);
		myhandler(serverData);
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	//this.customSettings.tdFilesQueued.innerHTML = this.getStats().files_queued;
	//this.customSettings.tdFilesUploaded.innerHTML = this.getStats().successful_uploads;
	//this.customSettings.tdErrors.innerHTML = this.getStats().upload_errors;

}

function updateDisplay(file) {
	this.customSettings.tdCurrentSpeed.innerHTML = SWFUpload.speed.formatBPS(file.currentSpeed);
	this.customSettings.tdAverageSpeed.innerHTML = SWFUpload.speed.formatBPS(file.averageSpeed);
	this.customSettings.tdMovingAverageSpeed.innerHTML = SWFUpload.speed.formatBPS(file.movingAverageSpeed);
	this.customSettings.tdTimeRemaining.innerHTML = SWFUpload.speed.formatTime(file.timeRemaining);
	this.customSettings.tdTimeElapsed.innerHTML = SWFUpload.speed.formatTime(file.timeElapsed);
	this.customSettings.tdSizeUploaded.innerHTML =SWFUpload.speed.formatBytes(file.sizeUploaded);

	var percent = SWFUpload.speed.formatPercent(file.percentUploaded);
	if(percent == "100.00 %") percent = "上传中...";

	this.customSettings.tdPercentUploaded.innerHTML = percent;
}