<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password Changed</title>
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
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            padding: 20px 0;
            background-color: #0073e6;
            color: #fff;
            border-radius: 8px 8px 0 0;
        }

        .email-body {
            padding: 20px;
            color: #333;
            font-size: 16px;
        }

        .email-body p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .email-body strong {
            display: block;
            margin-bottom: 10px;
        }

        .password {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f2f2f2;
            padding: 8px;
            border-radius: 4px;
            display: inline-block;
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            color: #777;
            font-size: 12px;
            background-color: #f4f4f4;
            border-radius: 0 0 8px 8px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            .email-container {
                padding: 10px;
            }

            .email-body p {
                font-size: 14px;
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
                        <h1>Password Changed</h1>
                    </div>

                    <!-- Email Body -->
                    <div class="email-body">
                        <p>Hi <strong>{{$user->name}}</strong></p>
                        <p>Your password has been successfully changed. Below are your updated login details:</p>

                        <!-- Display Username/Email -->
                        <strong>Email/Username:</strong>
                        <p>{{$user->email}}</p>

                        <p>{{$user->username}}</p>

                        <!-- Display New Password -->
                        <strong>New Password:</strong>
                        <p style="color: #dadada">{{$new_password}}</p>

                        <p>If you did not request this password change, please reset your password immediately or contact our support team.</p>
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>&copy; 2024 Your Company. All rights reserved.</p>
                    </div>
                </div>
                <!-- End of Email Container -->
            </td>
        </tr>
    </table>
</body>
</html>
