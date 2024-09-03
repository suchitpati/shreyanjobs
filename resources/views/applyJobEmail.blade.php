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
    Job Application for <b>{{ $job_title }}</b> From shreyanjobs.com
    <br>
    <br>
    <b>Applicant Name</b> : {{ $fullname }} (Resume Attached)
    <br>
    <br>
    Please find attached my resume for the below job Position. Please review my resume and let me know
    your feedback. My Email ID is in CC of this email.
    <br>
    <br>
    <b>My Detail</b>
    <br>
    Name:{{ $fullname }},
    <br>
    Location : {{$seeker_city}},{{$seeker_state}} ,{{$seeker_country}}
    <br>
    Visa:{{$seeker_work_authorization}}
    <br>
    Linkedin URL:{{$seeker_linkedin_url}}
    <br>
    <br>
    <b>Additional Note from the Candidate:</b> :{{ $cover_letter }}
    <br>
    <br>
    <b>Thanks & Regards,</b>
    <br>
    {{ $fullname }}
    <br>
    {{$email}}
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
