<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php');
require_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Retreive the blog title and description, get the user ID, and place them into the database
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $user = context()["user"];
    $id = $user["id"];
    $query = $pdo->prepare('INSERT INTO blogs (`name`, `description`, `owner`) VALUES (:title, :description, :owner);');
    $query->execute([
        ":title" => $title,
        ":description" => $description,
        ":owner" => $id,
    ]);
    $blog_id = $pdo->lastInsertId();
    //Redirect to the blog page
    http_response_code(302);
    header("location:/blog/?id=".$blog_id);
}

html_header("blog.jpg", "Blog > New", -50);

?>
<div class="ui container">

		<div class="tiny container">
			<div class="ui raised segments">
				<div class="ui segment">
					<form id="register-form" class="ui form" method="post" action="/blog/new.php">
						<div class="field">
							<label>Give your blog a name</label>
							<input tabindex="1" type="text" name="title" placeholder="Title" required>
						</div>
						<div class="field">
							<label>Give your blog a description</label>
							<textarea tabindex="2" name="description" placeholder="Give a description" required></textarea>
						</div>
					</form>
				</div>
				<div class="ui right aligned segment">
                    <button tabindex="3" class="ui primary button" type="submit" form="register-form">Submit</button>
				</div>
			</div>
		</div>
	
</div>

<?php

html_footer();