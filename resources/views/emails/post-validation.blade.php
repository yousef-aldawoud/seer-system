<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <p>Hello, {{ $user->name }},</p>
    <p>We have reviewed your article {{$post->title}} </p>
    @if($post->status == 'analysis')
        <p>Your article is being analysed</p>
    @else
        <p>Your article has been {{$post->status}}</p>
    @endif
    @if($postMessage !==null)
    <h3>Comments</h3>
    <p>
        {{$postMessage->message}}
    </p>
    @endif

</body>
</html>