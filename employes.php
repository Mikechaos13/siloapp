<?php 
	//include 'framework/models/employee.php';
	$employees = (new Employee())->_all();

	if( isset($_GET['edit']))
		$current_employee = (new Employee())->_find($_GET['edit']);	
	else
		$current_employee = (new Employee());	
 ?>
<div class="row">
	<div class="six columns">
		<h1>Employés</h1>
	</div>
</div>
<?php if (isset($_GET['error'])): ?>
<div class="row">
	<div class="six columns">
		<div class="alert-box alert">
			Vous devez remplir tous les champs
		</div>
	</div>
</div>
<?php endif ?>
<div class="row">
	<div class="six columns" id="name">
		<?php 
			if( isset($_GET['edit']) ) {
				$action = "/framework/controllers/employees/edit.php";
			} else {
				$action = "/framework/controllers/employees/ajout.php";
			}
		 ?>
		<form action="<?= $action ?>" method="post">
			<label>Nom de l'employée</label>
			<input type="text" name="name" value="<?= $current_employee->name ?>">
			<label>Type d'employé</label>
			<select name="type_id">
				<?php foreach ($current_employee->return_type_user() as $key => $value): ?>
					<?php $select = ($current_employee->type_id == $key ? 'SELECTED=SELECTED' : ''); ?>
					<option value="<?= $key ?>" <?= $select ?>><?= $value; ?></option>
				<?php endforeach ?>
			</select>

			<?php if ( isset($_GET['edit']) ): ?>
			
			<a href="/?page=employes" class="secondary radius right button">Annuler</a>
			<input type="hidden" name="employee" value="<?= $current_employee->id ?>">
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
					<th>Employé</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<?php foreach($employees as $employee):?>
				<tr>
					<td><?= $employee->name ?></td>
					<td><?= $employee->type_user() ?></td>
					<td>
						<a href="/?page=employes&edit=<?= $employee->id ?>" class="radius secondary label">Modifier</a><a href="#" class="radius alert label" data-action="delete" data-type="employees" data-id="<?= $employee->id ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>