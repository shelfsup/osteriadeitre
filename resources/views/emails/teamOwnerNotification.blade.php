<!DOCTYPE html>
<html>
<head>
    <title>Notification of Action</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li strong {
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $details['action'] }}</h1>
        <p>Dear Team Owner,</p>
        <p>A user has performed an action on your team account:</p>
        <ul>
            <li><strong>Account Name:</strong> {{ $details['name'] }}</li>
            <li><strong>IP Address:</strong> {{ $details['ip'] }}</li>
            <li><strong>Platform:</strong> {{ $details['platform'] }}</li>
            <li><strong>Is Desktop:</strong> {{ $details['is_desktop'] }}</li>
            <li><strong>User Name:</strong> {{ $details['username'] }}</li>
            <li><strong>Email:</strong> {{ $details['email'] }}</li>
            <li><strong>Event Time:</strong> {{ $details['action_time'] }}</li>
        </ul>

        {{-- <p>If you did not authorize this action, please click the button below to disable the account immediately:</p>
        <a href="{{ $details['emergency_link'] }}" class="button">Disable Account</a> --}}
    </div>
</body>
</html>
