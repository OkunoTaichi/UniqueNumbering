<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
            <!-- @yield('department.department_layouts.layout.title') -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav_item {{ (url()->current() == route('UnNumber.index'))?'is_active' : 'in_active' }}"><a href="{{ route('UnNumber.index') }}">採番区分作成</a></li>
                <!-- <li class="nav_item {{ (url()->current() == route('UnNumber.edit_create'))?'is_active' : 'in_active' }}"><a href="{{ route('UnNumber.edit_create') }}">編集区分作成</a></li> -->
                <li class="nav_item {{ (url()->current() == route('UnNumber.system_index'))?'is_active' : 'in_active' }}"><a href="{{ route('UnNumber.system_index') }}">採番処理機能</a></li>
                <li class="nav_item in_active"><a href="{{ route('Authority.Authority_index') }}">権限マスタ</a></li>
                <li id="Person_link" class="nav_item in_active link_wrap">
                    <p class="link_top"><a href="{{ route('Person.Person_index') }}">担当者マスタ</a></p>
                    <div id="Person_link_wrap" class="link_sub_wrap">
                        <p class="link_sub"><a href="{{ route('Person.Person_create') }}">新規作成</a></p>
                        <p class="link_sub"><a href="{{ route('Person.Person_index') }}">一覧</a></p>
                    </div>
                </li>
                <li class="nav_item in_active"><a href="{{ route('Building.Building_index') }}">棟マスタ</a></li>
                <li class="nav_item in_active"><a href="{{ route('Room.Room_index') }}">部屋マスタ</a></li>
                <li class="nav_item in_active"><a href="{{ route('RoomType.RoomType_index') }}">部屋タイプマスタ</a></li>
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->tenantCode }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>