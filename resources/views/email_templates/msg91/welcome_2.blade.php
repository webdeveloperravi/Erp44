<section>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <style>
        * {
            letter-spacing: 0.0938rem
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
            height: 0.375rem;
            background-image: url('##UNDERLINE_STRIP_IMG_SRC##');
            background-size: 100% 100%;

        }

        #footer_cont {
            position: relative;
            display: block;
        }

        #footer_cont::before {
            position: absolute;
            content: '';
            top: -0.375rem;
            right: 0;
            width: 20%;
            height: 0.375rem;
            background-image: url('##UNDERLINE_STRIP_IMG_SRC##');
            background-size: 100% 100%;
        }

        .btn-gradient-1 {


            background: #90a0af;
            border: 0.125rem solid rgb(248, 15, 54);
            position: relative;
            width: 13.75rem;
            height: 3.125rem;
            padding-left: 0.625rem;
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: color .2s;
            transition: .5s;
            text-transform: uppercase;
            font-weight: 750;
            font-size: .85rem;
            box-shadow: 5px 5px 12px rgba(250, 176, 179, 0.829);
            overflow: hidden;
            color: #151414e5;
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

        #msg_body::first-letter {
            color: rgb(223, 56, 56);
            font-size: 1.2rem;
        }

    </style>
    <center>
        <table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable" width="100%"
            data-upload-file-url="/ajax/email-editor/file/upload"
            data-upload-files-url="/ajax/email-editor/files/upload"
            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:auto;padding:0;background-color:#FFF;height:100%;margin:0;width:100%;margin:0;padding:0;background-color:#FFF;font-family: 'Montserrat', sans-serif;">
            <tbody>
                <tr>
                    <td align="center" id="bodyCell" valign="top"
                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:auto;padding-top:3.125rem;padding-left:1.25rem;padding-bottom:0.625rem;padding-right:1.25rem;border-top:0;height:100%;margin:0;width:100%">
                        <div class="templateContainer"
                            style="border:0 none #aaa;background-color:#fff;border-radius:0;display: table; width:37.5rem">
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
                                                                                            style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:#222;font-size:0.875rem;line-height:1.3;letter-spacing:0;text-align:left;max-width:100%;word-wrap:break-word;color:#666666;padding-bottom:0.3125rem;text-align:center;padding-right:0rem;padding-left:0rem;padding-top:0rem;'>
                                                                                            <p style="margin:0;padding:0.3125rem;background:rgb(216 216 216 / 38%);"
                                                                                                id="header_org">
                                                                                                <span><a href="##ORG_LOGO_LINK##"
                                                                                                        style="color:rgb(59, 59, 59);text-decoration:none;font-size:2rem">
                                                                                                        ##ORG_NAME##
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
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;min-width:3.75rem;background-color:#FFFFFF;padding-left:18;padding-right:18;">
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
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:4.25rem; vertical-align: top;"
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
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:0.3125rem; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                      <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;Arial;font-size:1rem;color:#000000;font-weight:normal;letter-spacing:0.0625rem;font-size:0.75rem;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##MENU1_LINK##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:1rem;text-decoration:none; display: inline-block; padding-top:0.625rem;padding-bottom:0.625rem;padding-left:0rem;padding-right:0rem;color:#000000;letter-spacing:0.0625rem;font-weight:normal;font-size:0.75rem;'>##MENU1_TEXT##</a>
                                                                                                                                            </td>

                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:4.25rem; vertical-align: top;"
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
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:0.3125rem; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>

                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;, Arial;font-size:1rem;color:#000000;font-weight:normal;letter-spacing:0.0625rem;font-size:0.75rem;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##MENU2_LINK##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92; Arial;font-size:1rem;text-decoration:none; display: inline-block; padding-top:0.625rem;padding-bottom:0.625rem;padding-left:0rem;padding-right:0rem;color:#000000;letter-spacing:0.0625rem;font-weight:normal;font-size:0.75rem;'>##MENU2_TEXT##</a>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td valign="middle"
                                                                                                                        align="center"
                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;display:inline-block;padding-right:4.25rem; vertical-align: top;"
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
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:0.3125rem; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                      <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;font-size:1rem;color:#000000;font-weight:normal;letter-spacing:0.0625rem;font-size:0.75rem;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##MENU3_LINK##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:1rem;text-decoration:none; display: inline-block; padding-top:0.625rem;padding-bottom:0.625rem;padding-left:0rem;padding-right:0rem;color:#000000;letter-spacing:0.0625rem;font-weight:normal;font-size:0.75rem;'>##MENU3_TEXT##</a>
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
                                                                                                                                        style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;border-collapse:separate; border-radius:0.3125rem; background-color:#FFFFFF; "
                                                                                                                                        class=" kmMobileAutoWidth ">
                                                                                                                                        <tr>
                                                                                                                                            <!--[if !mso]>
                                                                                                         <!-->
                                                                                                                                            <td align="center"
                                                                                                                                                valign="middle"
                                                                                                                                                class="kmButtonContent"
                                                                                                                                                style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;color:white;font-size:1rem;color:#000000;font-weight:normal;letter-spacing:0.0625rem;font-size:0.75rem;'>
                                                                                                                                                <a class="kmButton"
                                                                                                                                                    title=""
                                                                                                                                                    href="##MENU4_LINK##"
                                                                                                                                                    target="_self"
                                                                                                                                                    style='word-wrap:break-word;max-width:100%;font-weight:normal;line-height:100%;text-align:center;text-decoration:underline;color:#F98E92;font-size:1rem;text-decoration:none; display: inline-block; padding-top:0.625rem;padding-bottom:0.625rem;padding-left:0rem;padding-right:0rem;color:#000000;letter-spacing:0.0625rem;font-weight:normal;font-size:0.75rem;'>##MENU4_TEXT##</a>
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
                                                    <tr style="background: url('##BACKGROUND_IMAGE_SRC##');background-size:100% 100%;color:#000;height:21.875rem"
                                                        id="center_div">
                                                        <td class="rowContainer kmFloatLeft" valign="top"
                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                class="kmImageBlock" width="100%"
                                                                style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;min-width:100%">
                                                                <tbody class="kmImageBlockOuter">
                                                                    <tr>
                                                                        <td class="kmImageBlockInner"
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;padding:0rem;padding-right:9;padding-left:9;"
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
                                                                                            <a href="##BANNER_LINK##"
                                                                                                target="_self"
                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                <img align="left"
                                                                                                    alt="Shop Now"
                                                                                                    class="kmImage"
                                                                                                    src="##BANNER_IMAGE_SRC##"
                                                                                                    width="582"
                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;padding-bottom:0;display:inline;vertical-align:top;font-size:0.75rem;width:100%;margin-right:0;max-width:37.5rem;padding:0;border-width:0;height:11.25rem;object-fit:cover">
                                                                                            </a>
                                                                                        </td>

                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                            <div
                                                                style="display: block;text-align:center;padding:1.25rem;color:#000000c7">

                                                                <h2 style="font-weight: 900" id="msg_subject">

                                                                    ##MSG_SUBJECT##
                                                                </h2>
                                                                <h4>

                                                                </h4>
                                                                <a href="##BTN_LINK##"
                                                                    style="text-decoration:none"><button
                                                                        class="reset btn-gradient-1">

                                                                        ##BTN_TXT## <img src="##CLICK_GIF_SRC##" alt=""
                                                                            height="46" width="46"></button>
                                                                </a>


                                                                <h4 id="msg_body">
                                                                    ##MSG_BODY##

                                                                </h4>



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
                                                                            style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;padding-top:0.6875rem;padding-bottom:0.5625rem;padding-left:-1.1875rem;padding-right:-0.4375rem;">
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
                                                                                                                                            <a href="##FB_SOCIAL_LINK##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/facebook_96.png"
                                                                                                                                                    alt="Button Text"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:3rem; max-width:3rem; display:block;">
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
                                                                                                                                            <a href="##INSTAGRAM_SOCIAL_LINK##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/instagram_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:3rem; max-width:3rem; display:block;">
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
                                                                                                                                            <a href="##TWITTER_SOCIAL_LINK##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/twitter_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:3rem; max-width:3rem; display:block;">
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
                                                                                                                                            <a href="##YOUTUBE_SOCIAL_LINK##"
                                                                                                                                                target="_blank"
                                                                                                                                                style="word-wrap:break-word;max-width:100%;color:#F98E92;font-weight:normal;text-decoration:underline">
                                                                                                                                                <img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/youtube_96.png"
                                                                                                                                                    alt="Custom"
                                                                                                                                                    class="kmButtonBlockIcon"
                                                                                                                                                    width="48"
                                                                                                                                                    style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;max-width:100%;width:3rem; max-width:3rem; display:block;">
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
                                                                                                    style="font-size:0.6875rem;">
                                                                                                    <span
                                                                                                        style='color:rgb(59, 59, 59); letter-spacing: 0.0625rem; text-align: center;'>
                                                                                                        <p
                                                                                                            style="text-align: center;">
                                                                                                            <a
                                                                                                                href="##ORG_LOGO_LINK##">
                                                                                                                <img src="##ORG_LOGO_SRC##"
                                                                                                                    alt=""
                                                                                                                    height="40"
                                                                                                                    width="130">
                                                                                                            </a>
                                                                                                        </p>
                                                                                                        <p style="text-align: center;background:rgb(216 216 216 / 38%);color:rgb(59, 59, 59);padding:0.625rem;font-weight:600;display:block;font-size:.72rem"
                                                                                                            id="footer_cont">


                                                                                                            ##ORG_ADDRESS##
                                                                                                            <br>
                                                                                                            FOR QUERIES:
                                                                                                            ##CONTACT_NUMS##
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

</section>
