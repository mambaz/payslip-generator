<?php

    ini_set('max_execution_time', 0); // 0 = Unlimited
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define("AUTH_USERNAME", "demo@demo.com");
    define("AUTH_PASSWORD", "Demo@123");

    define("SITE_NAME", "Payslip Generator");
    define("LOGO_PATH", "assets/logo.png");

    define("TEMP_FOLDER", "temp");
    define("PAYSLIP_DROPDOWN_SHOW_MONTH", 6); // Payslip month, year dropdown
    define("CURRENCY_CODE", "&#8377;"); 
    // ₹ => &#8377;, Rs => &#8360;

    // Email Settings
    define("EMAIL_ENABLE", false);
    define("EMAIL_FROM_NAME", "Company Name Inc.");
    define("EMAIL_FROM", "info@domain-name.com");
    define("EMAIL_REPLY_TO", "info@domain-name.com");
    define("EMAIL_DEFAULT_SUBJECT", " - Payslip");

    define("HTML_TEMPLATE", "assets/pdf-template.html");
    define("HTML_TEMPLATE_ADDRESS_1", "Company Name Pvt. Ltd.,");
    define("HTML_TEMPLATE_ADDRESS_2", "91-123, #03-70, II Avenue, Dummy Street Name,");
    define("HTML_TEMPLATE_ADDRESS_3", "CityName - 612 345.");

    define("XLS_EXT", "application/vnd.ms-excel");
    define("XLSX_EXT", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
?>