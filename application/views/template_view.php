<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>Сотрудники</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="/public/css/main.css"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css"/>

        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
                crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
                integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
                integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
        <script src="/public/js/data-manager.js"></script>
        <script src="/public/js/moment.min.js"></script>
	</head>
	<body>
    <div class="header">
        <div class="row">
            <div class="col-xs-1 col-sm-2">
                <a class="logo" href="/">
                    <div class="text" style="color: white;text-decoration: none;padding-left: 3px;padding-top: 2px;display: inline-block;font-family: 'Raleway-Medium';font-size: 20px;">
                        logotype
                    </div>
                </a>
            </div>
            <div class="col-xs-1 col-sm-2">
                <a id="mainButton" href="/" class="btn btn-link">Главная</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php include 'application/views/'.$content_view; ?>
    </div>

    <div class="footer">
        <div class="col-xs-5 col-sm-3 col-md-2 col-lg-3">
            <a class="logo" href="/">
                <div class="text"
                     style="color: white;text-decoration: none;padding-left: 3px;padding-top: 2px;display: inline-block;font-family: 'Raleway-Medium';font-size: 20px;">
                    logotype
                </div>
            </a>
        </div>
    </div>

    </body>
</html>