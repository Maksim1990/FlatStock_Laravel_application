@extends('layouts.admin')
@section('styles')
    {{--<link href="{{asset('css/jquery.bxslider.css')}}" rel="stylesheet">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        .form-group{
            height: 80px;
        }
        .form-group-image{
            height: 90px;
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-12  col-xs-12" id="item_block">
        <div class="col-sm-10 col-sm-offset-2  col-xs-12">
            <div id="create_apartment">
                <div class="col-sm-12  col-lg-12">
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" class="form-control" id="country">
                                @foreach($arrCountries as $key=>$item)
                                    <option value="{{$key}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                            <span id="country_alert"></span>
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" placeholder="Type city here">
                            <span id="city_alert"></span>
                        </div>
                        <div class="form-group">
                            <a href="#" data-toggle="modal" data-target="#apartmentLocation" title="Apartment location"
                               class="btn btn-default btn-small" id="buttonLocation">Chose location on the map</a>
                            <p id="locationResult"></p>
                            <span id="location_alert"></span>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12  col-lg-12">
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" value="" placeholder="Street">
                            <span id="street_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="house">House №</label>
                            <input type="number" min="1" class="form-control" id="house" value="" placeholder="House №">
                            <span id="house_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="room">Room №</label>
                            <input type="number" min="1" class="form-control" id="room" value="" placeholder="Room №">
                            <span id="room_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="flatsNo">Room quantity</label>
                            <select name="flatsNo" class="form-control" id="flatsNo">
                                @foreach($arrRooms as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12  col-lg-12">
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="phone">Contact phone</label>
                            <input type="text" class="form-control" id="phone" value="" placeholder="Contact phone">
                            <span id="phone_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="email">Contact email</label>
                            <input type="text" class="form-control" id="email" value="" placeholder="Contact email">
                            <span id="email_alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="text" class="form-control" id="price" value="" placeholder="Rent price $">
                            <span id="price_alert"></span>
                        </div>
                    </div>
                </div>


                <div class="col-sm-10  col-lg-10">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                        <span id="description_alert"></span>
                    </div>
                    <div class="form-group form-group-image">
                        <label>Upload photo</label> <span style="color:red;margin-left:20px;">WARNING! Only images with size less than 1.5MB will be saved!</span>
                        {!! Form::open(['method'=>'POST','action'=>'ApartmentController@store', 'class'=>'dropzone'])!!}
                        {{ Form::hidden('user_id', Auth::id() ) }}
                        {!! Form::close() !!}
                    </div>
                    <div class="form-group" id="buttons_send">
                        <input type="hidden" id="lat">
                        <input type="hidden" id="lng">
                        <button type="submit" class="send btn btn-success btn-small">Send</button>
                    </div>
                </div>
            </div>


            <div id="info_apartment" style="display: none;">
                <div class="col-sm-5 col-xs-12 col-lg-5">
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-4 col-lg-4">Country:</div>
                        <div class="col-sm-8 col-xs-8 col-lg-8" id="info_country"></div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-4 col-lg-4">City:</div>
                        <div class="col-sm-8 col-xs-8 col-lg-8" id="info_city"></div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-4 col-lg-4">Description:</div>
                        <div class="col-sm-8 col-xs-8 col-lg-8" id="info_description"></div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-4 col-lg-4">User:</div>
                        <div class="col-sm-8 col-xs-8 col-lg-8" id="info_user"></div>
                    </div>

                </div>
                <div class="col-sm-7 col-xs-12 col-lg-7">
                    <div id="mapBlockDetail"></div>
                </div>
                <div class="col-sm-10 col-xs-10 col-lg-10" id="info_images">

                </div>
            </div>


        </div>
    </div>




    <div id="apartmentLocation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Choose location
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mapBlock"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


    <script>
        $(".send").click(function () {
            $('#description_alert,#city_alert,#country_alert,#location_alert,#house_alert,#room_alert,#phone_alert,#email_alert,#street_alert,#price_alert').html('');
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var blnStatus = true;
            var city = $('#city').val();
            if (!city) {
                blnStatus = false;
                $('#city_alert').html('<b class="w3-text-red">* City name is required field<b>');

            }
            ;
            var country = $('#country').val();
            if (!country) {
                blnStatus = false;
                $('#country_alert').html('<b class="w3-text-red">* Country name is required field<b>');

            }
            ;

            var lat = $('#lat').val();
            var lng = $('#lng').val();
            if (!lat || !lng) {
                blnStatus = false;
                $('#location_alert').html('<b class="w3-text-red">* Location details are required<b>');

            }
            ;
            var house = $('#house').val();
            if (!house) {
                blnStatus = false;
                $('#house_alert').html('<b class="w3-text-red">* House number is required field<b>');

            }
            ;
            var room = $('#room').val();
            if (!room) {
                blnStatus = false;
                $('#room_alert').html('<b class="w3-text-red">* Room number is required field<b>');

            }
            ;
            var phone = $('#phone').val()
            if (!phone) {
                blnStatus = false;
                $('#phone_alert').html('<b class="w3-text-red">* Phone number is required field<b>');

            }
            ;
            var email = $('#email').val();
            if (!email) {
                blnStatus = false;
                $('#email_alert').html('<b class="w3-text-red">* Email name is required field<b>');

            }
            ;

            var price = $('#price').val();
            if (!price) {
                blnStatus = false;
                $('#price_alert').html('<b class="w3-text-red">* Price is required field<b>');

            }
            ;
            var street = $('#street').val();
            if (!street) {
                blnStatus = false;
                $('#street_alert').html('<b class="w3-text-red">* Street name is required field<b>');

            }
            ;
            var flatsNo = $('#flatsNo').val();
            var description = $('#description').val();
            if (!description) {
                blnStatus = false;
                $('#description_alert').html('<b class="w3-text-red">* Description is required field<b>');

            }
            ;
            var url = '{{ URL::to('add_apartment_ajax') }}';

            if (blnStatus) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        city: city,
                        country: country,
                        street: street,
                        lat: lat,
                        lng: lng,
                        description: description,
                        room: room,
                        email: email,
                        house: house,
                        phone: phone,
                        price:price,
                        flatsNo: flatsNo,
                        _token: token
                    },
                    success: function (data) {
                        console.log(data);
                        if (data['status']) {

                            window.location.href = "/show/" + data['id'];

//                         $('#create_apartment').hide();
//                         $('#info_apartment').show();
//                         $('#info_country').html(data['apartment']['country']);
//                         $('#info_city').html(data['apartment']['city']);
//                         $('#info_description').html(data['apartment']['description']);
//                         $('#info_user').html(data['user']['name']);
//
//                         for (var i = 0; i < data['apartment']['images'].length; i++) {
// // console.log(data['apartment']['images'][i]['path']);
//                             $('<span class="image_detail">').html('<img src="images/' + data['apartment']['images'][i]['path'] + '""></span>').appendTo('#info_images');
//                         }
//
//                         initMap(true, data['apartment']);

                        }

                    }
                });
            }
        });
    </script>



    {{--//-- Get Ajax data of apartment--}}
    {{--<script>--}}
    {{--$(".send").click(function () {--}}
    {{--var token = '{{\Illuminate\Support\Facades\Session::token()}}';--}}
    {{--var id = '5a2bfaa95da4192c640024ae';--}}
    {{--var url = '{{ URL::to('ajax') }}';--}}
    {{--$.ajax({--}}
    {{--method: 'POST',--}}
    {{--url: url,--}}
    {{--data: {id: id, _token: token},--}}
    {{--success: function (data) {--}}
    {{--console.log(data);--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--</script>--}}

    <script>
        function initMap(blnStatus=false, data) {
            if (!blnStatus) {
                var mapOptions = {
                    zoom: 3,
                    center: {lat: 53.478, lng: 27.668}
                };
                // create map in div called map-canvas using map options defined above
                map = new google.maps.Map(document.getElementById('mapBlock'), mapOptions);
                map2 = new google.maps.Map(document.getElementById('mapBlockDetail'), mapOptions);
                //-- Get coordinates on Map click
                google.maps.event.addListener(map, 'click', function (e) {
                    $('#lat').val(e.latLng.lat());
                    $('#lng').val(e.latLng.lng());
                    $('#locationResult').html('');
                    $('#buttonLocation').html('Edit location on the map');
                    $('#locationResult').html("Latitude: " + e.latLng.lat() + "<br> Longitude: " + e.latLng.lng());
                    $('#apartmentLocation').modal('hide');
                });
            } else {
                var mapOptions = {
                    zoom: 3,
                    center: {lat: +data['lat'], lng: +data['lng']}
                };
                map2 = new google.maps.Map(document.getElementById('mapBlockDetail'), mapOptions);

                var markerPlace = new google.maps.Marker({
                    position: new google.maps.LatLng(data['lat'], data['lng'])
                });
                markerPlace.setMap(map2);
            }

        }

        $('#apartmentLocation').on('shown.bs.modal', function () {
            google.maps.event.trigger(map, "resize");
        });

    </script>

    <script
        src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBtG9lCya_s1zxvYtU9Ob1L2JbwZ67vNk&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
    {{--<script src="{{asset('js/jquery.bxslider.js')}}" type="text/javascript"></script>--}}
    {{--<script>--}}
    {{--$('.bxslider').bxSlider({--}}
    {{--minSlides: 3,--}}
    {{--maxSlides: 4,--}}
    {{--slideWidth: 170,--}}
    {{--slideMargin: 10--}}
    {{--});--}}
    {{--</script>--}}
@endsection