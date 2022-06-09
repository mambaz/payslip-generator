<?php

function forceFilePutContents ($filepath, $message){
    try {
        $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $filepath, $filepathMatches);
        if($isInFolder) {
            $folderName = $filepathMatches[1];
            $fileName = $filepathMatches[2];
            if (!is_dir($folderName)) {
                mkdir($folderName, 0777);  
            }
            file_put_contents($filepath, $message);
            return $filepath;
        }
    } catch (Exception $e) {
        return "ERR: error writing '$message' to '$filepath', ". $e->getMessage();
    }
}

function num($amt) {
    return number_format($amt, 2, '.', ',');
}

function stringSplit($str, $symbol) {
    return explode($symbol, $str);
}

function getAmountDetailsWithHtml($data) {
    $temps = stringSplit($data, " | ");
    $result = '<table style="width: 100%;">';
    foreach($temps as $temp) {
        $tempDetails = stringSplit($temp, ":");
        $result .= '<tr>';
        $result .= '<td width="70%">'.$tempDetails[0].'</td>';
        $result .= '<td width="30%"><span class="currency_code">'.CURRENCY_CODE.' '.num($tempDetails[1]).'</span></td>';
        $result .= '</tr>';
    }
    $result .= '</table>';
    return $result;
}

function mappingData($htmlContent, $empData, $payslipMonth) {
    $bankDetails = stringSplit($empData["Bank"], " | ");
    $earningData = getAmountDetailsWithHtml($empData["Earnings"]);
    $deductionData = getAmountDetailsWithHtml($empData["Deductions"]);
    $logo = imgToBase64(LOGO_PATH);

    $search  = array('{{LOGO}}', '{{HTML_TEMPLATE_ADDRESS_1}}','{{HTML_TEMPLATE_ADDRESS_2}}','{{HTML_TEMPLATE_ADDRESS_3}}','{{CURRENCY_CODE}}', '{{PAY_MONTH}}', '{{EMP_NAME}}', '{{DESIGNATION}}', '{{DEPARTMENT}}', '{{LOCATION}}', '{{EMP_CODE}}','{{EMP_PAN}}','{{BANK_NAME}}','{{ACCT_NUMBER}}', '{{EARNING_DATA}}','{{TOTAL_EARNINGS}}','{{DEDUCTION_DATA}}','{{TOTAL_DEDUCTIONS}}','{{NET_SALARY}}');
    $replace = array($logo, HTML_TEMPLATE_ADDRESS_1,HTML_TEMPLATE_ADDRESS_2,HTML_TEMPLATE_ADDRESS_3,CURRENCY_CODE, $payslipMonth, $empData["Name"], $empData["Designation"], $empData["Department"], $empData["Location"], $empData["ID"], $empData["PAN"], $bankDetails[0], $bankDetails[1], $earningData, num($empData["Total Earnings"]), $deductionData, num($empData["Total Deductions"]), num($empData["Net"]));

    $htmlContent = str_replace($search, $replace, $htmlContent);
    return $htmlContent;
}

function imgToBase64($logoPath) {
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPath);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}