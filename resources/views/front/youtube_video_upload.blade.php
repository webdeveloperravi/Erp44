<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>upload youtube video</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

    <style>
        .dropdown:focus-within .dropdown-menu {
            opacity: 1;
            transform: translate(0) scale(1);
            visibility: visible;
        }

        body {
            font-family: sans-serif;
            background-color: #eeeeee;
        }

        .file-upload {
            background-color: #ffffff;
            width: 100%;
            margin: 0 auto;
            /* padding: 20px; */
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: rgb(35, 35, 35);
            background: rgba(191, 219, 254, var(--tw-bg-opacity));
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 2px solid #000;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: rgb(156, 199, 252);
            color: #fff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 2px dashed rgb(136, 190, 213);
            position: relative;
        }



        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #15824B;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        .top-100 {
            top: 100%
        }

        .bottom-100 {
            bottom: 100%
        }

        .max-h-select {
            max-height: 300px;
        }



        .form {

            /* padding: 25px; */
            margin: 1em auto;
            border-radius: 3px;

        }

        label {
            display: block;
        }



        .ui-tagify-wrap {
            border-radius: 3px;
            border: 1.5px solid rgba(59, 130, 246, 0.5);
            height: 75px;
            overflow: auto;

        }

        .ui-tagify-tag {
            background: #dddddd;
            display: inline-block;
            padding: 2px 5px;
            margin: 2px;
            border-radius: 2px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .5);
        }

        .ui-tagify-selected {
            background: #5A9C54;
        }

        .ui-tagify-input {
            padding: 4px 3px;
            border: none;
            outline: none;
        }

        .ui-tagify-remove {
            text-decoration: none;
            font-size: 12px;
            background: rgba(0, 0, 0, 0.15);
            padding: 1px 3px 2px 4px;
            color: rgba(255, 255, 255, .5);
            float: right;
            margin: 2px 0 2px 4px;
            line-height: 1;
            border-radius: 50%;
            font-weight: bold;
        }

        .ui-tagify-remove:hover {
            background: rgba(0, 0, 0, .3);
        }

        .overscrollcat::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 5px;
            background: rgb(221, 221, 221);
        }

        .overscrollcat::-webkit-scrollbar-thumb {
            width: 2px;
            background: rgba(59, 130, 246, 0.5);
        }

        @media(max-width:425px) {
            html {
                font-size: 12px;
            }
        }

    </style>
</head>
</head>

