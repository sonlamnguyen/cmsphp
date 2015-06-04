<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>App Name - @yield('title')</title>

        <!-- Bootstrap Core CSS -->
        <link href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="/static/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
        	body {
        		padding-top: 40px;
        		padding-bottom: 40px;
        		background-color: #eee;
        	}

        	.form-signin {
        		max-width: 330px;
        		padding: 15px;
        		margin: 0 auto;
        	}
        	.form-signin .form-signin-heading,
        	.form-signin .checkbox {
        		margin-bottom: 10px;
        	}
        	.form-signin .checkbox {
        		font-weight: normal;
        	}
        	.form-signin .form-control {
        		position: relative;
        		height: auto;
        		-webkit-box-sizing: border-box;
        		-moz-box-sizing: border-box;
        		box-sizing: border-box;
        		padding: 10px;
        		font-size: 16px;
        	}
        	.form-signin .form-control:focus {
        		z-index: 2;
        	}
        	.form-signin input[type="email"] {
        		margin-bottom: -1px;
        		border-bottom-right-radius: 0;
        		border-bottom-left-radius: 0;
        	}
        	.form-signin input[type="password"] {
        		margin-bottom: 10px;
        		border-top-left-radius: 0;
        		border-top-right-radius: 0;
        	}
        </style>
    </head>
    <body>
    	<div class="container">

    		<form class="form-signin" action="{{ URL::route('backUserAuthen') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h2 class="form-signin-heading">User Login</h2>
                <label for="inputUsername" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    			<!--
    			<div class="checkbox">
    				<label>
    					<input type="checkbox" value="remember-me"> Remember me
    				</label>
    			</div>
    			-->
    			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                @if($message)
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                @endif
    		</form>

    	</div> <!-- /container -->        


        <!-- jQuery -->
        <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>
