<?php
$url="https://www.uppclonline.com/dispatch/Portal/appmanager/uppcl/PrintReceiptServlet?accountNo=3181515000&reportName=paymentReceipt&displayReportName=Payment%20Receipt&discomName=PVVNL";
//$url="https://bijlee.co.in/bijlee/";
$html = file_get_contents( $url);
//echo $html;

libxml_use_internal_errors( true);
$doc = new DOMDocument;
$doc->loadHTML( $html);
$xpath = new DOMXpath( $doc);

// A name attribute on a <div>???
$node = $xpath->query( '//table[4]//tr[6]')->item(0);

echo $node->textContent; // This will print **GET THIS TEXT**
?>