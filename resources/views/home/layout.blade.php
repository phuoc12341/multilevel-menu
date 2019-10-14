<!DOCTYPE html>
<html class="csstransforms no-csstransforms3d csstransitions"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Responsive Drop Down Menu jQuery CSS3 Using Icon Symbol</title>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/app.css">
    
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/function.js"></script>

</head>
<body>
    <div style="background:#0099cc; font-size:22px; text-align:center; color:#FFF; font-weight:bold; height:100px; padding-top:50px;">Responsive Drop Down Menu jQuery CSS3 Using Icon Symbol</div>
    <div id="wrap">
        <header>
            <div class="inner relative">
                <a class="logo" href="http://www.freshdesignweb.com"><img src="images/logo.png" alt="fresh design web"></a>
                <a id="menu-toggle" class="button dark" href="#"><i class="icon-reorder"></i></a>

                @yield('navigation')

                <div class="clear"></div>
            </div>
        </header>	
    </div>

    @yield('body')

</body>
</html>
