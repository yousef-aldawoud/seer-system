<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <p>Hello, {{ $user->name }} Thanks for registering with our website.</p>
    <p>To activate your account</p>
    <a href="{{ url('/verify/'.$user->activations()->first()->token) }}">Click here</a>
</body>
</html>