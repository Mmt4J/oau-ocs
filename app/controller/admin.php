<?php
	include(ROOT_PATH . "/app/database/db.php");
	//include(ROOT_PATH . "/app/messages/validate_admin.php");

	$table = 'admin';

	//  $admin = selectAll($table, ['role' => 'admin']);
	 $admins = selectAll($table);
	
	$errors = array();
	$id = '';
	$username = '';
	$email = '';
	$password = '';
	$passwordC = '';

	function loginUser($user){
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		// $_SESSION['admin'] = $user['admin'];
		$_SESSION['message'] = 'You are now logged in';
		$_SESSION['type'] = 'success';

		if ($_SESSION['admin']) {
			header('location: ' . BASE_URL . '/admin/dashboard.php');
		} else {
			header('location: ' . BASE_URL . '/index.php');
		}
		exit();
	}

	if(isset($_POST['register']) || isset($_POST['create-admin']))
	{
		
		$errors = validateAdmin($_POST);

		if (count($errors) === 0) 
		{

			if (isset($_POST['update-admin'])) {
					$uAdmin = $_POST['create-admin'];
				}	
				
			unset($_POST['register'], $_POST['passwordC'], $_POST['create-admin']);
			
			$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
			if (isset($cadmin)) {

				// if (!empty($_FILES['avatar']['name'])) {
				// $image_name = time() . '_' . $_FILES['avatar']['name'];
				// $destination = ROOT_PATH . "/assets/image/" . $image_name;

				// $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

				// 	if ($result) {
				// 		$_POST['avatar'] = $image_name;
				// 	}else{
				// 		unset($_POST['avatar']);
				// 	}
				// }
		
				$user_id = create($table, $_POST);
				$user = selectOne($table, ['id' => $user_id]);
				$_SESSION['message'] = 'User created succesfully';
				$_SESSION['type'] = 'success';
				header('location:' . BASE_URL . '/admin/admin');
				exit();
			}
			
			$user_id = create($table, $_POST);
			$user = selectOne($table, ['id' => $user_id]);
			//login
			// loginUser($user);
		}else{
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$passwordC = $_POST['passwordC'];
			if (isset($cadmin)) {
				$role = $_POST['role'];
				$bio = $_POST['bio'];
				$profession = $_POST['profession'];
				$twitter = $_POST['twitter'];
				$instagram = $_POST['instagram'];
				$linkdin = $_POST['linkdin'];
			}
			
		}

	}

	if (isset($_POST['login'])) {
		$errors = validateLogin($_POST);

		if (count($errors) === 0) {
			
			$user = selectOne($table, ['username' => $_POST['username']]);

			if ($user && password_verify($_POST['password'], $user['password'])) {
				
				//Login user
				loginUser($user);
			}else{
				array_push($errors, 'Wrong credentials');
			}
		}
		$username = $_POST['username']; 	
		$password = $_POST['password']; 	
	} 

		//Delete user
	if (isset($_GET['del_id'])) {
		$count = delete($table, $_GET['del_id']);
		$_SESSION['message'] = 'User deleted succesfully';
		$_SESSION['type'] = 'success';
		header('location:' . BASE_URL . '/admin/admin');
		exit();
	}

	//fetch admin info with id for edition 
	if (isset($_GET['id'])) {
		$user = selectOne($table, ['id' => $_GET['id']]);
		$id = $user['id'];
		// $avatar = $user['avatar'];
		$username = $user['username'];
		$email = $user['email'];
		// $role = $user['role'];
		// $bio = html_entity_decode($user['bio']);
	}

	if (isset($_POST['update-admin'])) {
		$errors = validateAdmin($_POST);
		$u_id = $_POST['id'];
		$confirmP =$_POST['passwordC'];
		unset($_POST['update-admin'], $_POST['passwordC'], $_POST['id']);
		if (count($errors) === 0) {

			// if (!empty($_FILES['avatar']['name'])) {
			// $image_name = time() . '_' . $_FILES['avatar']['name'];
			// $destination = ROOT_PATH . "/assets/image/" . $image_name;

			// $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

			// 	if ($result) {
			// 		$_POST['avatar'] = $image_name;

			// 	}else{
			// 		unset($_POST['avatar']);
			// 	}
			// }
		
			$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
			// $_POST['bio'] = htmlentities($_POST['bio']);
			$count = update($table, $u_id, $_POST);
			
			$_SESSION['message'] = 'User updated succesfully';
			$_SESSION['type'] = 'success';
			header('location:' . BASE_URL . '/admin/admin');
		}else{
				$id = $u_id;
				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$passwordC = $confirmP;
				// $role = $_POST['role'];
				// $bio = $_POST['bio'];
			}

	}
