<?php 
	//include 'framework/models/user.php';
	$users = (new User())->_all();

	if( isset( $_GET['edit'] ) ){
		$current_user = (new User())->_find($_GET['edit']);
	}
	else {
		$current_user =(new User());
	}
 ?>
<div class="row">
	<div class="six columns">
		<h1>Utilisateurs</h1>
	</div>
</div>
<?php if (isset($_GET['error'])): ?>
<div class="row">
	<div class="six columns">
		<div class="alert-box alert">
			<?php if ($_GET['error'] == 1): ?>
				Vous devez remplir tous les champs
			<?php else: ?>
				Le mot de passe ne concorde pas avec la validation
			<?php endif ?>
		</div>
	</div>
</div>
<?php endif ?>
<div class="row">
	<div class="six columns" id="name">
		<?php 
			if( isset($_GET['edit']) ) {
				$action = "/framework/controllers/user/edit.php";
			} else {
				$action = "/framework/controllers/user/ajout.php";
			}
		 ?>
		<form action="<?= $action ?>" method="post">
			<label>Utilisateur</label>
			<input type="text" name="name" value="<?= trim($current_user->name) ?>">
			<label>Type Utilisateur</label>
			<select name="type">
				<?php foreach ($current_user->return_type_user() as $key => $value): ?>
					<?php $select = ($current_user->type_id == $key ? 'SELECTED=SELECTED' : ''); ?>
					<option value="<?= $key ?>" <?= $select ?>><?= $value; ?></option>
				<?php endforeach ?>
			</select>
			<label>Mot de passe</label>
			<input type="password" name="password">
			<label>Validation</label>
			<input type="password" name="validation">
			
			<?php if ( isset($_GET['edit']) ): ?>
			
			<a href="/?page=utilisateurs" class="secondary radius right button">Annuler</a>
			<input type="hidden" name="utilisateur" value="<?= $current_user->id ?>">
			<input type="submit" value="Modifier" class="secondary radius right button" style="margin-right: 10px;">
			
			<?php else: ?>
			
			<input type="submit" value="Ajouter" class="secondary radius right button">
			
			<?php endif ?>

		</form>
	</div>
	<div class="six columns">
		<table style="width: 100%;">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<?php foreach($users as $user): ?>
				<tr>
					<td><?= $user->name ?></td>
					<td><?= $user->type_user() ?></td>
					<td><a class="radius secondary label" href="/?page=utilisateurs&edit=<?= $user->id ?>">Modifier</a><a href="#" class="radius alert label" data-action="delete" data-type="user" data-id="<?= $user->id ?>">Supprimer</a></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>