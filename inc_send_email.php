<?php 

    function sendMail($filePath, $empData) {
        $result = false;

        // Recipient 
        $item = $empData['item'];
        $to = trim($item['Email']); 
        
        // Sender 
        $from = EMAIL_FROM; 
        $fromName = EMAIL_FROM_NAME; 
        
        // Email subject 
        $subject = $empData['period'].EMAIL_DEFAULT_SUBJECT;  
        
        // Attachment file 
        $file = $filePath; 
        
        // Email body content 
        $htmlContent = ' 
            <h3>Dear '.trim($item['Name']).'</h3> 
            <p>Attached is your e-Payslip for your reference.</p>
            <p>regards,<br>'.EMAIL_FROM_NAME.'</p>
            <p>Please reply to this email if you have any questions.</p>
        '; 
        
        // Header for sender info 
        $headers = "From: $fromName"." <".$from.">"; 
        // $headers .= "\nCc: mail@example.com"; 
        // $headers .= "\nBcc: mail@example.com";
        
        // Boundary  
        $semi_rand = md5(time());  
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
        
        // Headers for attachment  
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
        
        // Multipart boundary  
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . 
        "Content-Transfer-Encoding: 8bit\n\n" . $htmlContent . "\n\n";  
        
        // Preparing attachment 
        if(!empty($file) > 0){ 
            if(is_file($file)){ 
                $message .= "--{$mime_boundary}\n"; 
                $fp =    fopen($file,"rb"); 
                $data =  fread($fp,filesize($file)); 
        
                fclose($fp); 
                $data = chunk_split(base64_encode($data)); 
                $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
                "Content-Description: ".basename($file)."\n" . 
                "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
            } 
        } 
        $message .= "--{$mime_boundary}--"; 
        $returnPath = "-f" . $from; 
        
        // Send email 
        $mail = mail($to, $subject, $message, $headers, $returnPath);

        if ($mail){
            $result = true;
        }
        return $result;
    }

?>
