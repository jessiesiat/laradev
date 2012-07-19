<!DOCTYPE HTML>
<html lang="en-GB">
<head>
<meta charset="UTF-8">
<title>Laradev</title>
<meta name="description" content="  Laradev | Jessie Siat">
{{ Asset::container('head')->styles() }}
<script>
$(document).ready(function(){
  $(".alert").alert('close');
});
</script>
</head>
<body onload="prettyPrint()">
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
            <ul class="nav">
              <li class="brand">Laradev</li>
              <li class="divider-vertical"><a href="#">Link</a></li>
              @if (Auth::check())
              <li class="{{ URI::is('laradev') ? 'active' : '' }}">
                <a href="{{ URL::to('laradev') }}">Routes</a>
              </li>
              <li class="{{ URI::is('laradev/book') ? 'active' : '' }}">
                <a href="{{ URL::to('laradev/book') }}">Controllers</a>
              </li>
              @endif
            </ul>
            <ul class="nav pull-right">
            @if (Auth::check())
              <li>{{ HTML::link('laradev/logout', 'Logout') }}</li>
            @else
              <li>{{ HTML::link('laradev/login', 'Login') }}</li>
            @endif  
            </ul>
        </div>
      </div>
    </div>
       
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3 hero-unit">
                  <h2>Laradev</h2>
                  <p> A project created to test the beauty of Laravel </p>
                  <hr/>
                  @if(Auth::check())
                    <b>Official Documentation</b><br/><br/>
                    <ul class="unstyled">
                      <li><a href="http://laravel.com/docs/routing" target="_blank">Routing</a></li>
                      <li><a href="http://laravel.com/docs/controllers" target="_blank">Controllers</a></li>
                      <li><a href="http://laravel.com/docs/database/eloquent" target="_blank">Eloquent ORM</a></li>
                      <li><a href="http://laravel.com/docs/validation" target="_blank">Validation</a></li>
                      <li><a href="http://laravel.com/docs/views/pagination" target="_blank">Pagination</a></li>
                      <li><a href="http://laravel.com/docs/views/templating" target="_blank">Templating</a></li>
                    </ul>
                    <hr/>
                    <small>
                      <b>Oops! Take note:</b> change does brackets [ ], # to curly braces { }, @ in the Code section(view) respectively, I use alternative character instead of the blade syntax for it not to be parsed as php tags and be shown as plain text, got it!.
                    </small>
                  @endif

                </div>
                <div class="span9 well">
                    @if (Session::has('notify'))
                      <div class="alert alert-info">
                        <button class="close in fade alert" data-dismiss="alert">×</button>
                        {{ Session::get('notify') }}
                      </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
<br/> <br/>
{{ Asset::container('footer')->scripts() }}
</body>
</html>