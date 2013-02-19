<?php 
	xdebug_break();
	$date = (isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'));

	$jobs = (new Job())->_all();
	$superviseurs = (new Employee())->_where( array("type_id" => 1) );
	$affectations = (new Affectation())->_where( array("date"=>$date ) );

	$not_select_employees = (new Employee())->_query("SELECT Employees.* FROM Employees WHERE Employees.id  NOT IN (SELECT Employees.id FROM Employees LEFT JOIN Distributions ON Employees.id = Distributions.employee_id LEFT JOIN Affectations ON Affectations.id = Distributions.affectation_id WHERE Affectations.date ='$date' OR Employees.type_id = 1)");

	$the_affectation = (new Affectation())->_new();
	if( isset($_GET['modif']) ) {
		$the_affectation = (new Affectation())->_find( $_GET['modif'] ); 
		?>
		<style type="text/css">
			.distrib{display: block;}
		</style>
		<?php
	}	
 ?>
<div class="row top">
	<div class="eight columns date" style="margin-left: 15px;">
		<div class="row">
			<div class="two columns">
				En date du : 
			</div>
			<div class="four columns">
				<input type="text" class="datepicker" value="<?php echo $date; ?>">
			</div>
			<div class="six columns">
				<input type="submit" value="Sélectionner" class="button small radius success change_date">
				<a href="/" class="button small radius">Ajourd'hui</a>
			</div>
		</div>
	</div>
	<div class="two column">
		<a href="#" class="button small radius success ajouter_affectation right">Ajouter</a>
	</div>
</div>
<div class="row distrib">
	<?php $path = (isset($_GET['modif']) ? '/framework/controllers/affectation/edit.php' : '/framework/controllers/affectation/add.php' ); ?>
	<form action="<?= $path ?>" method="post">
	<div class="row">
		<div class="three columns">
			<strong>Job :</strong> 
			<select name="job">
				<?php foreach ($jobs as $job): ?>
				<?php $select = ($the_affectation->job_id == $job->id ? 'SELECTED=SELECTED' : ''); ?>
				<option value="<?= $job->id ?>" <?= $select ?>><?= $job->name ?></option>
				<?php endforeach ?>
			</select>
			<strong>Superviseur :</strong> 
			<select name="superviseur">
				<?php foreach ($superviseurs as $superviseur): ?>
				<?php $select = ($the_affectation->superviseur_id == $superviseur->id ? 'SELECTED=SELECTED' : ''); ?>
				<option value="<?= $superviseur->id ?>" <?= $select ?>><?= $superviseur->name ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="four columns">
			<strong>Employés Sélectionnés</strong> <br/>
			<?php $distribution_employee = $the_affectation->_map('distribution'); ?>
			<select name="employees_choisi[]" multiple="multiple" class="choisi">
			<?php if (!empty($distribution_employee)):  $i=0;?>
			<?php foreach ($the_affectation->_map('distribution') as $distribution): $i++;?>
			<option value="<?= $distribution->_map('employee')->id ?>"><?= $distribution->_map('employee')->name ?></option><br/>
			<?php endforeach ?>
			<?php endif ?>
			</select>
		</div>
		<div class="one column btn_gestion">
			<a href="#" class="button small radius ajout"><<</a>
			<a href="#" class="button small radius supp">>></a>
		</div>
		<div class="four columns">
			<strong>Employés</strong> <br/>
			<select name="employees" multiple="multiple" class="dispo">
			<?php foreach ($not_select_employees as $employee): ?>
			<option value="<?= $employee->id ?>"><?= $employee->name ?></option><br/>
			<?php endforeach ?>
			</select>
		</div>		
	</div>
	<div class="row">
		<div class="two columns offset-by-ten">
			<input type="hidden" name="date" value="<?= $date ?>">
			<?php if (isset($_GET['modif'])): ?>
				<input type="hidden" name="id" value="<?= $_GET['modif'] ?>">	
			<?php endif ?>
			
			<?php $value = (isset($_GET['modif']) ? 'Modifier' : 'Ajouter' ); ?>
			<a href="/?date=<?php echo $date ?>" class="button small radius cancel">Annuler</a>
			<input type="submit" value="<?= $value ?>" class="button small radius success right <?= $value ?>">
		</div>
	</div>
	</form>
</div>
<div class="row" id="name">
	<div class="twelve columns">
			 <div class="row">
			<?php foreach ($affectations as $affectation):?>
					<div class="four columns affectation">
						<div class="top_affectation">
							<h4>
								<?= $affectation->_map('job')->name ?>
								<a href="/pdf.php?id=<?= $affectation->id ?>" class="label radius right imprimer" target="_blank">Imprimer</a>
							</h4>
						</div>
						<div class="content_affectation">
							<p><span class="bold">Superviseur : </span><?= $affectation->_map('employee')->name ?></p>
							<p>
							<strong>Employés</strong><br/>
							<?php foreach ($affectation->_map('distribution') as $distribution): ?>
							<?= $distribution->_map('employee')->name ?><br/>
							<?php endforeach ?>
							</p>
							<div class="row">
								<?php  ?>
								<div class="twelve columns">
									<div class="bottom_affectation right">
										<a href="#" data-delete="<?php echo $affectation->id ?>" class="button small radius alert delete_affec">Supprimer</a>
										<a href="<?php echo url_edit($affectation->id) ?>" class="button small radius mod_affec">Modifier</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				
			<?php endforeach ?>
			</div>
	</div>
</div>
<?php 
	function url_edit($id) {
	 $pageURL = 'http';
	 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }

	 if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != ""){
	 	$pageURL .= "&modif=".$id;
	 }
	 else{
	 	$pageURL .= "?modif=".$id;
	 }
	 return $pageURL;
	}
 ?>
