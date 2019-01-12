<?php
require_once('Api.php');
session_unset();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	if (isset($_POST['email']) && isset($_POST['password'])){
		$_SESSION['USERNAME'] = $_POST['email'];
		$_SESSION['PASSWORD'] = $_POST['password'];
		$api = new Api(ORGID, $_SESSION['USERNAME'], $_SESSION['PASSWORD'], CLIENTID, CLIENTSECURITY);
		if ($api->Login()) {			
			$_SESSION['api'] = $api;
			header("Location: index.php");
			exit();
		}
		else $error = "Invalid Credentials";
	}else{
		$error = "Email and Password required!";
	}
}
?>

<?php require_once('layout/header.php'); ?>
<form class="form-card" method="post">
	<fieldset class="form-fieldset">
		<legend class="form-legend">HIPPA Login</legend>
		<?php if (isset($error)) {?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			  <strong>Warning!</strong> <?php echo $error; ?>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
		<?php } ?>
		<!-- Email -->
        <div class="form-element form-input">
            <input id="email" class="form-element-field"  name="email" placeholder="Please fill in your email" type="email" required autocomplete="off" />
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="email">Email</label>
    	</div>

		<!-- Password -->
        <div class="form-element form-input">
            <input id="password" class="form-element-field"  name="password" placeholder="Please fill in your password" type="password" required autocomplete="off"/>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="password">Password</label>
    	</div>        	
	</fieldset>
    <div class="form-actions">
        <button class="form-btn" type="submit">Login</button>
        <!-- <button class="form-btn-cancel -nooutline" type="reset">Cancel</button> -->
    </div>
</form>

<?php include('layout/footer.php'); ?>