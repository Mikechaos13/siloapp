<?php 
	//include '/framework/models/model.php';
	//xdebug_break();
	include 'framework/models/job.php';
	include 'framework/models/affectation.php';
	include 'framework/models/employee.php';
	include 'framework/models/distribution.php';
	include 'framework/models/user.php';

	require_once('framework/tcpdf/config/tcpdf_config.php');
	require_once('framework/tcpdf/config/lang/fra.php');
	
	session_start();
	if( isset($_GET['page']) && $_GET['page'] =='login' && isset($_SESSION['user']) ){
		header('location: /');
	}
	elseif( ((isset($_GET['page']) && $_GET['page']!='login') || !isset($_GET['page'])) && !isset($_SESSION['user'])) {
		header('location: /?page=login');
	}
 ?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>CASA</title>

	<!-- Included CSS Files -->
	<link rel="stylesheet" href="stylesheets/app.css">
	<link rel="stylesheet" href="stylesheets/custom.css">
	<link rel="stylesheet" href="javascripts/css/ui-lightness/jquery-ui-1.9.0.custom.min.css">
	<script src="javascripts/foundation/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
	<nav class="top-bar">
	  <ul>
	    <li class="name"><h1><a href="#">CASA</a></h1></li>
	  </ul>
	  <section>
	    <ul class="right">
	    <?php if (isset($_SESSION['user'])): ?>
		    <li><a href="/">Dispatch</a></li>
		    <li><a href="/?page=jobs">Job</a></li>
		    <li><a href="/?page=employes">Employés</a></li>
		    <li><a href="/?page=utilisateurs">Utilisateurs</a></li>
		    <li><a href="/logout.php">Logout</a></li>
	    <?php else: ?>
	    	<li><a href="/?page=login">Login</a></li>
	    <?php endif ?>
	    </ul>
	  </section>
	</nav>
	<div class="container">
		<?php if( isset( $_GET['page'] ) ): ?>
			<?php include $_GET['page'].'.php'; ?>
		<?php else: ?>
			<?php include 'dispatch.php'; ?>
		<?php endif ?>
	</div>
	
	<!-- Included JS Files (Uncompressed) -->
	<script src="javascripts/foundation/jquery.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.accordion.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.alerts.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.buttons.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.forms.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.mediaQueryToggle.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.navigation.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.orbit.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.reveal.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.tabs.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.tooltips.js"></script>
	
	<script src="javascripts/foundation/jquery.foundation.topbar.js"></script>
	<script src="javascripts/js/jquery-ui-1.9.0.custom.min.js"></script>
	<script src="javascripts/foundation/jquery.placeholder.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('a[data-action="delete"]').click(function(){
				var type = $(this).attr('data-type');
				var id   = $(this).attr('data-id');
				var link = 'framework/controllers/'+type+'/delete.php';
				var moi = $(this);
				$.post(link, {id:id}, function(data){
					if(data == "0") {
						moi.parents('tr').remove();
					} else {
						alert('erreur');
					}
				},'json');

				return false;
			});

			$('dd.job').hover(
				function(){
					$(this).attr('class','job active');
				},
				function(){
					$(this).attr('class','job');
				}
			);

			$('.ajout').click(function(){
				$('.dispo option:selected').each(function(){
					$('.choisi').append($(this));
				});
				return false;
			});

			$('.supp').click(function(){
				$('.choisi option:selected').each(function(){
					$('.dispo').append($(this));
				});
				return false;
			});

			$('.Modifier').click(function(){
				$('.choisi option').attr('selected','selected');
			});

			$('.datepicker').datepicker({
				dateFormat: "yy-mm-dd"
			});

			$('.change_date').click(function(){
				var date = $('.datepicker').val();
				window.location.href = '/?date=' + date;
			});

			$('.ajouter_affectation').click(function(){
				$('.distrib').animate({
					opacity: "toggle"
				}, 500, function(){});
				return false;
			});

			$('.cancel').click(function(){
				$('.distrib').animate({
					opacity: 0
				}, 500, function(){$('.distrib').css('display','none')});
			});

			$('.delete_affec').click(function(){
				var id = $(this).attr('data-delete');
				var confirmation = confirm("Voulez vous supprimer cette affectation ?");
				
				if(confirmation == true){
					$.post('/framework/controllers/affectation/delete.php', {id:id}, function(data){
						var date = $('.datepicker').val();
						window.location.href = '/?date=' + date;
					});	
				}
				else {
					return false;
				}
			});
		});
	</script>
  <!-- Application Javascript, safe to override -->
  <script src="javascripts/foundation/app.js"></script>
</body>
</html>
