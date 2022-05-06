var DropzoneExample = function () {
    var DropzoneDemos = function () {
        /* Dropzone.options.singleFileUpload = {
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 5,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        };
        Dropzone.options.multiFileUpload = {
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        }; */
        Dropzone.options.fileTypeValidation = {
          paramName: "file",
          maxFiles: 10,
          maxFilesize: 10,
          acceptedFiles: "image/png, image/jpeg, image/jpg",
          accept: function (file, done) {
          },
        };
        
    }
    return {
        init: function() {
            DropzoneDemos();
        }
    };
}();
DropzoneExample.init();