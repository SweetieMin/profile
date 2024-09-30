<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        table {
            border-spacing: 0;
            width: 100%;
        }

        td {
            padding: 0;
        }

        img {
            border: 0;
        }

        /* Main Email Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }

        .email-header {
            text-align: center;
            padding: 20px 0;
            background-color: #0073e6;
        }

        .email-header h1 {
            color: white;
        }

        .email-body {
            padding: 20px;
            color: #333;
        }

        .email-body h2 {
            color: #333;
        }

        .email-body p {
            line-height: 1.5;
        }

        .reset-button {
            display: inline-block;
            background-color: #0073e6;
            color: #ffffff;
            padding: 12px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            color: #777;
            font-size: 12px;
            background-color: #f4f4f4;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            .email-container {
                padding: 10px;
            }

            .email-body h2 {
                font-size: 18px;
            }

            .reset-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%" bgcolor="#f4f4f4">
        <tr>
            <td>
                <!-- Start of Email Container -->
                <div class="email-container">
                    
                    <!-- Header -->
                    <div class="email-header">
                        <h1>Password Reset</h1>
                    </div>

                    <!-- Email Body -->
                    <div class="email-body">
                        <h2>Hello, {{ $user->name }}</h2>
                        <p>You recently requested to reset your password for your account. Click the button below to reset it. This password reset link is only valid for the next 24 hours.</p>

                        <a href="{{ $actionLink }}" target="_blank" class="reset-button">Reset Your Password</a>

                        <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>&copy; 2024 Smyth Company. All rights reserved.</p>
                    </div>
                </div>
                <!-- End of Email Container -->
            </td>
        </tr>
    </table>
</body>
</html>
