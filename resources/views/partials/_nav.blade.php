<nav class="navbar navbar-expand p-0">
   <a class="navbar-brand text-center col-xs-12 col-md-3 col-lg-2 mr-0" href="index.html"> Larashop </a>
    <button class="btn btn-link d-block d-md-none" data-toggle="collapse" data-target="#sidebar-nav" role="button" >
      <span class="oi oi-menu"></span>
    </button>
    
    <input class="border-dark bg-primary-darkest form-control d-none d-md-block w-50 ml-3 mr-2" type="text" placeholder="Search" aria-label="Search">
    <div class="dropdown d-none d-md-block">
      @if(\Auth::user())
      <button class="btn btn-link btn-link-primary dropdown-toggle" id="navbar-dropdown" data-toggle="dropdown">
        {{Auth::user()->name}}
      </button>
      @endif 
      <div class="dropdown-menu dropdown-menu-right" id="navbar-dropdown">
        <a href="#" class="dropdown-item">Profile</a>
        <a href="#" class="dropdown-item">Setting</a>
        <div class="dropdown-divider"></div>
        <li>
          <form action="{{route("logout")}}" method="POST">
            @csrf
            <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
          </form>
        </li>
      </div>
    </div>
</nav>