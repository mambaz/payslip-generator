# Payslip Generator - Convert from Excel to PDF/ZIP and Send an Email without database
A payslip generator that takes a `.xlsx` or `.xls` file as input and outputs a downloadable `.zip` and send an email to user with `.pdf` attachment file.


# Settings
- Go to `./config.php` and update your company information like logo, name, email, address,.. and email feature enable `true` or `false`
# Instructions
- Go to [link]
- Basic auth to access the page. please get the default `username` and `password` from `./config.php`.
- Upload a .xlsx or .xls file and click "Submit" button. We will provide the sample file also. Please refer to this file `./assets/sample.xlsx`.
- Preview the Excel data to HTML table view
- Download Zip
    - It will generate the selected rows data to pdf file and compress to zip.
- Send Email
    - It will generate the PDF file and send an email with attachment file.

## Tech
- CDN
    - Bootstrap 5 for UI
    - Font awesome CSS for icon usage
    - jQuery for event
- PHP >= 7.4

## Screenshots
![Landing Page](/screenshots/login-screen-landing-page.png?raw=true "Landing Page")

![Home Page](/screenshots/home-page.png?raw=true "Home Page")

![Home Page with excel data](/screenshots/upload-data-screen.png?raw=true "Home Page with excel data")

![Payslip](/screenshots/sample-payslip.png?raw=true "Payslip PDF")
