<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <p>Hello, {{ $user->name }} Thanks for registering with our website.</p>
    <p>To reset your password click on this link </p>
    <a href="{{ url('/password-reset/'.$user->passwordResets()->first()->token) }}">Click here</a>
</body>
</html>