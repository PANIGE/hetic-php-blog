<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 

    if (is_log()) {
        http_response_code(302);
        header('location:/?ew=Already%20Logged');
    }

    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $Name     = filter_input(INPUT_POST, "username");
        $SafeName = safe_username($Name);
        $PW       = filter_input(INPUT_POST, "password");
        $PWC      = filter_input(INPUT_POST, "passwordC");
        
        //nom d'utilisateur déja prit (Avec le username_safe)
        $q = $pdo->prepare('SELECT username_safe FROM users where username_safe = :name');
        $q->execute([
            ":name" => $SafeName
        ]);
        $t = $q->fetchAll(PDO::FETCH_ASSOC);
        $Dupe = $q->rowCount() > 0; //true = il existe un autre mec
        if ($Dupe) {
            http_response_code(302);
            header('location:/register.php?er=Username%20already%20taken');
            die();
        }
        
        //Check si les mdp sont les memes
        if ($PW != $PWC) {
            http_response_code(302);
            header('location:/register.php?er=Passwords%20does%20not%20match');
            die();
        }

        if ($PW == "" || $PWC == "") {
            http_response_code(302);
            header('location:/register.php?er=Please%20make%20a%20password,%20it\'s%20not%20safe%20to%20go%20unprotected');
            die();
        }
        

        $PW_hash = password_hash($PW , PASSWORD_DEFAULT);


        $query = $pdo->prepare('INSERT INTO users (username, username_safe ,pw_hash, mail) VALUES (:name, :sname, :pw, :mail)');
        $query->execute([
            ":name"   => $Name,
            ":pw" => $PW_hash,
            ":sname" => $SafeName,
            ":mail" => filter_input(INPUT_POST, "mail"),
        ]);

        $req = $pdo->prepare('SELECT LAST_INSERT_ID() id;');
        $req->execute();
        $id = $req->fetch(PDO::FETCH_ASSOC)["id"];
        $token = "";
        $found = false;

        while (!$found) {
            $token = random_string(32);
            $query = $pdo->prepare('SELECT token FROM tokens WHERE token = :tok');
            $query->execute([
                ":tok"   => $token,
            ]);
            $a = $query->fetchAll();
            if ($query->rowCount() == 0) {
                $found = true;
            }
        }
        $query = $pdo->prepare('INSERT INTO tokens (`id`, `token`) VALUES (:id, :tok);');
        $query->execute([
            ":tok"   => $token,
            ":id"    => $id,
        ]);
        setcookie("Authorization", $token);

        http_response_code(302);
        header('location:/?es=Account%20successfully%20created');
        die();

    } 
    
    html_header("login.jpg", "Register");
?>

<div class="ui container">

		<div class="tiny container">
			<div class="ui raised segments">
				<div class="ui segment">
					<form id="register-form" class="ui form" method="post" action="/register.php">
						<div class="field">
							<label>Username (2 to 15 characters, alphanumeric, spaces, <code>_[]-</code>)</label>
							<input tabindex="1" type="text" name="username" placeholder="Username" required pattern="^[A-Za-z0-9 _\[\]-]{2,15}$">
						</div>
                        <div class="field">
							<label>Email</label>
							<input tabindex="2" type="email" name="mail" placeholder="Email">
						</div>
						<div class="field">
							<label>Password (at least 8 characters)</label>
							<input tabindex="3" type="password" name="password" placeholder="Password"" required pattern="^.{8,}$">
						</div>
                        <div class="field">
							<label>Re-Enter password"</label>
							<input tabindex="4" type="password" name="passwordC" placeholder="Verify Password"" required pattern="^.{8,}$">
						</div>
		

					</form>
				</div>
				<div class="ui right aligned segment">
                    <button tabindex="5" class="ui primary button" type="submit" form="register-form">Submit"</button>
				</div>
			</div>
		</div>
	
</div>

<?php html_footer(); ?>