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
    Please find attached the resume of my Consultant(s) for the below job Position. Please review the resume and let
    me know your feedback. My Email ID is in CC of this email.
    <br>
    <br>
    <b>List of Consultants (Resume attached):</b>
    @foreach ($consultant_data as $key => $consultant)
    <br> <b>{{$key+1}}.</b> {{ $consultant->fullname }}, Location : {{$consultant->city}},{{$consultant->state}},Visa:{{$consultant->work_authorization}}
    @endforeach
    <br><br>
    <b>Additional Note from the Bench Sales Recruiter:</b> {!! $cover_letter ? nl2br($cover_letter) : '-' !!}
    <br>
    <br>
    <b>Thanks & Regards, <b>
            <br>
            <br>
            {{ $recruiter_name }}
            <br>
            Bench Sales Recruiter
            <br>
            {{ $recruiter_emailid }}
            <br>
            {{ $companyname }}
            <br>
            -------------------------------------------------------------------------------------

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
            {!! $additional_detail ? nl2br($additional_detail) : '-'!!}
            <br>
            <br>
            <b>Detailed description</b>
            <br>
            {!! nl2br($detailed_description) !!}
            <br>
            -------------------------------------------------------------------------------------



</body>

</html>
