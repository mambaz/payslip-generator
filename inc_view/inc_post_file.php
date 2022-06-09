<?php

require_once 'vendor/SimpleXLS.php';
require_once 'vendor/SimpleXLSX.php';

$header_values = $xlData = $empDatas = [];

if(isset($_POST['upload_file']))
{
    $user_file =	$_FILES["emp_info_file"]["name"];
    $user_file_type =	$_FILES["emp_info_file"]["type"];
    $user_file_size =	$_FILES["emp_info_file"]["size"];
    
    switch ($user_file_type) {
        case XLS_EXT:
            $temp = rename($_FILES['emp_info_file']['tmp_name'],$_FILES['emp_info_file']['tmp_name'].'.xls');
            if ( $xls = SimpleXLS::parse($_FILES['emp_info_file']['tmp_name'].'.xls')) {
                $xlData = $xls->rows();
            } else {
                echo SimpleXLS::parseError();
            }
            break;
        case XLSX_EXT:
            $temp = rename($_FILES['emp_info_file']['tmp_name'],$_FILES['emp_info_file']['tmp_name'].'.xlsx');
            if ( $xlsx = SimpleXLSX::parse($_FILES['emp_info_file']['tmp_name'].'.xlsx')) {
                $xlData = $xlsx->rows();
            } else {
                echo SimpleXLSX::parseError();
            }
            break;
    }
    foreach ( $xlData as $k => $r ) {
        if ( $k === 0 ) {
            $header_values = $r;
            continue;
        }
        $tempData = array_combine( $header_values, $r );
        $tempData['enc'] = base64_encode(serialize($tempData));
        $empDatas[] = $tempData;
    }
    
} else {
    deleteAll(TEMP_FOLDER, true);
}
?>
