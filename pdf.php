<?php 
	xdebug_break();
	
	include 'framework/models/job.php';
	include 'framework/models/affectation.php';
	include 'framework/models/user.php';
	include 'framework/models/employee.php';
	include 'framework/models/distribution.php';
	session_start();
	require_once('framework/tcpdf/tcpdf.php');
	require_once('framework/tcpdf/config/lang/fra.php');

	if(isset($_GET['test'])){
		$test = (new Affectation())->_find($_GET['test']);
		var_dump($test);
	}
	if(isset($_GET['id'])) {
		$affectation = (new Affectation())->_find($_GET['id']);
		$job 		 = $affectation->_map('job');
		$user        = $_SESSION['user']->name;

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($user);
		$pdf->SetTitle('Rapport du '. $affectation->date .'pour '.$job->name);
		$pdf->SetSubject('Rapport du jour');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);

		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 14, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

		// Set some content to print
		$html = "
			<h1>{$job->name}</h1>
			<p><strong>Superviseur : </strong> {$affectation->_map('employee')->name}</p>
			<p><strong>Date : </strong> {$affectation->date}</p>
			<p>
				<strong>Employés : </strong><br/>";
		
		foreach ($affectation->_map('distribution') as $distribution){
			$html .= $distribution->_map('employee')->name.'<br/>';
		}	
		
		$html .= "</p>";

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

		// ---------------------------------------------------------

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('rapport_'.$affectation->id.'.pdf', 'I');
	}
 ?>