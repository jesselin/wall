<?php
	require("connection.php");
	session_start();


	function logintowall()
	{
		$query = "SELECT * FROM users WHERE email = '{$_POST['login_email']}'";
		$db_record = fetch_record($query);
		// var_dump($db_record);
		if(md5($_POST['login_password'])==$db_record['password'])
		{
			// echo "<h1>Giggity</h1>";
			$_SESSION['logged_in'] = true;
			$_SESSION['user']['first_name'] = $db_record['first_name'];
			$_SESSION['user']['last_name'] = $db_record['last_name'];
			$_SESSION['user']['email'] = $db_record['email'];
			$_SESSION['user']['id'] = $db_record['user_id'];
			header('location:wall.php');
		}
		else
		{	
			// echo "<h1>Fail</h1>";
			$login_fail = '<p id="password_fail" class="alert-danger">Login failure, please try again</p>';
			$_SESSION['login_fail'] = $login_fail;
			header('location:index.php');
		}
	}


	function create_account()
	{
		$error_count = 0;

		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$error_email = '<p id="validate_email" class="alert-success">Email is valid</p>';
		}
		else
		{
			$error_email = '<p id="validate_email" class="alert-danger">Invalid Email</p>';
			$error_count += 1;
		}
		$_SESSION['error_email'] = $error_email;

		
		if(ctype_alpha($_POST['first_name']))
		{
			$error_first_name = '<p id="validate_first_name" class="alert-success">Name is valid</p>';
		}
		else
		{
			$error_first_name = '<p id="validate_first_name" class="alert-danger">Name cannot be blank or contain numbers</p>';
			$error_count += 1;
		}
		$_SESSION['error_first_name'] = $error_first_name;


		if(ctype_alpha($_POST['last_name']))
		{
			$error_last_name = '<p id="validate_last_name" class="alert-success">Name is valid</p>';
		}
		else
		{
			$error_last_name = '<p id="validate_last_name" class="alert-danger">Name cannot be blank or contain numbers</p>';
			$error_count += 1;
		}
		$_SESSION['error_last_name'] = $error_last_name;


		if(strlen($_POST['password'])>=6)
		{
			$error_password = '<p id="validate_password" class="alert-success">Password is valid</p>';
		}
		else
		{
			$error_password = '<p id="validate_password" class="alert-danger">Password must be at least 6 characters</p>';
			$error_count += 1;
		}
		$_SESSION['error_password'] = $error_password;


		if($_POST['password_confirm'] == $_POST['password'] && strlen($_POST['password_confirm'])>=6)
		{
			$error_password_confirm = '<p id="validate_password_confirm" class="alert-success">Password is valid</p>';
		}
		else
		{
			$error_password_confirm = '<p id="validate_password_confirm" class="alert-danger">Password must be at least 6 characters and match</p>';
			$error_count += 1;
		}
		$_SESSION['error_password_confirm'] = $error_password_confirm;


		$bday = explode("-", $_POST['birth_date']);
		if($bday[0]>999 && $bday[0]<=9999)
		{
			if($bday[1]>0 && $bday[1]<13)
			{
				if($bday[2]>0 && $bday[2]<32)
				{
					$error_birth_date = '<p id="validate_birth_date" class="alert-success">Date is valid</p>';
				}
			}	
		}
		else
		{
			$error_birth_date = '<p id="validate_birth_date" class="alert-danger">Date must be in YYYY-MM-DD format</p>';
			$error_count += 1;
		}
		$_SESSION['error_birth_date'] = $error_birth_date;


		if($error_count==0)
		{
			$query = "SELECT * FROM users WHERE email = '{$_POST['email']}'";
			$db_users = fetch_all($query);	
			if(count($db_users) > 0)
			{
				$error_duplicate_account =  '<p id="validate_birth_date" class="alert-danger">This account already belongs to someone</p>';
				$_SESSION['error_duplicate_account'] = $error_duplicate_account;
			}
			else
			{
				$query = "INSERT INTO users (first_name, last_name, email, password, birth_date, created_at, updated_at) VALUES ('".mysql_real_escape_string("{$_POST['first_name']}")."', '".mysql_real_escape_string("{$_POST['last_name']}")."', '".mysql_real_escape_string("{$_POST['email']}")."', '".mysql_real_escape_string(md5($_POST['password']))."', '".mysql_real_escape_string("{$_POST['birth_date']}")."', NOW(), NOW())";
				mysql_query($query);

				$_SESSION['create_account_success'] = '<p id="validate_birth_date" class="alert-success">Account was successfully created!  Please login...</p>';
			}
		}
		header('location:index.php');
	}


	function logoutofwall()
	{
		$_SESSION['logged_in'] = false;
		session_destroy();
		header('location:index.php');	
	}


	function post_message()
	{
		$query = "INSERT INTO messages (user_id, content, created_at, updated_at) VALUES ('{$_SESSION['user']['id']}', '".mysql_real_escape_string("{$_POST['new_message']}")."', NOW(), NOW())";
		mysql_query($query);
		header('location:wall.php');
	}


	function post_comment()
	{
		$query = "SELECT * FROM messages ORDER BY messages.created_at desc;";
      	$last_msg_id = fetch_record($query);
		$query2 = "INSERT INTO comments (message_id, user_id, content, created_at, updated_at) VALUES ('{$last_msg_id['message_id']}', '{$_SESSION['user']['id']}', '".mysql_real_escape_string("{$_POST['new_comment']}")."', NOW(), NOW());";
		mysql_query($query2);
		header('location:wall.php');
	}

	function delete_message()
	{
		$query_delete_comments = "DELETE FROM comments WHERE message_id = {$_POST['delete_message_id']};";
 		mysql_query($query_delete_comments);
 		$query_delete_messages = "DELETE FROM messages WHERE message_id = {$_POST['delete_message_id']};";
 		mysql_query($query_delete_messages);
		header('location:wall.php');
	}

	if(isset($_POST['action']) and $_POST['action'] == "login")
	{
		logintowall();
	}
	
	if(isset($_POST['action']) and $_POST['action'] == "create_account")
	{
		create_account();
	}
	
	if(isset($_POST['action']) and $_POST['action'] == "logout")
	{
		logoutofwall();
	}

	if(isset($_POST['action']) and $_POST['action'] == "post_message" and !(empty($_POST['new_message'])))
	{
		post_message();
	}

	if(isset($_POST['action']) and $_POST['action'] == "post_comment" and !(empty($_POST['new_comment'])))
	{
		post_comment();
	}

	if(isset($_POST['action']) and $_POST['action'] == "delete_message")
	{
		delete_message();
	}

	if(empty($_POST['post_message']))
	{
		header('location:wall.php');
	}

	if(empty($_POST['new_message']))
	{
		header('location:wall.php');
	}

?>
