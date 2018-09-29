var uplCount = 1;
var maxSize = 2560000; // max file size in KB
var maxTotalSize = 10240000; // max total size of all files in KB
var currSize = 0;

function addUploadingContainer(fileTypes) {
    $('form fieldset').append('<div class="row"><h4>Uploader</h4><div class="file-area"><input class="fileupload" type="file" name="files' + uplCount + '[]" data-id="' + uplCount + '" multiple required accept="'+fileTypes+'" onchange="handleUploadedFiles(this)"><div class="file-dummy"><span class="success"><span class="glyphicon glyphicon-paperclip"></span> Please select some files.</span><span class="default"><span class="glyphicon glyphicon-paperclip"></span> Please select some files.</span></div></div><div id="files' + uplCount + '"></div><input type="hidden" name="finalfiles' + uplCount + '" value=""/></div><br><br>');
    $('input.fileupload').removeAttr('required');
    uplCount++;
}

function handleUploadedFiles(e) {
    var files = $(e).get(0).files,
        filesLength = files.length,
        uplName = 'final' + $(e).prop('name').slice(0, -2),
        uplNumber = $(e).attr('data-id'),
        finalFiles = '',
        overLimit = false;

    for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        var fileReader = new FileReader();

        if(i == 0) {
            finalFiles = f.name;
        }
        else {
            finalFiles += ',' + f.name;
        }

        fileReader.onload = (function (f) {
            var fileName = f.name;

            return function(e) {
                if(f.size < maxSize) {
                    currSize += f.size;
                    if(currSize > maxTotalSize) {
                        if(!overLimit) {
                            overLimit = true;
                            $('<div class="alert alert-danger">Total allowed file size limit reached. More files can not be uploaded.</div>').insertBefore($(".fileupload[data-id='" + uplNumber + "']"));
                            return false;
                        }
                        else {
                            return false;
                        }
                    }

                    //.xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf
                    if(f['type'].split('/')[0]=='image') {
                        $("<div class=\"col-md-3 file\" title=\"" + fileName + "\">" +
                            "<img class=\"img-responsive\" src=\"" + e.target.result + "\"/>" +
                            "<br/><span class=\"remove\">x</span>" +
                            "<span class='name'>" + fileName + "</span></div>").appendTo($('#files'+ uplNumber+''));
                    }
                    else {
                        var extension = fileName.substr((fileName.lastIndexOf('.') +1));

                        switch(extension) {
                            case 'xlsx':
                            case 'xls':
                                var fileLogo = '<i class="fa fa-file-excel-o fa-4" aria-hidden="true"></i>';
                            break;
                            case 'docx':
                            case 'doc':
                                var fileLogo = '<i class="fa fa-file-word-o fa-4" aria-hidden="true"></i>';
                            break;
                            case 'pptx':
                            case 'ppt':
                                var fileLogo = '<i class="fa fa-file-powerpoint-o fa-4" aria-hidden="true"></i>';
                            break;
                            case 'txt':
                                var fileLogo = '<i class="fa fa-file-text-o fa-4" aria-hidden="true"></i>';
                                break;
                            case 'pdf':
                                var fileLogo = '<i class="fa fa-file-pdf-o fa-4" aria-hidden="true"></i>';
                            break;
                            default:
                                $('<div class="alert alert-danger">File format of '+fileName+' is not supported.</div>').insertBefore($(".fileupload[data-id='" + uplNumber + "']"));
                                editFinalFiles(uplName, fileName);
                                return false;
                        }
                        $("<div class='col-md-3 file' title='" + fileName + "'>"+fileLogo+"<span class='remove'>x" +
                            "</span><span class='name'>" +fileName +"</span></div>").appendTo($('#files'+ uplNumber+''));
                    }


                    $(".remove").click(function () {
                        $(this).parent(".file").remove();
                        editFinalFiles(uplName, $(this).parent(".file").attr('title'));
                    });
                }
                else {
                    $('<div class="alert alert-danger">File '+fileName+' is over allowed limit.</div>').insertBefore($(".fileupload[data-id='" + uplNumber + "']"));
                }
            }
        })(f);

        fileReader.readAsDataURL(f);
    }
    if($('input[name="'+uplName+'"]').val() !== '') {
        $('input[name="' + uplName + '"]').val($('input[name="' + uplName + '"]').val() + ',' + finalFiles);
    }
    else {
        $('input[name="' + uplName + '"]').val(finalFiles);
    }

    if(finalFiles != '') {
        $(e).next(".file-dummy").css('border-color', 'rgba(0,255,0,0.4)');
        $(e).next(".file-dummy").css('background-color', 'rgba(0,255,0,0.3)');
        var fd = $(e).next(".file-dummy");
        $(fd).find(".success").text('Great, your files are selected.');
        $(fd).find(".default").text('Great, your files are selected.');
    }
}

function editFinalFiles(uplName, img) {
    var inputName = $('input[name="'+uplName+'"]');
    var currentFiles = inputName.val();
    var filesArray = currentFiles.split(",");
    $.each(filesArray, function(index, value){
        if(value === img) {
            filesArray.splice(index , 1);
        }
    });
    filesArray.toString();
    inputName.val(filesArray);

    if(filesArray == '') {
        var fuName = uplName.slice(5);
        var fu = $('input[name="'+fuName+'[]"]');
        $(fu).next(".file-dummy").css('border-color', '#eee');
        $(fu).next(".file-dummy").css('background-color', 'rgba(255, 255, 255, 0.2)');
        var fd = $(fu).next(".file-dummy");
        $(fd).find(".success").html('<span class="glyphicon glyphicon-paperclip"></span> Please select some files.');
        $(fd).find(".default").html('<span class="glyphicon glyphicon-paperclip"></span> Please select some files.');
    }
}