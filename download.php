<?php

require_once 'config.php'; 
require_once 'inc_generate_pdf.php'; 
require_once 'inc_send_email.php'; 

    $result = $files = $mailResponse = array();
    $folderName = "temp";
    $subFolderName = preg_replace("/[^A-Za-z0-9]/", '', trim($_POST['period']));
    $zipName = $folderName.'/'.$subFolderName.'.zip';
    $pathDir = $folderName.'/'.$subFolderName."/"; 
    $empData = $_POST['item'];
    $result['type'] = $type = $_POST['actionType'];
    $result['name'] = $subFolderName;
    $result['path'] = '';

    foreach($empData as $emp) {
        $data = base64_decode($emp);
        $postData['item'] = $data = unserialize($data);
        $postData['period'] = $_POST['period'];
        $empId = preg_replace("/[^A-Za-z0-9]/", '', trim($data['ID']));
        $filePath = $folderName.'/'.$subFolderName.'/'.$empId.".pdf";
        $files[] = generatePdfFile($filePath, $postData);
        if ($type == 'email' && EMAIL_ENABLE == true) {
            $mailResponse[trim($data["Email"])] = sendMail($filePath, $postData);
        }
    }

    if ($type == 'zip') {
        $zip = new ZipArchive;
        if($zip -> open($zipName, ZipArchive::CREATE ) === TRUE) {
            $dir = opendir($pathDir);
            while($file = readdir($dir)) {
                if(is_file($pathDir.$file)) {
                    $zip -> addFile($pathDir.$file, $file);
                }
            }
            $zip ->close();
        }
        $result['path'] = $zipName;
    } else if ($type == 'pdf' && count($files) == 1) {
        $file = current($files);
        $path_parts = pathinfo($file);
        $result['path'] = $file;
        $result['name'] .= '_'.$path_parts['filename'];
    } else if ($type == 'email' && EMAIL_ENABLE == true) {
        $result['name'] = '';
        $result['status'] = $mailResponse;
    }

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;

?>
