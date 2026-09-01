<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Code - Soliera Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        h1 {
            color: #2c3e50;
            margin-top: 0;
        }
        .otp-code {
            background-color: #fff;
            border: 2px solid #3498db;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #3498db;
            letter-spacing: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Your OTP Code - Soliera Hotel Login</h1>
        
        <p>Hello {{ $employeeName }}!</p>
        
        <p>You have requested to login to the Soliera Hotel Administrative System.</p>
        
        <p>Please use the following One-Time Password (OTP) to complete your login:</p>
        
        <div class="otp-code">{{ $otpCode }}</div>
        
        <p><strong>This code will expire in 10 minutes.</strong></p>
        
        <p>If you did not request this login, please ignore this email and contact your administrator.</p>
        
        <p>For security reasons, do not share this code with anyone.</p>
        
        <div class="footer">
            <p>Best regards,<br>Soliera Hotel IT Department</p>
        </div>
    </div>
</body>
</html>
