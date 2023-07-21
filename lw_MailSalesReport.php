<?php
/* $Revision: 1.7 $ */
/*Now this is not secure so a malicious user could send multiple emails of the report to the intended receipients

The intention is that this script is called from cron at intervals defined with a command like:

/usr/bin/wget http://localhost/lawpract/MailSalesReport.php

The configuration of this script requires the id of the sales analysis report to send
and an array of the recipients */

/*The following three variables need to be modified for the report - the company database to use and the recipients */
/*The Sales report to send */
$_GET['ReportID'] = 2;
/*The company database to use */
$DatabaseName = 'lawpract';
/*The people to receive the emailed report */
$Recipients = array('"Root" <dpanajkar@rediffmail.com>','"' . _('someone else') . '" <dpanajkar@rediffmail.com>');



$AllowAnyone = true;
include('includes/session.php');

include('includes/htmlMimeMail5.php');
$mail = new htmlMimeMail5();

if ($Counter >0){ /* the number of lines of the sales report is more than 0  ie there is a report to send! */
	$pdfcode = $pdf->output();
	$fp = fopen( $_SESSION['reports_dir'] . '/SalesReport.pdf','wb');
	fwrite ($fp, $pdfcode);
	fclose ($fp);

	$attachment = $mail->getFile( $_SESSION['reports_dir'] . '/SalesReport.pdf');
	$mail->setText(_('Please find herewith sales report'));
	$mail->SetSubject(_('Sales Analysis Report'));
	$mail->addAttachment($attachment, 'SalesReport.pdf', 'application/pdf');
	$mail->setFrom($_SESSION['CompanyRecord']['coyname'] . '<' . $_SESSION['CompanyRecord']['email'] . '>');
	$result = $mail->send($Recipients);

} else {
	$mail->setText(_('Error running automated sales report number') . ' ' . $ReportID);
	$mail->setFrom($_SESSION['CompanyRecord']['coyname'] . '<' . $_SESSION['CompanyRecord']['email'] . '>');
	$result = $mail->send($Recipients);
}

?>
