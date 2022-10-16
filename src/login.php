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
        
        $id = id_from_username($Name);
        if ($id == -1) {
            http_response_code(302);
            header('location:/login?er=Username%20or%20password%20doesn%5C%27t%20match');
            die();
        }

        
        $DBPW = get_user_data($id)["pw_hash"];

        $pass = password_verify($PW, $DBPW);

        if (!$pass) {
            http_response_code(302);
            header('location:/login?er=Username%20or%20password%20doesn%5C%27t%20match');
            die();
        }


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
        $redir = "/";
        if (isset($_GET["redir"])) {
            $redir = $_GET["redir"];
        }
        header('location:'.$redir.'?es=Connected');
        die();

    } 
    html_header("login.jpg", "Login");
?>

<div class="ui container">

		<div class="tiny container">
			<div class="ui raised segments">
				<div class="ui segment">
                    <?php 
                        $redir = "/";
                        if (isset($_GET["redir"])) {
                            $redir = $_GET["redir"];
                        }
                    ?>
					<form id="register-form" class="ui form" method="post" action="/login.php?redir<?= $redir?>">
						<div class="field">
							<label>Username</label>
							<input tabindex="1" type="text" name="username" placeholder="Username"" required pattern="^[A-Za-z0-9 _\[\]-]{2,15}$">
						</div>
						<div class="field">
							<label>Password</label>
							<input tabindex="2" type="password" name="password" placeholder="Password" required pattern="^.{8,}$">
						</div>
		

					</form>
				</div>
				<div class="ui right aligned segment">
                    <button tabindex="3" class="ui primary button" type="submit" form="register-form">Submit</button>
				</div>
			</div>
		</div>
	
</div>

<?php html_footer(); ?>