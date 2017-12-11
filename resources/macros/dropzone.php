<?php

HTML::macro('dropzone', function($field,$directory,$populate = false)
{
    return "
    <input type='hidden' name='".$field."' value='".$directory."'>
    <div id='".$field."' class='dropzone'></div>

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
                });
                if(".$field."_populate)
                {                    
                    $.ajax({
                        type: 'POST',
                        url: '/dropzone/populate',
                        data: {directory: '".$directory."', _token: $('meta[name=\"csrf-token\"]').attr('content')},
                        success: function(data){
                            if(data)
                            {
                                $.each(data, function(key,value){
                                    
                                    var mockFile = { name: value.name, size: 12345 };
                                    ".$field."_thisDropzone.options.addedfile.call(".$field."_thisDropzone, mockFile);
                                    ".$field."_thisDropzone.options.thumbnail.call(".$field."_thisDropzone, mockFile, value.url);
                                    
                               });
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