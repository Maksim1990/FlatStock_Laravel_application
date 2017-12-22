@extends('layouts.admin')
@section('styles')
    <link href="{{asset('js/jquery.bxslider.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        .bx-wrapper .bx-controls-direction a {
            z-index: 1;
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-12  col-xs-12" id="item_block">
        <div class="col-sm-10 col-sm-offset-2  col-xs-12">
            <div class="col-sm-8   col-xs-12">
                <h1 id="title_left">{{$apartment->street}}, {{$apartment->house}}-{{$apartment->room}}</h1>
                <h1 id="title_right">{{$apartment->flatsNo}} rooms</h1> <h2 id="show_price" style="float: right;">{{$apartment->price}} $</h2>
            </div>
            <div id="info_apartment" style="clear:both;">
                <div class="col-sm-5 col-xs-12 col-lg-5">
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Country:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_country">
                            @foreach($arrCountries as $key=>$item)
                                @if($key ==$apartment->country )
                                    {{$item['name']}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">City:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_city">{{$apartment->city}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12 ">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Description:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_description">{{$apartment->description}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12 ">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Street:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_street">{{$apartment->street}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">House:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->house}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Room:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->room}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12 ">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Contact person:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$user->name}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Phone:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->phone}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Email:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->email}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-4 col-xs-6 col-lg-4 line">Posted at:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->created_at}}</div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-lg-12 line">
                        <div class="col-sm-4 col-xs-6 col-lg-4">Last modified at:</div>
                        <div class="col-sm-8 col-xs-6 col-lg-8" id="info_user">{{$apartment->updated_at}}</div>
                    </div>
                    @if($apartment->user_id==Auth::id())
                        <a href="{{ URL::to( 'edit/'.$apartment->id) }}" class="btn btn-small btn-success">Edit</a>
                        <a href="#" id="delete" data-delete-id="{{$apartment->id}}"
                           class="btn btn-small btn-danger">Delete</a>
                    @endif
                </div>
                <div class="col-sm-7 col-xs-12 col-lg-7">
                    <div id="mapBlockDetail"></div>
                </div>
                <div class="col-sm-7 col-xs-12 col-lg-7" id="info_images">
                    @if(count($apartment->images)>0)
                        <div class="bxslider">
                            @foreach($apartment->images as $image)
                                <div id="slider_block_{{$image->id}}">
                                    <a href="#" data-toggle="modal" data-target="#showImage"
                                       title="Show image"
                                       class="show_image"
                                       data-image-id="{{$image->id}}"
                                       data-image-path="{{$image->path}}"
                                    >
                                        <img
                                            src="/images/{{$image->path}}"/></a>

                                    <div class="w3-center description_block_{{$image->id}}"
                                         style="width: 100%;padding-top: 30px;">
                                        @if(count($image->descriptions)>0)
                                            @foreach($image->descriptions as $description)
                                                @if($description->description)
                                                    {{$description->description}}<br>
                                                    @if($apartment->user_id==Auth::id())
                                                        <a href="#" data-toggle="modal" data-target="#addDescription"
                                                           title="Edit description"
                                                           class="btn btn-small btn-warning edit_description"
                                                           data-image-id="{{$image->id}}"
                                                           data-image-path="{{$image->path}}"
                                                           data-image-description="{{$description->description}}"
                                                        >Edit description</a>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="w3-center" style="width: 100%;padding-top: 50px;">
                                                No description to this picture<br>
                                                @if($apartment->user_id==Auth::id())
                                                    <a href="#" data-toggle="modal" data-target="#addDescription"
                                                       title="Add description"
                                                       class="btn btn-small btn-success add_description"
                                                       data-image-id="{{$image->id}}"
                                                       data-image-path="{{$image->path}}"
                                                    >Add new description</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            @endforeach
                        </div>
                    @else
                        <h6>There are no linked images!</h6>

                    @endif
                </div>
            </div>


        </div>
    </div>





    <div id="addDescription" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Image's description
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="w3-center">
                        <img id="modal_image" src="" alt="">
                    </p>
                    <input type="hidden" id="modal_image_id">
                    <input type="hidden" id="modal_image_path">
                    <textarea name="modal_image_description" id="modal_image_description" rows="3"
                              style="width: 100%;"></textarea>
                    <span id="description_alert"></span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="modal_image_save">Save</button>
                    <button type="button" class="btn btn-danger" style="display: none;" id="modal_image_delete">Delete
                    </button>
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
                    @if($apartment->user_id==Auth::id())
                    <button type="button" class="btn btn-danger" id="modal_delete_image">Delete</button>
                    @endif
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

        $(".add_description").click(function () {
            var image_path = $(this).data('image-path');
            var image_id = $(this).data('image-id');
            $('#modal_image').attr("src", '/images/' + image_path);

            $('#modal_image_id').val(image_id);
            $('#modal_image_path').val(image_path);
            $('#modal_image_delete').css('display', 'none');
            $('#modal_image_description').val('');

        });

        $(".edit_description").click(function () {
            var image_path = $(this).data('image-path');
            var image_id = $(this).data('image-id');
            var image_description = $(this).data('image-description');
            $('#modal_image').attr("src", '/images/' + image_path);
            $('#modal_image_id').val(image_id);
            $('#modal_image_path').val(image_path);

            $('#modal_image_description').val(image_description);
            $('#modal_image_delete').css('display', 'inline');
        });


    </script>
    <script>
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
                            location.reload();
                        }
                    }
                });
            }
        });

            $("#modal_image_delete").click(function () {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var image_id = $('#modal_image_id').val();

            var image_path = $('#modal_image_path').val();
            var url = '{{ URL::to('delete_image_description_ajax') }}';
            //-- Make description area in modal is empty
            $('#modal_image_description').val('');
            $('#addDescription').modal('hide');
            var confDelete = confirm('Do you want to delete this description?');
            if (confDelete) {
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
                            $('#addDescription').modal('hide');
                            $('#modal_image_id').val('');
                            $('#modal_image_path').val('');
                            $('#modal_image_description').val('');
                            $('.description_block_' + image_id).html('');
                            $('.description_block_' + image_id).css('paddingTop', '50px');
                            $('#modal_image_delete').css('display', 'none');
                            $('<span>').html('No description to this picture<br><a href="#" data-toggle="modal" data-target="#addDescription" title="Add description" class="btn btn-small btn-success add_description" data-image-id="' + image_id + '" data-image-path="' + image_path + '" >Add new description</a></span>').appendTo('.description_block_' + image_id);
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Description was successfully deleted!'
                            }).show();
                        }
                        $(".add_description").click(function () {
                            var image_path = $(this).data('image-path');
                            var image_id = $(this).data('image-id');
                            $('#modal_image').attr("src", '/images/' + image_path);

                            $('#modal_image_id').val(image_id);
                            $('#modal_image_path').val(image_path);
                            $('#modal_image_delete').css('display', 'none');
                            $('#modal_image_description').val('');

                        });
                    }
                });
            }
        });


        $("#modal_image_save").click(function () {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            blnStatus = true;
            var image_id = $('#modal_image_id').val();
            var image_description = $('#modal_image_description').val();
            var image_path = $('#modal_image_path').val();
            var url = '{{ URL::to('add_image_description_ajax') }}';

            if (!image_description) {
                blnStatus = false;
                $('#description_alert').html('<b class="w3-text-red">* Description is required field<b>');
            }
            ;

            if (blnStatus) {
                alert(image_id);
                alert(image_description);
                //-- Make description area in modal is empty
                $('#modal_image_description').val('');
                $('#addDescription').modal('hide');
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        image_description: image_description,
                        image_id: image_id,
                        _token: token
                    },
                    success: function (data) {
                        //console.log(data);
                        if (data['status']) {
                            $('#modal_image_id').val('');
                            $('#modal_image_path').val('');
                            $('#modal_image_description').val('');
                            $('#addDescription').modal('hide');
                            $('.description_block_' + image_id).html('');
                            $('<span>').html(image_description + '<br><a href="#" data-toggle="modal" data-target="#addDescription" title="Edit description" class="btn btn-small btn-warning edit_description" data-image-id="' + image_id + '" data-image-path="' + image_path + '" data-image-description="' + image_description + '">Edit description</a></span>').appendTo('.description_block_' + image_id);
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Description was successfully added!'
                            }).show();
                        }

                        $(".edit_description").click(function () {
                            var image_path = $(this).data('image-path');
                            var image_id = $(this).data('image-id');
                            var image_description = $(this).data('image-description');
                            $('#modal_image').attr("src", '/images/' + image_path);
                            $('#modal_image_id').val(image_id);
                            $('#modal_image_path').val(image_path);

                            $('#modal_image_description').val(image_description);
                            $('#modal_image_delete').css('display', 'inline');
                        });
                    }
                });
            }
        });
    </script>
    <script>
        $("#delete").click(function () {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var id = $(this).data('delete-id');
            var conf = confirm('Do you want to delete this apartment?');
            if (conf) {
                window.location.href = "/delete/" + id;
            }
        });
    </script>
    <script>
        function initMap() {

            var mapOptions = {
                zoom: 3,
                center: {lat: {{$apartment->lat}}, lng: {{$apartment->lng}}}
            };
            map = new google.maps.Map(document.getElementById('mapBlockDetail'), mapOptions);

            var markerPlace = new google.maps.Marker({
                position: new google.maps.LatLng('{{$apartment->lat}}', '{{$apartment->lng}}')
            });
            markerPlace.setMap(map);
        }
    </script>
    <script
        src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBtG9lCya_s1zxvYtU9Ob1L2JbwZ67vNk&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
    <script src="{{asset('js/jquery.bxslider.js')}}" type="text/javascript"></script>
    <script>
        $('.bxslider').bxSlider({
            //auto: true,
            pause: 6000,
            minSlides: 1,
            maxSlides: 2,
            slideMargin: 10
        });
    </script>
@endsection