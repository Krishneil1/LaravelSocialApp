<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{route('home')}}">Chatty</a>
    </div>
    <div class="collapse navbar-collapse">
        @if (Auth::check())
            <ul class="nav navbar-nav">
                <li><a href="{{ route ('home') }}">Timeline</a></li>
                <li><a href="{{ route ('friend.index') }}">Friends</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="{{route('search.results')}}">
                <div class ="form-group">
                    <input type ="text" name="query" class="form-control" placeholder ="Find People">
                </div>
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())    
                    <li><a href ="{{ route('profile.index', ['username'=>Auth::user()->username]) }}">{{Auth::user()->getNameOrUsername()}}</a></li>
                    <li><a href="{{route ('profile.edit')}}">Update profile</a></li>
                    <li><a href="{{route('auth.signout')}}">Sign Out</a></li>
                @else
                    <li><a href="{{route('auth.signup')}}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="{{route('auth.signin')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @endif
            </ul>
    </div>
  </div>
</nav>