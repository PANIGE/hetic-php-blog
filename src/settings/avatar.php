<?php 

	require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$uploaddir = $_SERVER['DOCUMENT_ROOT']."/avatars/".get_user_id().".png";
		
		if(file_exists($uploaddir)) {
			unlink($uploaddir);
		} 

		if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploaddir)) {
			http_response_code(302);
			header("location:/settings/avatar.php?es=Avatar%20Successfully%20Changed");
		} else {
			http_response_code(302);
			header("location:/settings/avatar.php?er=Avatar%20Could%20not%20be%20changed");
		}

        die();
        $Name     = filter_input(INPUT_POST, "username");
        $SafeName = safe_username($Name);
        $PW       = filter_input(INPUT_POST, "password");
    }


    html_header("settings.jpg", "Settings > Avatar", 200);
    
    $User = context()["user"];
    
	

?>

<div class="ui center aligned segment">
	<div class="ui compact segment" style="margin: 0 auto;">
		<img src="/avatars.php?id=<?= $User["id"] ?>" alt="Avatar" id="avatar-img" style="max-width: 400px;">
	</div>
	<form action="/settings/avatar.php" method="post" enctype="multipart/form-data" class="little top margin">
		
		<div class="ui buttons">
			<label tabindex="1" for="file" class="ui green labeled icon button">
				<i class="file icon"></i>
				Ouvrir le fichier
			</label>
			<button tabindex="2" type="submit" class="ui right labeled blue icon button">
				<i class="save icon"></i>
				Sauvegarder	
			</button>
		</div>
		<input type="file" id="file" style="display:none" required accept="image/*" name="avatar" onchange="UpdateImg(event)">
	</form>
	<script>
		function UpdateImg(e) {
			$('#avatar-img').attr("src", (window.URL || window.webkitURL).createObjectURL(event.target.files[0]));
		}
	</script>
</div>


<?php html_footer(); ?>