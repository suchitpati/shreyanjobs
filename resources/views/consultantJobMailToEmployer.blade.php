<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Application</title>
</head>

<body>

    Hi,
    <br>
    <br>
    Job Application for {{ $job_title }} From shreyanjobs.com for the below job.
    <br>
    <br>
    <b>Consultants Name</b> : @foreach ($consultant_data as $consultant)
        {{ $consultant->fullname }},
    @endforeach
    (Resume Attached)
    <br>
    <br>
    ( ** Note : This candidate does not belong to shreyanjobs.com. The candidate or Bench Sales Recruiter email ID is in
    CC on this email. Please communicate with that email directly). <br>
    *** shreyanjobs.com is an IT Job Portal - Connecting Job Seekers & Employers/ Recruiters
    <br>
    <br>
    <b>Bench Sales Recruiter Name :</b>{{ $recruiter_name }}(Email in CC of this email)
    <br>
    <br>
    <b>Message from Bench Sales Recruiter :</b> {{ $cover_letter }}
    <br>
    <br>
    <b>Job Title</b> : {{ $job_title }} ,
    @if ($remote)
        Location : Remote, {{ $country }}
    @else
        Location : {{ $city }}, {{ $state }}, {{ $country }}
    @endif

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


</body>

</html>
