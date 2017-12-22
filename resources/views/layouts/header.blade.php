<header>
    <div class="row">
        <div class=" col-xs-12 col-sm-4  col-md-4 w3-center" id="header_left">
            <a href="{{URL::to('/')}}">FlatsStock App</a>
        </div>
        <div class=" col-xs-12 col-sm-4 col-sm-offset-2   col-md-offset-2 col-md-4 " id="header_right">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <span>Welcome, {{Auth::user()->name}}!</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                           data-toggle="tooltip" data-placement="right" title="Logout">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}">Sign In</a>
                        <a href="{{ route('register') }}">Sign Up</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>




    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</header>