<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <style>
        * {
            letter-spacing: 1.5px
        }




        #header_org {
            position: relative;
            display: block;

        }

        #header_org::after {
            position: absolute;
            content: '';
            bottom: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background-image: url('public/logo/gemlab/UnderLine.png');
            background-size: 100% 100%;

        }

        #footer_cont {
            position: relative;
            display: block;
        }

        #footer_cont::before {
            position: absolute;
            content: '';
            top: -6px;
            right: 0;
            width: 20%;
            height: 6px;
            background-image: url('public/logo/gemlab/UnderLine.png');
            background-size: 100% 100%;
        }

        .btn-gradient-1 {


            background: #90a0af;
            border: 2px solid rgb(248, 15, 54);
            position: relative;
            width: 220px;
            height: 50px;
            padding-left: 10px;
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: color .2s;
            transition: .5s;
            text-transform: uppercase;
            color: #1b1919;
            font-weight: 750;
            font-size: .85rem;
            box-shadow: 1px 1px 10px rgba(123, 198, 241, 0.726);
            overflow: hidden;
        }

        .btn-gradient-1::after {
            content: "";
            pointer-events: none;
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, transparent, rgb(241, 240, 240), transparent, transparent);
            left: -100%;
            top: 0;
            transition: .5s;
            z-index: 99999;

        }

        .btn-gradient-1:hover::after {
            left: 100%;
        }

        .btn-gradient-1:hover {
            border-image: linear-gradient(to right, rgb(17, 219, 17), rgb(224, 8, 44)) 1;

        }


        .btn-gradient-1::before {
            content: "";
            pointer-events: none;
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #8099dd 0%, #8099dd 50%, #e2e3e4 50%, #e2e3e4 100%);
            opacity: .2;
            left: 0;
            top: 0;
        }

    </style>

</head>

