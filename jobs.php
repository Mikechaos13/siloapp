<?php 
	//include 'framework/models/job.php';
	$jobs = (new Job())->_all();

	if( isset($_GET['edit']))
		$current_job = (new Job())->_find($_GET['edit']);	
	else
		$current_job = new Job();	
 ?>
<div class="row">
	<div class="six columns">
		<h1>Jobs</h1>
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
				$action = "/framework/controllers/jobs/edit.php";
			} else {
				$action = "/framework/controllers/jobs/ajout.php";
			}
		 ?>
		<form action="<?= $action ?>" method="post">
			<label>Nom de la job</label>
			<input type="text" name="name" value="<?= $current_job->name ?>">
			<label>Nom du client</label>
			<input type="text" name="client" value="<?= $current_job->client ?>">
			<?php if ( isset($_GET['edit']) ): ?>
			
			<a href="/?page=jobs" class="secondary radius right button">Annuler</a>
			<input type="hidden" name="job" value="<?= $current_job->id ?>">
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
					<th>Job</th>
					<th>Client</th>
					<th>Action</th>
				</tr>
			</thead>
			<?php foreach($jobs as $job): ?>
				<tr>
					<td><?= $job->name ?></td>
					<td><?= $job->client ?></td>
					<td><a class="radius secondary label" href="/?page=jobs&edit=<?= $job->id ?>">Modifier</a><a href="#" class="radius alert label" data-action="delete" data-type="jobs" data-id="<?= $job->id ?>">Supprimer</a></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>