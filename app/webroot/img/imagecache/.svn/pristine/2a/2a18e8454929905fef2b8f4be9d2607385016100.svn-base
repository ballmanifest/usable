(function($) {
	var opts = {};
	var current_dropzone_id = '';
	$.fn.dropzone = function(options) {
		this.each(function() {	
			var id = $(this).attr("id");
			var dropzone = document.getElementById(id);
			opts[id] = $.extend({},
			$.fn.dropzone.defaults, options);
			log("adding dnd-file-upload functionalities to element with id: " + id);
			if ($.client.browser == "Safari" && $.client.os == "Windows") {
				var fileInput = $("<input>");
				fileInput.attr({
					type: "file"
				});
				fileInput.bind("change", change);
				fileInput.css({
					'opacity': '0',
					'width': '100%',
					'height': '100%'
				});
				fileInput.attr("multiple", "multiple");
				fileInput.click(function() {
					return false;
				});
				this.append(fileInput);
			} else {
				dropzone.addEventListener("drop", drop, true);
				var jQueryDropzone = $("#" + id);
				jQueryDropzone.bind("dragenter", dragenter);
				jQueryDropzone.bind("dragover", dragover);
			}
			return this;
		});
	};
	$.fn.dropzone.defaults = {
		url: "",
		method: "POST",
		numConcurrentUploads: 3,
		printLogs: false,
		uploadRateRefreshTime: 1000
	};
	$.fn.dropzone.newFilesDropped = function(current_dropzone_id) {};
	$.fn.dropzone.uploadStarted = function(fileIndex, file, current_dropzone_id) {};
	$.fn.dropzone.uploadFinished = function(fileIndex, file, time, current_dropzone_id) {};
	$.fn.dropzone.fileUploadProgressUpdated = function(fileIndex, file, newProgress, current_dropzone_id) {};
	$.fn.dropzone.fileUploadSpeedUpdated = function(fileIndex, file, KBperSecond, current_dropzone_id) {};
	$.fn.dropzone.dataReturned = function(response) {};
	function dragenter(event) {
		event.stopPropagation();
		event.preventDefault();
		return false;
	}
	function dragover(event) {
		event.stopPropagation();
		event.preventDefault();
		return false;
	}
	function drop(event) {
		current_dropzone_id = event.currentTarget.id;
		var dt = event.dataTransfer;
		var files = dt.files;
		event.preventDefault();
		uploadFiles(files, current_dropzone_id);
		return false;
	}
	function log(logMsg) {
		if (opts.printLogs) {}
	}
	function uploadFiles(files, current_dropzone_id) {
		$.fn.dropzone.newFilesDropped(current_dropzone_id);
		console.log(current_dropzone_id, opts[current_dropzone_id]['method'], opts[current_dropzone_id]['url']);
		for (var i = 0; i < files.length; i++) {
			var file = files[i]; // create a new xhr object
			var xhr = new XMLHttpRequest();
			var upload = xhr.upload;
			upload.fileIndex = i;
			upload.fileObj = file;
			upload.downloadStartTime = new Date().getTime();
			upload.currentStart = upload.downloadStartTime;
			upload.currentProgress = 0;
			upload.startData = 0; // add listeners
			upload.addEventListener("progress", progress, false);
			upload.addEventListener("load", load, false);
			xhr.open(opts[current_dropzone_id]['method'], opts[current_dropzone_id]['url']); // getting proper values for current dropzone
			xhr.setRequestHeader("Cache-Control", "no-cache");
			xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
			xhr.setRequestHeader("X-File-Name", file.name);
			xhr.setRequestHeader("X-File-Size", file.size);
			xhr.setRequestHeader("Content-Type", "multipart/form-data");
			xhr.send(file);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					$.fn.dropzone.dataReturned(xhr.responseText);
				}
			};
			$.fn.dropzone.uploadStarted(i, file, current_dropzone_id);
		}
	}
	function load(event) {
		var now = new Date().getTime();
		var timeDiff = now - this.downloadStartTime;
		$.fn.dropzone.uploadFinished(this.fileIndex, this.fileObj, timeDiff, current_dropzone_id);
		log("finished loading of file " + this.fileIndex);
	}
	function progress(event) {
		if (event.lengthComputable) {
			var percentage = Math.round((event.loaded * 100) / event.total);
			if (this.currentProgress != percentage) {
				this.currentProgress = percentage;
				$.fn.dropzone.fileUploadProgressUpdated(this.fileIndex, this.fileObj, this.currentProgress, current_dropzone_id);
				var elapsed = new Date().getTime();
				var diffTime = elapsed - this.currentStart;
				if (diffTime >= opts.uploadRateRefreshTime) {
					var diffData = event.loaded - this.startData;
					var speed = diffData / diffTime; // in KB/sec
					$.fn.dropzone.fileUploadSpeedUpdated(this.fileIndex, this.fileObj, speed, current_dropzone_id);
					this.startData = event.loaded;
					this.currentStart = elapsed;
				}
			}
		}
	}
	function change(event) {
		event.preventDefault();
		current_dropzone_id = event.currentTarget.id;
		var files = this.files;
		uploadFiles(files, current_dropzone_id);
	}
})(jQuery);