<body style="margin:0;padding:0;background-color:#FFF;font-family: 'Montserrat', sans-serif;">
    <center>
        <table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable" width="100%"
            data-upload-file-url="/ajax/email-editor/file/upload"
            data-upload-files-url="/ajax/email-editor/files/upload"
            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:auto;padding:0;background-color:#FFF;height:100%;margin:0;width:100%">
            <tbody>
                <tr>
                    <td align="center" id="bodyCell" valign="top"
                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:auto;padding-top:50px;padding-left:20px;padding-bottom:20px;padding-right:20px;border-top:0;height:100%;margin:0;width:100%">
                        <div class="templateContainer"
                            style="border:0 none #aaa;background-color:#fff;border-radius:0;display: table; width:600px">
                            <div class="templateContainerInner" style="padding:0">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                    <tr>
                                        <td align="center" valign="top"
                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                            <table border="0" cellpadding="0" cellspacing="0" class="templateRow"
                                                width="100%"
                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                <tbody>
                                                    <tr>
                                                        <td class="rowContainer kmFloatLeft" valign="top"
                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmTextBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                <tbody class="kmTextBlockOuter">
                                                                    <tr>
                                                                        <td class="kmTextBlockInner" valign="top"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                            <table align="left" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                class="kmTextContentContainer"
                                                                                width="100%"
                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kmTextContent"
                                                                                            valign="top"
                                                                                            style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-size:14px;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;color:#666666;padding-bottom:10px;text-align:center;padding-right:0px;padding-left:0px;padding-top:0px;'>
                                                                                            <p style="margin:0;padding:5px;background:rgb(216, 216, 216);"
                                                                                                id="header_org">
                                                                                                <span><a href="#"
                                                                                                        style="color:rgb(59, 59, 59);text-decoration:none;font-size:2rem">
                                                                                                        GEMLAB
                                                                                                    </a></span>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmButtonCollectionBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                <tbody class="kmButtonCollectionOuter">
                                                                    <tr>
                                                                        <td class="kmButtonCollectionInner"
                                                                            align="center" valign="top"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;min-width:60px;background-color:#FFFFFF;padding-left:18;padding-right:18;">
                                                                            <table border="0" cellpadding="0"
                                                                                cellspacing="0"
                                                                                class="kmButtonCollectionContentContainer"
                                                                                width="100%"
                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="left"
                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                            <table width="100%"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0"
                                                                                                class="kmButtonCollectionContent"
                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                            <table
                                                                                                                border="0"
                                                                                                                cellpadding="0"
                                                                                                                cellspacing="0"
                                                                                                                align="center"
                                                                                                                class="kmMobileNoAlign kmMobileAutoWidth"
                                                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                                                <tr style="font-size: 0; float:left;"
                                                                                                                    class="kmMobileNoAlign">

                                                                                                                    <td valign="middle"
                                                                                                                        class="kmMobileHeaderStackDesktopNone"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:none">
                                                                                                                        <table
                                                                                                                            align="center"
                                                                                                                            border="0"
                                                                                                                            cellpadding="0"
                                                                                                                            cellspacing="0"
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <tr>
                                                                                                                                <td align="center"
                                                                                                                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                    <a href="#"
                                                                                                                                        style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                        <img src="https://d3k81ch9hvuctc.cloudfront.net/company/H8t5kD/images/a7fcfa9f-5530-467c-8db7-755470e0d8d8.jpeg"
                                                                                                                                            alt=""
                                                                                                                                            width=""
                                                                                                                                            style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%">
                                                                                                                                    </a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <!--<![endif]-->
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:68px; vertical-align: top;"
                                                                                                                        class=" kmDesktopOnly kmDesktopWrapHeaderMobileNone">
                                                                                                                        <table
                                                                                                                            border="0"
                                                                                                                            cellpadding="0"
                                                                                                                            cellspacing="0"
                                                                                                                            class=" kmMobileAutoWidth "
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                    <table
                                                                                                                                        border="0"
                                                                                                                                        cellpadding="0"
                                                                                                                                        cellspacing="0"
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:5px; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                      <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;Arial;font-size:16px;color:#000000;font-weight:normal;letter-spacing:1px;font-size:12px;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##menu1_link##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:16px;text-decoration:none; display: inline-block; padding-top:10px;padding-bottom:10px;padding-left:0px;padding-right:0px;color:#000000;letter-spacing:1px;font-weight:normal;font-size:12px;'>GEMSTONES</a>
                                                                                                                                            </td>

                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:68px; vertical-align: top;"
                                                                                                                        class=" kmDesktopOnly kmDesktopWrapHeaderMobileNone">
                                                                                                                        <table
                                                                                                                            border="0"
                                                                                                                            cellpadding="0"
                                                                                                                            cellspacing="0"
                                                                                                                            class=" kmMobileAutoWidth "
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                    <table
                                                                                                                                        border="0"
                                                                                                                                        cellpadding="0"
                                                                                                                                        cellspacing="0"
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:5px; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>

                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;, Arial;font-size:16px;color:#000000;font-weight:normal;letter-spacing:1px;font-size:12px;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##menu2_link##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92; Arial;font-size:16px;text-decoration:none; display: inline-block; padding-top:10px;padding-bottom:10px;padding-left:0px;padding-right:0px;color:#000000;letter-spacing:1px;font-weight:normal;font-size:12px;'>JEWELLERY</a>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:68px; vertical-align: top;"
                                                                                                                        class=" kmDesktopOnly kmDesktopWrapHeaderMobileNone">
                                                                                                                        <table
                                                                                                                            border="0"
                                                                                                                            cellpadding="0"
                                                                                                                            cellspacing="0"
                                                                                                                            class=" kmMobileAutoWidth "
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                    <table
                                                                                                                                        border="0"
                                                                                                                                        cellpadding="0"
                                                                                                                                        cellspacing="0"
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:5px; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                      <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;font-size:16px;color:#000000;font-weight:normal;letter-spacing:1px;font-size:12px;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##menu3_link##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:16px;text-decoration:none; display: inline-block; padding-top:10px;padding-bottom:10px;padding-left:0px;padding-right:0px;color:#000000;letter-spacing:1px;font-weight:normal;font-size:12px;'>BLOGS</a>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block; vertical-align: top;"
                                                                                                                        class=" kmDesktopOnly kmDesktopWrapHeaderMobileNone">
                                                                                                                        <table
                                                                                                                            border="0"
                                                                                                                            cellpadding="0"
                                                                                                                            cellspacing="0"
                                                                                                                            class=" kmMobileAutoWidth "
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                    <table
                                                                                                                                        border="0"
                                                                                                                                        cellpadding="0"
                                                                                                                                        cellspacing="0"
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:5px; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                         <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;font-size:16px;color:#000000;font-weight:normal;letter-spacing:1px;font-size:12px;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##menu4_link##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:16px;text-decoration:none; display: inline-block; padding-top:10px;padding-bottom:10px;padding-left:0px;padding-right:0px;color:#000000;letter-spacing:1px;font-weight:normal;font-size:12px;'>LOGIN</a>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top"
                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                            <table border="0" cellpadding="0" cellspacing="0" class="templateRow"
                                                width="100%"
                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                <tbody>
                                                    <tr style="background: url('/erp2/public/banners/bg1.jpg');background-size:100% 100%;color:#fff"
                                                        id="center_div">
                                                        <td class="rowContainer kmFloatLeft" valign="top"
                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmImageBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;min-width:100%">
                                                                <tbody class="kmImageBlockOuter">
                                                                    <tr>
                                                                        <td class="kmImageBlockInner"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;padding:0px;padding-right:9;padding-left:9;"
                                                                            valign="top">
                                                                            <table align="left" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                class="kmImageContentContainer"
                                                                                width="100%"
                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;min-width:100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kmImageContent"
                                                                                            valign="top"
                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;padding:0;font-size:0;padding:0;">
                                                                                            <a href="#" target="_self"
                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                <img align="left"
                                                                                                    alt="Shop Now"
                                                                                                    class="kmImage"
                                                                                                    src="/erp2/public/logo/email/gemstones.jpg"
                                                                                                    width="582"
                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;padding-bottom:0;display:inline;vertical-align:top;font-size:12px;width:100%;margin-right:0;max-width:600px;padding:0;border-width:0;height:180px;object-fit:cover">
                                                                                            </a>
                                                                                        </td>

                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                            <div style="display: block;text-align:center;padding:20px">

                                                                {{-- <h4>
                                                                    ##Welcome message##
                                                                </h4> --}}
                                                                <h4>
                                                                    ##order_message##
                                                                </h4>

                                                                <a href="##btn_link##"
                                                                    style="text-decoration:none"><button
                                                                        class="reset btn-gradient-1">

                                                                        View Order <img
                                                                            src="public/logo/gemlab/click.gif" alt=""
                                                                            height="46" width="46"></button></a>


                                                            </div>


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top"
                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                            <table border="0" cellpadding="0" cellspacing="0" class="templateRow"
                                                width="100%"
                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                <tbody>
                                                    <tr>
                                                        <td class="rowContainer kmFloatLeft" valign="top"
                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmButtonBarBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                <tbody class="kmButtonBarOuter">
                                                                    <tr>
                                                                        <td class="kmButtonBarInner" align="center"
                                                                            valign="top"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;padding-top:11px;padding-bottom:9px;padding-left:-19px;padding-right:-7px;">
                                                                            <table border="0" cellpadding="0"
                                                                                cellspacing="0"
                                                                                class="kmButtonBarContentContainer"
                                                                                width="100%"
                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center"
                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                            <table border="0"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0"
                                                                                                class="kmButtonBarContent"
                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;'>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center"
                                                                                                            valign="top"
                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                            <table
                                                                                                                border="0"
                                                                                                                cellpadding="0"
                                                                                                                cellspacing="0"
                                                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td valign="top"
                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                            <table
                                                                                                                                align="left"
                                                                                                                                border="0"
                                                                                                                                cellpadding="0"
                                                                                                                                cellspacing="0"
                                                                                                                                class="" style="
                                                                                                                                border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center"
                                                                                                                                            valign="top"
                                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                                                                            <a href="##facebook_social_link##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/facebook_96.png"
                                                                                                                                                    alt="Button Text"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:48px; max-width:48px; display:block;">
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                            <table
                                                                                                                                align="left"
                                                                                                                                border="0"
                                                                                                                                cellpadding="0"
                                                                                                                                cellspacing="0"
                                                                                                                                class="" style="
                                                                                                                                border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center"
                                                                                                                                            valign="top"
                                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                                                                            <a href="##instagram_social_link##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/instagram_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:48px; max-width:48px; display:block;">
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                            <table
                                                                                                                                align="left"
                                                                                                                                border="0"
                                                                                                                                cellpadding="0"
                                                                                                                                cellspacing="0"
                                                                                                                                class="" style="
                                                                                                                                border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center"
                                                                                                                                            valign="top"
                                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                                                                            <a href="##twitter_social_link##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/twitter_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:48px; max-width:48px; display:block;">
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                            <table
                                                                                                                                align="left"
                                                                                                                                border="0"
                                                                                                                                cellpadding="0"
                                                                                                                                cellspacing="0"
                                                                                                                                class="" style="
                                                                                                                                border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center"
                                                                                                                                            valign="top"
                                                                                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                                                                                            <a href="##youtube_social_link##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/youtube_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:48px; max-width:48px; display:block;">
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmTextBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                <tbody class="kmTextBlockOuter">
                                                                    <tr>
                                                                        <td class="kmTextBlockInner" valign="top"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;">
                                                                            <table align="left" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                class="kmTextContentContainer"
                                                                                width="100%"
                                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="kmTextContent"
                                                                                            valign="top">
                                                                                            <p
                                                                                                style="margin:0;padding-bottom:0;text-align: center;">
                                                                                                <span
                                                                                                    style="font-size:11px;">
                                                                                                    <span
                                                                                                        style='color:rgb(59, 59, 59); letter-spacing: 1px; text-align: center;'>
                                                                                                        <p
                                                                                                            style="text-align: center;">
                                                                                                            <img src="{{ asset('public/logo/gemlab/LOGO.png') }}"
                                                                                                                alt=""
                                                                                                                height="40"
                                                                                                                width="130">
                                                                                                        </p>
                                                                                                        <p style="text-align: center;background:rgb(216, 216, 216);color:rgb(59, 59, 59);padding:10px;font-weight:600;display:block;font-size:.72rem"
                                                                                                            id="footer_cont">

                                                                                                            59-Krishna
                                                                                                            Square 2,
                                                                                                            Amritsar,
                                                                                                            143001 ,
                                                                                                            India
                                                                                                        </p>
                                                                                                    </span>
                                                                                                </span>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>

</body>

</html>
