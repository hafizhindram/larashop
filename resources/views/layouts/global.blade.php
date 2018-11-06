<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    @include('partials._head')
</head>
<body>

	@include('partials._nav')

  <div class="container-fluid h-100 p-0">
    <div style="min-height: 100%" class="flex-row d-flex align-items-stretch m-0">
        <div class="polished-sidebar bg-light col-12 col-md-3 col-lg-2 p-0 collapse d-md-inline" id="sidebar-nav">

            <ul class="polished-sidebar-menu ml-0 pt-4 p-0 d-md-block">
              <input class="border-dark form-control d-block d-md-none mb-4" type="text" placeholder="Search" aria-label="Search" />
              <li><a href="{{route('home')}}"><span class="oi oi-home"></span> Home</a></li>
              <li><a href="{{route('users.index')}}"><span class="oi oi-people"></span> Manage users</a></li>
              <li><a href="{{route('categories.index')}}"><span class="oi oi-tag"></span> Manage categories</a></li>
              <li><a href="{{route('books.index')}}"><span class="oi oi-book"></span> Manage books</a></li>
              <li><a href="#"><span class="oi oi-inbox"></span> Manage orders</a></li>
              
              <div class="d-block d-md-none">
                  <div class="dropdown-divider"></div>
                  <li><a href="#"> Profile</a></li>
                  <li><a href="#"> Setting</a></li>
                  <li>
                    <form action="{{route("logout")}}" method="POST">
                      @csrf
                      <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
                    </form>
                  </li>
              </div>
            </ul>
            {{-- <div class="pl-3 d-none d-md-block position-fixed" style="bottom: 0px">
                <span class="oi oi-cog"></span> Setting
            </div> --}}
        </div>
        <div class="col-lg-10 col-md-9 p-4">
            <div class="row ">
              <div class="col-md-12 pl-3 pt-2">
                  <div class="pl-3">
                    <h3>@yield("title")</h3>
                    <br>
                  </div>
              </div>
            </div>

            @include('partials._message') 
            @yield("content")


        </div>
      </div>
  </div>

	@include('partials._js')
  @yield('footer-scripts')

</body>
</html>