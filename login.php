<?php if( isset( $_GET['error']) ): ?>
<div class="row">
	<div class="six columns offset-by-three">
		<div class="alert-box alert">
			Le nom d'utilisateur ou le mot de passe n'est pas valide.
		</div>
	</div>
</div>
<?php endif; ?>
<div class="row">
	<div class="six columns offset-by-three">
		<form action="/framework/controllers/user/connection.php" method="post">
			<label>Connexion</label>
			<input type="text" name="user" placeholder="Nom d'utilisateur">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" value="Se connecter" class="secondary radius right button">
		</form>
	</div>
</div>