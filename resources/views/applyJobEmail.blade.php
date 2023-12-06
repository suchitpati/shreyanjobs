<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Application</title>
</head>
<body>

            Hi {{ $employername}},   <br>
           Job Application for - From shreyanjobs.com for the below job.
        <br>
        <br>
        <b>Applicant Name</b> : {{$fullname}}
        <br>
        <br>
         <b>Job Title</b> : {{ $job_title }} , Location : {{ $city,$state,$country}} or “Remote, {{ $country }}
        <br>
        <br>
        <b>Additional detail</b>
        <br>
            {!! nl2br($additional_detail) !!}
        <br>
        <br>
        <b>Detailed description</b>
        <br>
        {!! nl2br($detailed_description) !!}
        <br>
        {{-- <h1>{{ $job_title['job_title'] }}</h1> --}}

</body>
</html>



