<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
    <!-- tailwind style css -->
    <link rel="stylesheet" href="{{ asset('public/front/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front/css/custom.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/front/assets/front/texteditor_rich/richtexteditor/rte_theme_default.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <style>
        .ui-tagify-wrap {
            width: 100%;
            flex-wrap: wrap;
        }

        .ui-tagify-tag {
            margin-bottom: 10px !important;
        }



        a[href='https://richtexteditor.com/?go=RTE'] {
            color: green;
        }

    </style>

</head>

<body>

    <header class="text-gray-600 body-font">
        <div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800">
            <div x-data="{ open: false }"
                class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8 ">
                <div class="p-4 flex flex-row items-center justify-between">
                    <a href="{{ route('9gem_user_account') }}"
                        class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
                        <img src="{{ asset('public/front/icons/diamond.png') }}" alt="gemstore" height="40"
                            width="40">
                    </a>
                    <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                            <path x-show="!open" fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                            <path x-show="open" fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <nav :class="{'flex': open, 'hidden': !open}"
                    class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
                    <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                        href="{{ route('9gemhome') }}">Home</a>


                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class=" md:hidden flex justify-start flex-row  items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                            <span>Dropdown</span>
                            <svg fill="currentColor" viewBox="0 0 20 20"
                                :class="{'rotate-180': open, 'rotate-0': !open}"
                                class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                <form method="POST" action="{{ route('9gem_blog_update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <ul class="flex flex-col w-full">
                                        <li class="bg-white my-2 shadow-lg" x-data="accordion(1)">
                                            <h2 @click="handleClick()"
                                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                                <span>Tags:</span>
                                                <svg :class="handleRotate()"
                                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                                    </path>
                                                </svg>
                                            </h2>
                                            <div x-ref="tab" :style="handleToggle()"
                                                class="border-l-2 border-purple-600 overflow-hidden max-h-0 duration-500 transition-all">
                                                <!--tags-->
                                                <div class="form w-full rounded-lg pl-2">
                                                    <label class="rounded-lg">
                                                        <h2 class="text-xl pb-2"><small>Enter tags :</small> </h2><input
                                                            type="text" class="tagify" />
                                                    </label>
                                                    <input type="hidden" id="vtags_m" name="tags">
                                                    <div>
                                                        @error('tags')
                                                            <small class="text-red-500">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </li>


                                        <li class="bg-white my-2 shadow-lg" x-data="accordion(2)">

                                            <h2 @click="handleClick()"
                                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                                <span>Permalink</span>
                                                <svg :class="handleRotate()"
                                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                                    </path>
                                                </svg>
                                            </h2>
                                            <div class="border-l-2 border-purple-600 overflow-scroll max-h-0 duration-500 transition-all scroll_modify"
                                                x-ref="tab" :style="handleToggle()">
                                                <h5 class="text-md w-full">
                                                    {{ $post['permalink'] }}
                                                    <input type="hidden" value="{{ $post['permalink'] }}"
                                                        name="permalink">
                                                    <input type="hidden" value="{{ $post['slug'] }}" name="slug">
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="bg-white my-2 shadow-lg" x-data="accordion(3)">

                                            <h2 @click="handleClick()"
                                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                                <span>Featured image</span>
                                                <svg :class="handleRotate()"
                                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                                    </path>
                                                </svg>
                                            </h2>
                                            <div class="border-l-2 border-purple-600 overflow-scroll max-h-0 duration-500 transition-all scroll_modify "
                                                x-ref="tab" :style="handleToggle()">
                                                <h5 class="text-md w-full overflow-wrap">
                                                    <input type="file" value="" name="f_img_m">
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="bg-white my-2 shadow-lg" x-data="accordion(4)">
                                            <h2 @click="handleClick()"
                                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                                <span>Comments</span>
                                                <svg :class="handleRotate()"
                                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                                    </path>
                                                </svg>
                                            </h2>
                                            <div class="border-l-2 border-purple-600 overflow-hidden max-h-0 duration-500 transition-all"
                                                x-ref="tab" :style="handleToggle()">
                                                <div class="p-2">
                                                    <label for="">Allow Comments</label>

                                                    <input type="radio" id="allow_comment_m" name="allow_comment"
                                                        value="1" checked>
                                                </div>
                                                <hr>
                                                <div class="p-2">
                                                    <label for="">Disallow Comments</label>
                                                    <input type="radio" id="disallow_comment_mf_img"
                                                        name="allow_comment" value="0">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white my-2 shadow-lg">
                                            @php
                                                $cats = getProductCategories();
                                                
                                            @endphp
                                            <h2
                                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                                Category
                                            </h2>
                                            <div class="border-l-2 border-purple-600  duration-500 transition-all ">
                                                <select name="category_id" id="category_m">
                                                    @foreach ($cats as $cat)

                                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}
                                                        </option>

                                                    @endforeach
                                                </select>
                                            </div>

                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="main mt-10">
        <div id="create_blog_container">
            <div class="head">
                <h1 class="text-5xl text-center capitalize" style="color:#c29958"> Edit blog</h1>
                <hr class="w-25 mx-auto mt-4 bg-black-600">
            </div>
            <div class="flex">
                <div class="py-12 md:w-5/6 w-full">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white  shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <form method="POST" action="{{ route('9gem_blog_update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">

                                        <label class="text-xl text-gray-600">Title <span
                                                class="text-red-500">*</span></label></br>
                                        <input name="title" id="title" type="text"
                                            class="ring-1 ring-gray-300  w-full  p-4 text-2xl font-semibold rounded focus:ring-2 focus:ring-blue-500"
                                            value="{{ $post['title'] }}" required>

                                        <input name="postid" id="postid" type="hidden" value="{{ $post['id'] }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-xl text-gray-600">Description</label></br>
                                        <textarea name="description" id="description" rows="5"
                                            class=" ring-1 ring-gray-300 focus:ring-2 focus:ring-blue-500 rounded p-2 w-full"
                                            placeholder="write a description here..."
                                            maxlength="200">{{ $post['description'] }}</textarea>

                                    </div>

                                    <div class="topbanner">
                                        <div style="align-self:stretch;width:960px;display:flex; flex-direction: row;">
                                            <div style="flex:99999">
                                                <h2 class="text-xl">Block</h2>
                                            </div>

                                        </div>
                                    </div>
                                    <div style="margin:auto;padding:12px 6px 36px;max-width:960px;">


                                        <div class="hs-docs-content-divider" id="editor_container">



                                            <script type="text/javascript" src="{{ asset('public/front/assets/front/texteditor_rich/richtexteditor/rte.js') }}">
                                            </script>
                                            <script>
                                                RTE_DefaultConfig.url_base = 'richtexteditor'
                                            </script>
                                            <script type="text/javascript"
                                                                                        src="{{ asset('public/front/assets/front/texteditor_rich/richtexteditor/plugins/all_plugins.js') }}">
                                            </script>
                                            <textarea id="div_editor1" style="width:100%"
                                                name="content">{{ $post['content'] }}</textarea>

                                            <script>
                                                var editor1 = new RichTextEditor("#div_editor1");
                                            </script>

                                        </div>

                                    </div>



                                    <div class=" block p-1">
                                        <select class="border-2 border-gray-300 border-relative z-50 w-50 p-2"
                                            name="action">
                                            <option class="relative z-50">Update and Publish</option>
                                            <option class="relative z-50">Update and make Draft</option>
                                            <option class="relative z-50">Update</option>
                                        </select>
                                        <button type="submit"
                                            class="pl-10 pr-10 rounded bg-blue-500 text-white hover:bg-blue-400 mt-5 p-2 w-full ">Save
                                            Changes</button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-1/6 hidden md:block text-left">
                    <h3 class="text-xl text-center font-bold">Settings</h3>

                    <ul class="flex flex-col">
                        <li class="bg-white my-2 shadow-lg" x-data="accordion(1)">
                            <h2 @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>Tags:</span>
                                <svg :class="handleRotate()"
                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
                            </h2>
                            <div x-ref="tab" :style="handleToggle()"
                                class="border-l-2 border-purple-600 overflow-auto  max-h-0 duration-500 transition-all scroll_modify">
                                <!--tags-->
                                <div class="form w-full rounded-lg pl-2">
                                    <label class="rounded-lg">
                                        <h2 class="text-xl pb-2"><small>Enter tags :</small> </h2><input type="text"
                                            class="tagify w-full" value="" style="width: 100%;height: 80px;" />
                                    </label>
                                    <input type="text" id="vtags" name="tags" value="{{ $post['tags'] }}">
                                    <div>
                                        @error('tags')
                                            <small class="text-red-500">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li class="bg-white my-2 shadow-lg" x-data="accordion(5)">

                            <h2 @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>Permalink</span>
                                <svg :class="handleRotate()"
                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
                            </h2>
                            <div class="border-l-2 border-purple-600 overflow-scroll max-h-0 duration-500 transition-all scroll_modify "
                                x-ref="tab" :style="handleToggle()">
                                <h5 class="text-md w-full overflow-wrap">
                                    {{ $post['permalink'] }}
                                    <input type="hidden" value="{{ $post['permalink'] }}" name="permalink">
                                    <input type="hidden" value="{{ $post['slug'] }}" name="slug">
                                </h5>
                            </div>
                        </li>
                        <li class="bg-white my-2 shadow-lg" x-data="accordion(6)">

                            <h2 @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>Featured image</span>

                                <svg :class="handleRotate()"
                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
                            </h2>

                            <div class="border-l-2 border-purple-600 overflow-scroll max-h-0 duration-500 transition-all scroll_modify "
                                x-ref="tab" :style="handleToggle()">
                                <h5 class="text-md w-full overflow-wrap">
                                    <input type="file" value="" name="f_img">
                                    <img src="{{ asset('public/storage/blog_featured_imgs/' . $post['featured_img']) }}"
                                        alt="9gem.com" style="width: 100%;object-fit:cover">
                                </h5>
                            </div>
                        </li>
                        <li class="bg-white my-2 shadow-lg" x-data="accordion(7)">
                            <h2 @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>Comments</span>
                                <svg :class="handleRotate()"
                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
                            </h2>
                            <div class="border-l-2 border-purple-600 overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab" :style="handleToggle()">
                                <div class="p-2">
                                    <label for="">Allow Comments</label>
                                    @if ($post['allow_comment'] == 1)
                                        <input type="radio" id="allow_comment" name="allow_comment" value="1" checked>
                                    @else
                                        <input type="radio" id="allow_comment" name="allow_comment" value="1">
                                    @endif
                                </div>
                                <hr>
                                <div class="p-2">
                                    <label for="">Disallow Comments</label>
                                    @if ($post['allow_comment'] == 0)
                                        <input type="radio" id="disallow_comment" name="allow_comment" value="0"
                                            checked>
                                    @else
                                        <input type="radio" id="disallow_comment" name="allow_comment" value="0">
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="bg-white my-2 shadow-lg">
                            @php
                                $cats = getProductCategories();
                                
                            @endphp
                            <h2 class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                Category
                            </h2>
                            <div class="border-l-2 border-purple-600  duration-500 transition-all ">
                                <select name="category_id" id="category" class="w-full">
                                    @foreach ($cats as $cat)
                                        <option value="{{ $cat['id'] }}"
                                            {{ $post['category_id'] == $cat['id'] ? 'selected' : '' }}>
                                            {{ $cat['name'] }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>

                        </li>
                    </ul>
                    </form>
                </div>
            </div>


        </div>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/spruce@1.1.0/dist/spruce.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js"></script>
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="{{ asset('public/front/assets/front/texteditor_rich/res/patch.js') }}"></script>

    <script>
        Spruce.store('accordion', {
            tab: 0,
        });

        const accordion = (idx) => ({
            handleClick() {
                this.$store.accordion.tab = this.$store.accordion.tab === idx ? 0 : idx;
            },
            handleRotate() {
                return this.$store.accordion.tab === idx ? 'rotate-180' : '';
            },
            handleToggle() {
                return this.$store.accordion.tab === idx ? `max-height: ${this.$refs.tab.scrollHeight}px` : '';
            }
        });
    </script>

    <script>
        CKEDITOR.replace('content');
    </script>
    <script>
        let tagsArr = [];
        //tags
        (function($) {
            $.fn.tagify = function() {
                $('body').on('click', '.ui-tagify-remove', function() {
                    $(this).parent().remove();
                    tagsArr.pop();
                    $('#vtags').val(tagsArr);
                });

                var wrap = document.createElement('div'),
                    delimeters = [44], // comma
                    length = delimeters.length,
                    i = 0;
                $(wrap).addClass('ui-tagify-wrap').click(function() {
                    this.focus();
                });
                this.css('display', 'inline-block')
                    .css('width', '100%')
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
    <script>
        var texteditor = document.querySelectorAll('.richtexteditor')[0];

        texteditor.style.width = "100%";
    </script>
    <script>
