@extends('layouts.admin')
@section('styles')
    {{--<link href="{{asset('css/jquery.bxslider.css')}}" rel="stylesheet">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        .form-group {
            height: 80px;
        }

        .form-group-image {
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
                                    @if($key ==$apartment->country )
                                        {{$selected='selected'}}
                                    @else
                                        {{$selected=''}}
                                    @endif
                                    <option value="{{$key}}" {{$selected}}>{{$item['name']}}</option>
                                @endforeach
                            </select>
                            <span id="country_alert"></span>
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" value="{{$apartment->city}}"
                                   placeholder="Type city here">
                            <span id="city_alert"></span>
                        </div>
                        <div class="form-group">
                            <a href="#" data-toggle="modal" data-target="#apartmentLocation" title="Apartment location"
                               class="btn btn-default btn-small" id="buttonLocation">Edit location on the map</a>
                            <span id="location_alert"></span>
                            <p id="locationResult">
                                Latitude: {{$apartment->lat}}<br>
                                Longitude: {{$apartment->lng}}
                            </p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12  col-lg-12">
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="Street">Street</label>
                            <input type="text" class="form-control" id="street" value="{{$apartment->street}}"
                                   placeholder="Street name">
                            <span id="street_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="house">House №</label>
                            <input type="number" min="1" class="form-control" id="house" value="{{$apartment->house}}"
                                   placeholder="House №">
                            <span id="house_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="room">Room №</label>
                            <input type="number" min="1" class="form-control" id="room" value="{{$apartment->room}}"
                                   placeholder="Room №">
                            <span id="room_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="flatsNo">Room quantity</label>
                            <select name="flatsNo" class="form-control" id="flatsNo">
                                @foreach($arrRooms as $item)
                                    @if($item ==$apartment->flatsNo )
                                        {{$selected='selected'}}
                                    @else
                                        {{$selected=''}}
                                    @endif
                                    <option value="{{$item}}" {{$selected}}>{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12  col-lg-12">
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="phone">Contact phone</label>
                            <input type="text" class="form-control" id="phone" value="{{$apartment->phone}}"
                                   placeholder="Contact phone">
                            <span id="phone_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="email">Contact email</label>
                            <input type="email" class="form-control" id="email" value="{{$apartment->email}}"
                                   placeholder="Contact email">
                            <span id="email_alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5">
                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="text" class="form-control" id="price" value="{{$apartment->price}}" placeholder="Rent price $">
                            <span id="price_alert"></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10  col-lg-10">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3">{{$apartment->description}}</textarea>
                        <span id="description_alert"></span>
                    </div>

                        <div class="form-group form-group-image">
                            <div class="col-sm-5  col-lg-5 col-xs-12">
                            <label>Upload photo</label><span style="color:red;margin-left:20px;">WARNING! Only images with size less than 1.5MB will be saved!</span>
                            {!! Form::open(['method'=>'POST','action'=>'ApartmentController@store', 'class'=>'dropzone'])!!}
                            {{ Form::hidden('user_id', Auth::id() ) }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-sm-5  col-lg-5 col-xs-12" id="images_already_has">
                        @foreach($apartment->images as $image)
                            <a href="#" data-toggle="modal" data-target="#showImage"
                               title="Show image"
                               class="show_image"
                               data-image-id="{{$image->id}}"
                               data-image-path="{{$image->path}}"
                            >
                                <img id="image_{{$image->id}}" src="/images/{{$image->path}}" alt=""></a>
                        @endforeach
                    </div>
                    <div class="form-group" id="buttons_send">
                        <input type="hidden" id="lat" value="{{$apartment->lat}}">
                        <input type="hidden" id="lng" value="{{$apartment->lng}}">
                        <button type="submit" class="send btn btn-success btn-small">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div id="apartmentLocation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Application Info
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


    <div id="showImage" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Image
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="w3-center">
                        <img id="modal_image_show" src="" alt="">
                    </p>
                    <input type="hidden" id="modal_image_show_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="modal_delete_image">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')


    <script>
        $(".show_image").click(function () {
            var image_id = $(this).data('image-id');
            var image_path = $(this).data('image-path');
            $('#modal_image_show_id').val(image_id);
            $('#modal_image_show').attr("src", '/images/' + image_path);
        });


        $("#modal_delete_image").click(function () {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var image_id = $('#modal_image_show_id').val();

            var url = '{{ URL::to('delete_image_ajax') }}';
            //-- Make description area in modal is empty
            $('#modal_image_description').val('');
            var confImage = confirm('Do you want to delete this image?');
            if (confImage) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        image_id: image_id,
                        _token: token
                    },
                    success: function (data) {
                        //console.log(data);
                        if (data['status']) {
                           $('#image_'+image_id).hide();
                            $('#showImage').modal('hide');
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Image was successfully deleted!'
                            }).show();
                        }
                    }
                });
            }
        });


    </script>
    <script>
        $(".send").click(function () {
            $('#description_alert,#city_alert,#country_alert,#location_alert,#house_alert,#room_alert,#phone_alert,#email_alert,#street_alert,#price_alert').html('');
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';

            var id = '{{$apartment->id}}';
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
            var url = '{{ URL::to('edit_apartment_ajax') }}';
            if (blnStatus) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        city: city,
                        id: id,
                        country: country,
                        lat: lat,
                        lng: lng,
                        description: description,
                        room: room,
                        email: email,
                        house: house,
                        phone: phone,
                        price:price,
                        street: street,
                        flatsNo: flatsNo,
                        _token: token
                    },
                    success: function (data) {
                        if (data['status']) {
                            window.location.href = "/show/" + data['id'];
                        }

                        //console.log(data);
                    }
                });
            }
        });
    </script>


    <script>
        function initMap() {
            var mapOptions = {
                zoom: 3,
                center: {lat: +{{$apartment->lat}}, lng: +{{$apartment->lng}}}
            };
            // create map in div called map-canvas using map options defined above
            map = new google.maps.Map(document.getElementById('mapBlock'), mapOptions)

            var markerPlace = new google.maps.Marker({
                position: new google.maps.LatLng('{{$apartment->lat}}', '{{$apartment->lng}}')
            });
            markerPlace.setMap(map);
            //-- Get coordinates on Map click
            google.maps.event.addListener(map, 'click', function (e) {
                $('#lat').val(e.latLng.lat());
                $('#lng').val(e.latLng.lng());
                $('#locationResult').html('');
                $('#buttonLocation').html('Edit location on the map');
                $('#locationResult').html("Latitude: " + e.latLng.lat() + "<br> Longitude: " + e.latLng.lng());
                $('#apartmentLocation').modal('hide');
            });
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

@endsection