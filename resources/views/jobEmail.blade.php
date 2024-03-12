<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-family:'courier new',font-weight : 600">

    <div class="gmail_font">

        <h4>New Jobs Report from shreyanjobs.com based on your subscribed skill (Jobs posted in last
            24 Hours)</h6>
            <br>
            <br>
            ***********************************************************************************

            <h4>
                # PLEASE DO NOT REPLY TO THIS EMAIL. # <br />
                # APPLY FOR THESE JOBS DIRECTLY on www.shreyanjobs.com #
                </h6>
                <br>
                ***********************************************************************************
                <br>
                ----------------------------------------
                <br>

                @foreach ($data as $mail)
                    <br>
                    Job Title &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $mail->job_title }}
                    <br>
                    Job Location &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ $mail->country }}
                    <br>
                    skill Required &nbsp; &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ $mail->skill }}
                    <br>
                    <br>

                    <a href="www.shreyanjobs.com">Apply</a> (Login as Job Seeker, Search for this Job & Apply)

                    ----------------------------------------
                    <br>
                    ----------------------------------------
                @endforeach ()


                <br>
                Regards,
                <br>
                Support Team
                <br>
                www.shreyanjobs.com
                <br>
    </div>



</body>

</html>
