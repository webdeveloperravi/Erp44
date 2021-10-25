@extends('layouts.front.app')

@section('page_title') User Checkout @endsection
@section('page_description') user check out @endsection
@section('styles')
    <style>
        /***********************************************/
        /***************** Packages ********************/
        /***********************************************/
        @import url('https://fonts.googleapis.com/css?family=Tajawal');
        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

        #subscribeModal .modal-content {
            overflow: hidden;
        }

        #subscribeModal .modal-content form {
            overflow: hidden;



        }

        a.h2 {
            color: #007b5e;
            margin-bottom: 0;
            text-decoration: none;
        }

        #subscribeModal .form-control {
            height: 56px;
            /* border-top-left-radius: 30px;
                                border-bottom-left-radius: 30px; */
            padding-left: 30px;
        }

        #subscribeModal .btn {
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
            padding-right: 20px;
            background: #007b5e;
            border-color: #007b5e;
        }

        #subscribeModal .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #007b5e;
            outline: 0;
            box-shadow: none;
        }



        #subscribeModal .top-strip {
            height: 155px;
            background: #007b5e;
            transform: rotate(141deg);
            margin-top: -106px;
            margin-right: 457px;
            margin-left: -328px;
            border-bottom: 65px solid #4CAF50;
            border-top: 10px solid #4caf50;
        }

        #subscribeModal .bottom-strip {
            height: 155px;
            background: #007b5e;
            transform: rotate(145deg);
            margin-top: -115px;
            margin-right: -694px;
            margin-left: 421px;
            border-bottom: 65px solid #4CAF50;
            border-top: 10px solid #4caf50;
        }

        /****** extra *******/
        #Reloadpage {
            cursor: pointer;
        }

    </style>
@endsection

@section('content')
    <livewire:checkout />

@endsection

@section('scripts')
    <script>
        function getStates(country_id) {

            $.ajax({
                url: "{{ route('9gem_get_states') }}",
                data: {
                    'country_id': country_id
                }
            }).done(function(res) {
                // console.log(res);

                $.each(res, function(index, value) {

                    var option = '<option value=' + index + ' class="option"> ' + value + ' </option>';
                    var li = '<li data-value=' + index + ' class="option"> ' + value + ' </li>';
                    $('#statesSelect').append(option);
                    $('#statesSelect + div > ul').append(li);

                });
                // $(this).addClass("done");
            });
        }



        $('#countrySelect').on('change', function(e) {

            var country_id = e.currentTarget.value;

            getStates(country_id, '9gem_get_states');


        });


        function getCities(state_id) {

            $.ajax({
                url: "{{ route('9gem_get_cities') }}",
                data: {
                    'state_id': state_id
                }
            }).done(function(res) {
                // console.log(res);

                $.each(res, function(index, value) {

                    var option = '<option value=' + index + ' class="option"> ' + value + ' </option>';
                    var li = '<li data-value=' + index + ' class="option"> ' + value + ' </li>';
                    $('#citySelect').append(option);
                    $('#citySelect + div > ul').append(li);
                    $('#townSelect').append(option);
                    $('#townSelect + div > ul').append(li);

                });
                // $(this).addClass("done");
            });
        }

        $('#statesSelect').on('change', function(e) {

            var state_id = e.currentTarget.value;

            getCities(state_id);


        });
        // get-country-states
    </script>

    <script>
        //modal
        function addnewAddressModal() {
            $('#subscribeModal').modal('show');
        }
    </script>
@endsection
