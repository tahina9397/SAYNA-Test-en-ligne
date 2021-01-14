<?php 
    $error_file = "Fichier non autorisé ou trop volumineux" ;
?>

<script> 
var total_uploads = 0,
php_maxFileUploadSize = 10240000 ,
php_maxImagesPerPost = 1 ,
type = '<?php echo $type ?>' ;

$('#<?php echo $target_element;?>').fileupload();
$('#<?php echo $target_element;?>').fileupload('option', {
	url: '<?php echo $url;?>',
	dataType: 'json',
    // sequentialUploads : false ,
	formData: {type:type},
	maxFileSize: php_maxFileUploadSize,
	maxNumberOfFiles: php_maxImagesPerPost,
	autoUpload: true,
	acceptFileTypes: <?php echo $accepted_files ?>
}).bind('fileuploadprocessalways', function (e, data) {

	if (typeof(data.context) === 'undefined') return false;

    var index = data.index,
        file = data.files[index],
        node = $(data.context.children()[index]);
    
    if (file.error) {
        $.growl.error({ title:"", message: "<?php echo $error_file ?>" });
    }else{
    	total_uploads++;
    }
}).bind('fileuploaddone', function (e, data) {
	if (typeof(data.context) === 'undefined') return false;
	
	if (data.result.status == 1){
        if (total_uploads >= php_maxImagesPerPost){
            $('.btn-file').remove();
            // return;
        }
        
    	$.each(data.files, function (index, file) {
    		$('#<?php echo $target_element;?>').append('<input type="hidden" name="myfieldname" value="myvalue" />');
    		$(data.context.children()[index]).find('.progress-bar').css('width', '100%');
        });

        if (type == 'profile') {
            $('img.profile-img').attr('src', data.result.resource_url);
        }
        else if(type == 'logo_entreprise' || type == 'couverture'){
            $('img.logo-entreprise').removeClass('hide').attr('src', data.result.resource_url);
        }
        else if( $.inArray("'"+type+"'", [ 'upload_cv', 'upload_cv_apply' ]) ){
            $.growl.notice({ title:"", message: "Votre Curriculum Vitae a été téléchargé" });

            show_uploaded_cv(data.result.resource_id,type) ;
        }

	}else{
		$(data.context.children()[0]).html(data.result.error);
	}  
}).bind('fileuploadadd', function (e, data) {

 	$('#files_'+'<?php echo $target_element;?>').show();
 	
	if (total_uploads >= php_maxImagesPerPost){
        return ;
    }

    data.context = $('<div/>').appendTo('#files_'+'<?php echo $target_element;?>');
    $.each(data.files, function (index, file) {
        var node = $('<div/>')
            .append($('<span/>').text(file.name))
            .append('<div class="progress progress-xs progress-striped"><div class="progress-bar progress-bar-success"></div><div/>');
        node.appendTo(data.context);
    });
}).bind('fileuploadprogress', function (e, data) {
    console.log("progress");
	if (typeof(data.context) === 'undefined') return false;

	$.each(data.files, function (index, file) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
        $(data.context.children()[index]).find('.progress-bar').css('width', progress + '%');
    });
});
</script>