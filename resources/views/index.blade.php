@extends('layouts.admin')
@section('styles')

@endsection
@section('content')
    @include('layouts.sidebar')

    <div class=" col-xs-12 col-sm-10 col-lg-10" id="right">
        <div class=" col-md-12 col-sm-7  col-lg-7 loading_block">
            <a href="#" id="show_filters" class="btn btn-small btn-success">Show filters</a>

            @if(Auth::check())
                <a href="{{URL::to('create')}}" class="btn btn-small btn-success">Create new</a>
            @else
                <a href="#" data-toggle="modal" data-target="#NotLogIn" title="Create new"
                   class="btn btn-small btn-success">Create new</a>
            @endif
            <img src="/images/includes/loading.gif" id="loading"/>
        </div>
        <div class=" col-md-12 col-sm-5  col-lg-5">
            <span id="found_results"></span>
        </div>
        <div class=" col-md-12 col-sm-12  col-lg-12">
            <div id="map"></div>

        </div>
    </div>






    <div id="NotLogIn" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    NOTIFICATION
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    You are not authorized yet for this action.<br>
                    Please <a href="{{ route('login') }}" class="alert_link">Sign In</a> or <a
                        href="{{ route('register') }}" class="alert_link">Sign Up</a> for having access to additional
                    functionality.
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
        var activeInfoWindow;
        var map;

        function initMap(reload=false, arrSearchOptions) {
            if (!reload) {
                var intZoom = 3;
            } else {
                var intZoom = 2;
            }
            var mapOptions = {
                zoom: intZoom,
                center: {lat: 53.477587983298434, lng: 27.667973041534424}
            };
            // create map in div called map-canvas using map options defined above
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            PrintItemsOnTheMap(reload, arrSearchOptions);

        }


        function PrintItemsOnTheMap(reload, arrSearchOptions) {
            var arrApartments = getArray();
            if (!reload) {

                arrApartments.forEach(function (item, i, arr) {
                    fnPlaceMarkers(new google.maps.LatLng(item['lat'], item['lng']), item['city'], item);
                });
            } else if (reload = 'search') {
                var arrResult = Array();
                //-- Apply all filters from inputs to array data
                arrApartments.forEach(function (item, i, arr) {

                    //-- Convert city name and street to lower case for searching
                    var filterCity=item['city'].toLowerCase();
                    var filterStreet=item['street'].toLowerCase();

                    if (filterCity.indexOf(arrSearchOptions['city']) != -1) {
                        if (item['country'].indexOf(arrSearchOptions['country']) != -1) {
                            if (filterStreet.indexOf(arrSearchOptions['street']) != -1) {
                                if (item['house'].indexOf(arrSearchOptions['house']) != -1) {
                                    if (item['room'].indexOf(arrSearchOptions['room']) != -1) {
                                        if (item['flatsNo'].indexOf(arrSearchOptions['flatsNo']) != -1) {
                                            if (arrSearchOptions['price'] != '' && arrSearchOptions['pricemax'] != '') {
                                                if (item['price'] >= arrSearchOptions['price'] && item['price'] <= arrSearchOptions['pricemax']) {
                                                    arrResult.push(arrApartments[i]);
                                                }
                                            } else if (arrSearchOptions['price'] == '' && arrSearchOptions['pricemax'] != '') {
                                                if (item['price'] <= arrSearchOptions['pricemax']) {
                                                    arrResult.push(arrApartments[i]);
                                                }
                                            } else if (arrSearchOptions['price'] != '' && arrSearchOptions['pricemax'] == '') {
                                                if (item['price'] >= arrSearchOptions['price']) {
                                                    arrResult.push(arrApartments[i]);
                                                }
                                            }else if(arrSearchOptions['price'] == '' && arrSearchOptions['pricemax'] == ''){
                                                arrResult.push(arrApartments[i]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                //console.log(arrResult);
                $('#found_results').html('');
                $('#found_results').html('Found ' + arrResult.length + ' results');
                arrResult.forEach(function (item, i, arr) {
                    fnPlaceMarkers(new google.maps.LatLng(item['lat'], item['lng']), item['city'], item);
                });
            }
        }


        //-- Get array of items to be displayed on the map
        function getArray() {
            var arrApartments = {!!json_encode($apartments)!!};
            return arrApartments;
        }


        function fnPlaceMarkers(myLocation, myCityName, item) {
            var markerPlace = new google.maps.Marker({
                position: myLocation
            });
            markerPlace.setMap(map);
            //console.log(item);
            // create an InfoWindow - for mouseover
            var infoWnd = new google.maps.InfoWindow();
            // create an InfoWindow -  for mouseclick
            var infoWnd2 = new google.maps.InfoWindow();
            infoWnd.setContent('<div class="scrollFix">' + item['country'] + ', ' + item['city'] + '<br>' + item['street'] + ', ' + item['house'] + '-' + item['room'] + '<br>' + item['flatsNo'] + ' rooms<span style="margin-left:20px;color:red;" ">'+item['price']+' $</span></div>');
            // add listener on InfoWindow for mouseover event
            google.maps.event.addListener(markerPlace, 'mouseover', function () {
                // Close active window if exists - [one might expect this to be default behaviour no?]
                if (activeInfoWindow != null) activeInfoWindow.close();
                // Close info Window on mouseclick if already opened
                infoWnd2.close();
                // Open new InfoWindow for mouseover event
                infoWnd.open(map, markerPlace);
                // Store new open InfoWindow in global variable
                activeInfoWindow = infoWnd;
            });


            // add content to InfoWindow for click event
            if (item['images'].length > 0) {
                var strImage = '<img src="images/' + item['images'][0]['path'] + '" style="height: 100px;margin-bottom: 20px;">';
            } else {
                var strImage = 'No images available';
            }
            if (item['description'] != '') {
                var strDescription = item['description'];
            } else {
                var strDescription = 'No description available';
            }
            infoWnd2.setContent('<div class="scrollFix" style="width:200px;">' + strDescription + '<br><br>' + strImage + '<br/><a href="show/' + item['_id'] + '">See details</a></div>');
            // add listener on InfoWindow for click event
            google.maps.event.addListener(markerPlace, 'click', function () {
                //Close active window if exists - [one might expect this to be default behaviour no?]
                if (activeInfoWindow != null) activeInfoWindow.close();
                // Open InfoWindow - on click
                infoWnd2.open(map, markerPlace);
                // Close "mouseover" infoWindow
                infoWnd.close();
                // Store new open InfoWindow in global variable
                activeInfoWindow = infoWnd2;
            });

        }

        //-- Set functionality in case of searching at the left sidebar
       var arrSearchOptions = Array();
        $("#btn_search").click(function () {

            var country = $('#search_country').val();
            var city = $('#search_city').val();
            var street = $('#search_street').val();
            var house = $('#search_house').val();
            var room = $('#search_room').val();
            var price = $('#search_price').val();
            var pricemax = $('#search_pricemax').val();
            var flatsNo = $('#search_flatsNo').val();
            $('#loading').css('display', 'inline');
            arrSearchOptions['country'] = country;
            city=city.toLowerCase();
            arrSearchOptions['city'] = city;
            street=street.toLowerCase();
            arrSearchOptions['street'] = street;
            arrSearchOptions['house'] = house;
            arrSearchOptions['room'] = room;
            arrSearchOptions['price'] = price
            arrSearchOptions['pricemax'] = pricemax;
            arrSearchOptions['flatsNo'] = flatsNo;
            console.log(arrSearchOptions);
            setTimeout(DeactivateLoading, 3000);
            initMap('search', arrSearchOptions);
        });


        $("#hide_filters").click(function () {
            $('#left').hide();
            $("#right").removeClass("col-xs-10 col-sm-10 col-lg-10");
            $("#right").addClass("col-xs-12 col-sm-12 col-lg-12");
            $("#show_filters").css("display", "inline");
            if(arrSearchOptions.length>0){
                initMap('search', arrSearchOptions);
            }else{
                initMap();
            }

        });

        $("#show_filters").click(function () {
            $('#left').show();
            $("#right").removeClass("col-xs-12 col-sm-12 col-lg-12");
            $("#right").addClass("col-xs-12 col-sm-10 col-lg-10");
            $("#show_filters").css("display", "none");
        });

        function DeactivateLoading() {
            $('#loading').css('display', 'none');
        }


        google.maps.event.addDomListener(window, 'load', initMap);


    </script>

    <script
        src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBtG9lCya_s1zxvYtU9Ob1L2JbwZ67vNk&callback=initMap">
    </script>

@endsection
