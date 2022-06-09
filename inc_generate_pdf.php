<?php

require_once 'vendor/dompdf/autoload.inc.php'; 
require_once 'helper.php'; 
use Dompdf\Dompdf; 

function generatePdfFile($filePath, $postData) {
    $html = file_get_contents(HTML_TEMPLATE);
    $html = mappingData($html, $postData['item'], $postData['period']);

    $dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();

    $result = forceFilePutContents($filePath, $output);
    return $filePath;
}
