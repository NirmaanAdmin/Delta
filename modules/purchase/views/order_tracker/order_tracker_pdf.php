<?php defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '1024M');
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div class="div_pdf">
$order_tracker
</div>
EOF;
$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
// $pdf->SetPageOrientation('L', true);
$pdf->writeHTML($html, true, false, true, false, '');
 