<body>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .overscrollcat::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 5px;
            background: rgb(221, 221, 221);
        }

        .overscrollcat::-webkit-scrollbar-thumb {
            width: 2px;
            background: rgba(59, 130, 246, 0.5);
        }


        .dropdown:focus-within .dropdown-menu {
            opacity: 1;
            transform: translate(0) scale(1);
            visibility: visible;
        }

        body {
            font-family: sans-serif;
            background-color: #eeeeee;
        }

        .file-upload {
            background-color: #ffffff;
            width: 100%;
            margin: 0 auto;
            /* padding: 20px; */
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: rgb(35, 35, 35);
            background: rgba(191, 219, 254, var(--tw-bg-opacity));
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 2px solid #000;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: rgb(156, 199, 252);
            color: #fff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 2px dashed rgb(136, 190, 213);
            position: relative;
        }



        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #15824B;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        .top-100 {
            top: 100%
        }

        .bottom-100 {
            bottom: 100%
        }

        .max-h-select {
            max-height: 300px;
        }



        .form {

            /* padding: 25px; */
            margin: 1em auto;
            border-radius: 3px;

        }

        label {
            display: block;
        }



        .ui-tagify-wrap {
            border-radius: 3px;
            border: 1.5px solid rgba(59, 130, 246, 0.5);
            height: 75px;
            overflow: auto;

        }

        .ui-tagify-tag {
            background: #dddddd;
            display: inline-block;
            padding: 2px 5px;
            margin: 2px;
            border-radius: 2px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .5);
        }

        .ui-tagify-selected {
            background: #5A9C54;
        }

        .ui-tagify-input {
            padding: 4px 3px;
            border: none;
            outline: none;
        }

        .ui-tagify-remove {
            text-decoration: none;
            font-size: 12px;
            background: rgba(0, 0, 0, 0.15);
            padding: 1px 3px 2px 4px;
            color: rgba(255, 255, 255, .5);
            float: right;
            margin: 2px 0 2px 4px;
            line-height: 1;
            border-radius: 50%;
            font-weight: bold;
        }

        .ui-tagify-remove:hover {
            background: rgba(0, 0, 0, .3);
        }

        @media(max-width:425px) {
            html {
                font-size: 12px;
            }
        }

    </style>

    <div>


        <div class="relative min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 bg-gray-500 bg-no-repeat bg-cover relative items-center"
            style="background-image: url(https://images.unsplash.com/photo-1621243804936-775306a8f2e3?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80);">
            <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            <div class="sm:max-w-lg w-full p-10 bg-white rounded-xl z-10">
                <div class="text-center">
                    @if (session('message'))
                        <div class="flex max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="w-2 bg-gray-800"></div>
                            <div class="flex items-center px-2 py-3 w-full">
                                <div class="mx-3 text- w-full">
                                    <h2 class="text-xl font-semibold text-gray-800 block w-full">
                                        {{ session('message') }}</h2>
                                    <a href="{{ route('9gem_admin_account') }}" class="text-blue-500 block w-full">See
                                        all Videos</a>.
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <h2 class="mt-5 text-3xl font-bold text-gray-900">
                            Upload Video!
                        </h2>
                        <p class="mt-2 text-sm text-gray-400"><b>Note:</b> Selected file will be upload on your youtube
                            official
                            channel.
                        </p>

                    </div>

                </div>
                <form class="mt-8 space-y-3" action="{{ route('9gem_google_drive_upload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 space-y-2 pb-2" x-data="">
                        <label class="tracking-wide">
                            <h2 class="text-xl">Title : </h2>
                        </label>
                        <input
                            class="text-base p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:ring-2"
                            value="{{ old('title') }}" type="" placeholder="video title" name="title"
                            x-ref="title_ref" @load.window="
                                    $refs.title_ref.focus();
                                ">
                        <div>
                            @error('title')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <hr />
                    <!--start-->
                    <div class="relative inline-block text-left w-full" x-data={isOpen:false,cat_val:"",cat_id:""}
                        x-init="cat_val = 'Video categories'">
                        <div @click="isOpen = !isOpen">
                            <label class=" tracking-wide">
                                <h2 class="text-xl mb-2">Select a category : </h2>
                            </label>
                            <button type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
                                id="menu-button" aria-expanded="true" aria-haspopup="true" x-text="cat_val">
                                video categories
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" name="videocat" id="videocat" x-model="cat_id">

                        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 max-h-50 overflow-auto "
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                            x-show="isOpen">


                            <div class="py-1 max-h-50 overflow-auto overscrollcat" role="none"
                                style="max-height: 200px;">

                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                @foreach (session('cats') as $cat)

                                    <a href="#"
                                        class="text-gray-700 block px-4 py-2 text-sm border hover:border hover:border-blue-500"
                                        id="menu-item-0"
                                        @click.prevent='cat_id = {{ $cat['id'] }};cat_val = "{{ $cat['snippet']['title'] }}" ;isOpen = false'
                                        x-ref="cat_{{ $cat['id'] }}">{{ $cat['snippet']['title'] }}</a>
                                @endforeach


                            </div>



                        </div>
                        <div>
                            @error('videocat')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <!--ends-->
                    <hr>


                    <div class="grid grid-cols-1 space-y-2 pb-4">
                        <label class=" tracking-wide">
                            <h2 class="text-xl">Description : </h2>
                        </label>
                        <textarea name="description" id="description" rows="5"
                            class="border  border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:ring-2 p-2 resize-none"
                            maxlength="255" placeholder="type a description..."
                            value="">{{ old('description') }}</textarea>
                        <div>
                            @error('description')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <hr />

                    <div class="file-upload w-full pb-2 pt-2">
                        <h5 id="filemessage" class="text-red-500"></h5>
                        <button class="file-upload-btn" type="button"
                            onclick="$('.file-upload-input').trigger( 'click' )">Browse video file</button>
                        <p class="my-2 text-center text-gray-500">or</p>
                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' onchange="readURL(this);" accept="video/*"
                                name="video" />

                            <div class="drag-text">
                                <h3 class="text-black" style="color:#000">Drag and drop a Video file </h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="uploaded video thumbnail" />
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">Remove <span
                                        class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <div>
                            @error('video')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <hr />
                    <!--tags-->
                    <div class="form w-full pt-4 rounded-lg pb-2 pt-2">
                        <label class="rounded-lg">
                            <h2 class="text-xl pb-2">Enter tags (separated by commas): </h2><input type="text"
                                class="tagify" />
                        </label>
                        <input type="hidden" id="vtags" name="vtags">
                        <div>
                            @error('vtags')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <hr />
                    <div class="pb-2 pt-2">
                        <div class="flex">
                            <h4 class="text-xl mr-4">Privacy :</h4>
                            <div class="flex ">
                                @if (old('privacy'))
                                    @if (old('privacy') == 'private')
                                        <div class="w-50 mr-4">
                                            <label class="text-lg capitalize tracking-wide text-gray-600 inline-block"
                                                for="private">private</label>
                                            <input type="radio" id="private" name="privacy" class="inline-block"
                                                value="private" checked>
                                        </div>
                                        <div class="w-50">
                                            <label class=" capitalize tracking-wide text-lg text-gray-600 inline-block"
                                                for="public">public</label>
                                            <input type="radio" id="public" name="privacy" class="inline-block"
                                                value="public">
                                        </div>

                                    @else
                                        <div class="w-50 mr-4">
                                            <label class="text-lg capitalize tracking-wide text-gray-600 inline-block"
                                                for="private">private</label>
                                            <input type="radio" id="private" name="privacy" class="inline-block"
                                                value="private">
                                        </div>
                                        <div class="w-50">
                                            <label class=" capitalize tracking-wide text-lg text-gray-600 inline-block"
                                                for="public">public</label>
                                            <input type="radio" id="public" name="privacy" class="inline-block"
                                                value="public" checked>
                                        </div>

                                    @endif

                                @else
                                    <div class="w-50 mr-4">
                                        <label class="text-lg capitalize tracking-wide text-gray-600 inline-block"
                                            for="private">private</label>
                                        <input type="radio" id="private" name="privacy" class="inline-block"
                                            value="private">
                                    </div>
                                    <div class="w-50">
                                        <label class=" capitalize tracking-wide text-lg text-gray-600 inline-block"
                                            for="public">public</label>
                                        <input type="radio" id="public" name="privacy" class="inline-block"
                                            value="public" checked>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            @error('privacy')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    <button
                        class="w-full border border-black block box-border p-4 uppercase hover:bg-black hover:text-white outline-none duration-500 transition bg-blue-200 rounded "
                        type="submit">
                        Upload
                    </button>

                </form>


                <script>
                    function readURL(input) {

                        if (input.files && input.files[0]) {
                            let upload_flag;
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $('.image-upload-wrap').hide();

                                $('.file-upload-image').attr('src', e.target.result);
                                $('.file-upload-content').show();
                                $('.image-title').html(input.files[0].name);


                            };


                            let fname = input.files[0].name;
                            let farr = fname.split(".");
                            let upload_file_ext = farr[1];
                            const allowedext = ['mp4', '3GPP', 'AVI', 'FLV', 'MOV', 'MPEG4', 'MPEGPS', 'WebM', 'WMV'];
                            // console.log(allowedext.indexOf(upload_file_ext));

                            if (allowedext.indexOf(upload_file_ext) != '-1') {
                                reader.readAsDataURL(input.files[0]);
                            } else {
                                $('#filemessage').text('please select a valid file!!!');
                            }



                        } else {
                            removeUpload();
                        }
                    }

                    function removeUpload() {
                        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
                        $('.file-upload-content').hide();
                        $('.image-upload-wrap').show();
                    }
                    $('.image-upload-wrap').bind('dragover', function() {
                        $('.image-upload-wrap').addClass('image-dropping');
                    });
                    $('.image-upload-wrap').bind('dragleave', function() {
                        $('.image-upload-wrap').removeClass('image-dropping');
                    });
                </script>
                <script>
                    let tagsArr = [];
                    //tags
                    (function($) {
                        $.fn.tagify = function() {
                            $('body').on('click', '.ui-tagify-remove', function() {
                                $(this).parent().remove();
                            });

                            var wrap = document.createElement('div'),
                                delimeters = [44], // comma
                                length = delimeters.length,
                                i = 0;
                            $(wrap).addClass('ui-tagify-wrap').click(function() {
                                this.focus();
                            });
                            this.css('display', 'inline-block')
                                .css('width', '100px')
                                .wrap(wrap)
                                .addClass('ui-tagify-input')
                                .bind('keypress', function(event) {
                                    var charCode = event.which || event.keyCode,
                                        charStr, tagContent;
                                    for (i = 0; i < length; i++) {
                                        if (delimeters[i] === charCode) {
                                            charStr = String.fromCharCode(charCode);
                                            tagContent = $(this).val().split(charStr)[0].trim();



                                            tagsArr.push(tagContent);
                                            $('#vtags').val(tagsArr);


                                            if (0 < tagContent.length) {
                                                $(this).before('<div class="ui-tagify-tag">' + tagContent +
                                                    '<a href="#" class="ui-tagify-remove">⨉</a></div>').val('');
                                            }
                                            event.preventDefault();
                                            break;
                                        }
                                    }
                                })
                                .bind('keydown', function(event) {
                                    var charCode = event.which || event.keyCode;
                                    if (charCode === 8 && 0 === $(this).val().length) {
                                        if ($('.ui-tagify-selected').length) {
                                            $('.ui-tagify-selected').remove();
                                        } else if ($(this).prev().length) {
                                            $(this).prev().addClass('ui-tagify-selected');
                                        }
                                    }
                                });
                            // returns the div wrapper, does this make the most sense?
                            return this.parent();
                        };
                    })(jQuery);

                    $('.tagify').tagify();
                </script>

            </div>




</body>

</html>
