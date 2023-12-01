<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Application</title>
</head>
<body>

            “Hi {{ $employername}},Job Application for {{ $job_title['job_title'] }} - From shreyanjobs.com
        <br>
        <br>
            Applicant Name : {{$fullname['fullname']}}
        <br>
        <br>
            “Job Title : {{  }} , Location : {{ $city }} or “Remote, {{ $country }}
        <br>
        <br>
            Additional Job Detail
        <br>
        <br>
            Job Description
        <br>
        {{-- <h1>{{ $job_title['job_title'] }}</h1> --}}

</body>
</html>



