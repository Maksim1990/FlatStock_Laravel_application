<div class="col-md-2 col-sm-2  col-lg-2" id="left">
    <div class="col-sm-12" style="text-align: right;">
        <a href="#" id="hide_filters"  data-toggle="tooltip" data-placement="top" title="Hide filters">
            <img src="{{asset('images/includes/arrows_white.png')}}" id="hide_bitton" alt="">
        </a>
    </div>
    <div class="col-md-10 cl-md-offset-1 col-sm-10 col-sm-offset-1  col-lg-10 col-lg-offset-1 ">

            <div class="form-group">
                <label for="search_country">Country</label>
                <select name="country" class="form-control" id="search_country">
                    @foreach($arrCountries as $key=>$item)
                        <option value="{{$item['name']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="search_city">City</label>
                <input type="text" class="form-control" id="search_city"  placeholder="City">
            </div>
        <div class="form-group">
            <label for="search_street">Street</label>
            <input type="text" class="form-control" id="search_street"  placeholder="Street">
        </div>
        <div class="form-group">
            <label for="search_house">House</label>
            <input type="text" class="form-control" id="search_house"  placeholder="House">
        </div>
        <div class="form-group">
            <label for="search_room">Room №</label>
            <input type="text" class="form-control" id="search_room"  placeholder="Room №">
        </div>
        <div class="col-sm-12">
        <label for="search_price">Search by price</label>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="search_price">Min</label>
                <input type="text" class="form-control" id="search_price"  placeholder="0$">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="search_pricemax">Max</label>
                <input type="text" class="form-control" id="search_pricemax"  placeholder="100$">
            </div>
        </div>



            <div class="form-group">
                <label for="flatsNo">Room quantity</label>
                <select name="flatsNo" class="form-control" id="search_flatsNo">
                    @foreach($arrRooms as $item)
                        <option value="{{$item}}">{{$item}}</option>
                    @endforeach
                </select>
            </div>

        <div class="w3-center">
            <button type="submit" id="btn_search" class="btn btn-success">Search</button>
        </div>

    </div>
</div>


