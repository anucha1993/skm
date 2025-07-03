<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติคนงาน</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Sarabun', 'THSarabunNew', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            background-color: #fff;
        }
        
        .cv-container {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            display: flex;
            background-color: #fff;
        }
        
        /* Left Column */
        .cv-left-column {
            width: 30%;
            background-color: #2a3b4c;
            color: #fff;
            padding: 40px 20px;
        }
        
        .cv-photo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .cv-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        
        .cv-section-left {
            margin-bottom: 25px;
        }
        
        .cv-section-left h2 {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 8px;
        }
        
        .cv-contact-item {
            display: flex;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .cv-contact-icon {
            width: 30px;
            text-align: center;
            margin-right: 10px;
        }
        
        .cv-skills-list {
            list-style-type: none;
        }
        
        .cv-skills-list li {
            margin-bottom: 8px;
            position: relative;
            padding-left: 20px;
        }
        
        .cv-skills-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #4a90e2;
            font-weight: bold;
        }
        
        /* Right Column */
        .cv-right-column {
            width: 70%;
            padding: 40px;
        }
        
        .cv-header {
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 20px;
        }
        
        .cv-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2a3b4c;
            margin-bottom: 5px;
        }
        
        .cv-role {
            font-size: 18px;
            color: #4a90e2;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .cv-section-right {
            margin-bottom: 25px;
        }
        
        .cv-section-right h2 {
            color: #2a3b4c;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .cv-section-right h2::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 3px;
            background-color: #4a90e2;
        }
        
        .cv-work-item {
            margin-bottom: 20px;
        }
        
        .cv-work-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .cv-company-name {
            font-weight: 700;
            font-size: 16px;
            color: #2a3b4c;
        }
        
        .cv-work-date {
            color: #4a90e2;
            font-weight: 600;
            font-size: 14px;
        }
        
        .cv-job-title {
            font-style: italic;
            color: #555;
            margin-bottom: 8px;
        }
        
        .cv-work-description {
            margin-top: 10px;
        }
        
        .cv-work-description ul {
            padding-left: 20px;
        }
        
        .cv-work-description li {
            margin-bottom: 5px;
        }
        
        .cv-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .cv-grid-item {
            margin-bottom: 5px;
        }
        
        .cv-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 3px;
        }
        
        .cv-value {
            font-weight: 400;
        }
        
        .cv-note {
            background-color: #f9f9f9;
            border-left: 3px solid #4a90e2;
            padding: 10px 15px;
            margin-top: 10px;
        }
        
        .cv-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .cv-table th {
            background-color: #f0f0f0;
            text-align: left;
            padding: 10px;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        
        .cv-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .cv-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .cv-signature-section {
            margin-top: 30px;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .cv-signature {
            width: 200px;
        }
        
        .cv-signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
        }
        
        .cv-signature-name {
            text-align: center;
            margin-top: 10px;
        }
        
        .cv-date {
            align-self: flex-end;
            color: #777;
        }
        
        /* Print Specific Styles */
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .cv-container {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    @yield('content')

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
