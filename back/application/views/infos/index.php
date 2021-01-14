<?php 
	$session = $this->session->userdata('logged_in');
	$pseudo = $session['username'] ;

	$ci =&get_instance();
   	$ci->load->model("Users") ;

   	$getProfilePicture = $ci->Users->getProfilePicture($session["id"]);
?>

<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Informations de connexion</li>	 
		</ul>
	</div>

	<div class="padding-md">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<form class="updateInfos" id="updateInfos" method="POST" enctype="multipart/form-data">
							<div class="text-center mb-30">
							    <img class="profile-img mb-10" id="profile-picture" src="<?php echo $getProfilePicture->profile_picture ?>" width="125" height="125" class="mb-10" style="border-radius:50%">
							    <div class="clear"></div>
							    <span class="cpointer btn-file" onclick="getfile('update-avatar')">Modifier votre avatar</span>
							    <input type="file" name="file" id="update-avatar" class="cpointer hide">
							</div>

							<div class="form-group">
								<label for="pseudo">Pseudo</label>
								<input type="text" class="form-control input-sm" id="pseudo" name="pseudo" placeholder="Votre pseudo" value="<?php echo $getProfilePicture->username ?>">
							</div><!-- /form-group -->

							<button type="button" class="btn btn-success btn-sm" onclick="updateInfos()">Mettre à jour</button>
						</form>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
		</div>
	</div>
</div>

<script type="text/javascript">
	function getfile (type) {
	   document.getElementById(''+type+'').click();
	}

	$(document).on("change","input#update-avatar",function(e){
	    var fileElement = document.getElementById("update-avatar") ,
	    fileExtension ;

	    if (fileElement.value.lastIndexOf(".") > 0) {
	        fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
	    }

	    if ($(this)[0].files[0].size > 1000000) {
	        $.growl.error({ title:"", message: "Fichier trop volumineux"});
	        return false;
	    }
	    else if (fileExtension.toLowerCase() == "png" || fileExtension.toLowerCase() == "jpg" || fileExtension.toLowerCase() == "jpeg") {
	        if (this.files && this.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (e) {
	                $('img#profile-picture').attr('src', e.target.result).fadeIn('slow');
	            }
	            reader.readAsDataURL(this.files[0]);
	        }    
	    }
	    else {
	        $.growl.error({ title:"", message: "Fichier non supporté"});
	        return false;
	    }
	}); 
</script>