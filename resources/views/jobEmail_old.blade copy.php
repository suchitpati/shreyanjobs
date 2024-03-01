<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    New Job Notification from shreyanjobs.com for subscribed skill :{{ $skill }}. Please login to shreyanjobs.com
    to apply for this job. <br>
    <br>
    <br>

    Job Title :{{ $title }} &nbsp; &nbsp; &nbsp; &nbsp; Location:
    @if ($remote == 1)
       Remote({{$country}})
    @else
    {{ $location }}
    @endif
     &nbsp; &nbsp; &nbsp; &nbsp;
    Duration:{{ $duration }}
    <br>
    <br>
    Additional Job Detail :
    <br>
    {!! nl2br($additional_detail) !!}
    <br>
    <br>
    Job Description :
    <br>
    {!! nl2br($description) !!}




</body>

</html>
