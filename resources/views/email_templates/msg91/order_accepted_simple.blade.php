<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gemlab</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
</head>

<body>
    <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
        <div style="margin:50px auto;width:70%;padding:20px 0">
            <div style="border-bottom:1px solid #eee" class="bg-dark p-2">
                <a href="" style="font-size:1.4em;text-decoration:none;font-weight:600" class="text-light">GEMLAB</a>
            </div>
            <p style="font-size:1.1em">Hi ##USERNAME##,</p>
            <p>##ORDER_SUBJECT##!. </p>


            <p> ##ORDER_BODY##. </p>
            <div style="display:flex;justify-content:center;">
                <h2
                    style="cursor:pointer;background: #00466a;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">
                    <a href="##ORDER_DETAILS##" style="text-decoration:none;color:#fff">View Order Details</a>
                </h2>
                <h2
                    style="cursor:pointer;background: #00466a;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;margin-left:10px">
                    <a href="##TRACK_ORDER##" style="text-decoration:none;color:#fff">Track Order</a>
                </h2>
            </div>

            <p>
                <b>
                    We have all kind of lab
                    verified precious and
                    semi-precious Gemstones
                </b>
            </p>
            <p>
                <b>
                    and all kind of jewellry
                    also. <a href="##SITE_LINK##">Explore Now</a>
                </b>
            </p>
            <br>


            <p style="font-size:0.9em;">Regards,<br />Gemlab</p>

            <hr style="border:none;border-top:1px solid #eee" />
            <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                <img src="{{ asset('public/logo/gemlab/LOGO.png') }}" alt="" height="50" width="150">
                <p>Gemlab Laboratories</p>
                <p>59-Krishna Square 2, Amritsar, 143001 </p>
                <p>India</p>
            </div>
        </div>
    </div>

</body>

</html>
