<?php

function deleteAll($dir, $isMainDir = false) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            deleteAll($file);
        else
            unlink($file);
    }
    if (!$isMainDir) {
        rmdir($dir);
    }
}

function splitPipeContent($data) {
    return str_replace(' | ', "<br />", $data);
}

?>
