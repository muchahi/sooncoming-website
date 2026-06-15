<!-- resources/views/layouts/email.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Basic email styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        td {
            padding: 10px;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 20px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td align="center">
                <div class="email-container">
                    <!-- Header -->
                    <div class="email-header">
                        <h1>@yield('header')</h1>
                    </div>

                    <!-- Body -->
                    <div class="email-body">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>© {{ date('Y') }} LookActive. All rights reserved.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
