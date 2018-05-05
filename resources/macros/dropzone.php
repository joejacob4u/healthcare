<?php

HTML::macro('dropzone', function($field,$directory,$populate = false)
{
    return "
    <input type='hidden' name='".$field."' value='".$directory."'>
    <div id='".$field."' class='dropzone'></div>
    
    <ul class=\"list-group\" id='".$field."_file_list'>
        <li class=\"list-group-item list-group-item-info\">File Actions</li>
    </ul>

    <script>
        var ".$field."_populate = ".$populate.";
    
        $('#".$field."').dropzone({ 
            url: '/dropzone/upload' ,
            paramName: 'file',
            maxFilesize: 4,
            autoDiscover: false,
            addRemoveLinks: true,
            init: function() {
                ".$field."_thisDropzone = this;
                this.on('sending', function(file, xhr, formData){
                    formData.append('_token', $('meta[name=\"csrf-token\"]').attr('content'));
                    formData.append('folder', '".$directory."');
                    if (file.type.indexOf('image/') == -1)
                    {
                        this.emit('thumbnail', file, '/images/document.png');
                    }
                });
                if(".$field."_populate)
                {                    
                    $.ajax({
                        type: 'POST',
                        url: '/dropzone/populate',
                        data: {directory: '".$directory."', _token: $('meta[name=\"csrf-token\"]').attr('content')},
                        beforeSend:function()
                        {
                            $('.box').append('<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>');
                        },
                        success: function(data){
                            if(data)
                            {
                                $.each(data, function(key,value){
                                    
                                    var mockFile = { name: value.name, size: 12345 };

                                    ".$field."_thisDropzone.options.addedfile.call(".$field."_thisDropzone, mockFile);

                                    if (value.name.indexOf('.jpg') >= 0 || value.name.indexOf('.png') >= 0)
                                    {
                                        ".$field."_thisDropzone.options.thumbnail.call(".$field."_thisDropzone, mockFile, value.url);
                                    }
                                    else
                                    {
                                        ".$field."_thisDropzone.options.thumbnail.call(".$field."_thisDropzone, mockFile, '/images/document.png');
                                    }

                                    $('#".$field."_file_list').append('<li class=\"list-group-item\"><span class=\"glyphicon glyphicon-paperclip\"></span> '+value.name+'<a href=\"#\" class=\"btn btn-danger btn-xs pull-right\"><span class=\"glyphicon glyphicon-remove\"></span> Delete</a><a href=\"'+value.url+'\" target=\"_blank\" class=\"btn btn-primary btn-xs pull-right\" ><span class=\"glyphicon glyphicon-eye-open\"></span> View</a></li>');
                                    
                               });
                               var a = document.createElement('a');
                               a.setAttribute('href',\"/uploads/\" + file.fullname);
                               a.innerHTML = \"<br>download\";
                               file.previewTemplate.appendChild(a);
           
                            }
        
                        }
                    });
                }

                this.on('success', function(file, xhr){
                    console.log('file uploaded'+file);
                });
                this.on('removedfile', function(file) {
                    $.ajax({
                        type: 'POST',
                        url: '/dropzone/delete',
                        data: {file: file.name,directory:'".$directory."', _token: $('meta[name=\"csrf-token\"]').attr('content')},
                        dataType: 'html',
                        success: function(data){

                        }
                    });

                });
            },
        });
    </script>";
});


?>