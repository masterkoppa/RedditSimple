<html>
    <head>
        <meta charset="utf-8"/>
        <title>Reddit Simple</title>

        <!-- ReactJS Imports -->
        <script src="http://fb.me/react-0.10.0.js"></script>
        <script src="http://fb.me/JSXTransformer-0.10.0.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>

        <!-- Bootstrap includes -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

        <!-- Aditional Scripts and styles -->
        <script src="/assets/js/main.js"></script>
        <link rel="stylesheet" href="/assets/css/main.css">
    </head>
    <body>
        <h2>Reddit Simple</h2>
        <div id="container"></div>
        <script type="text/jsx" src="/assets/js/jsx.js"></script>

        <!-- Article Template -->
        <script type="text/x-template" id="reddit-post-template">
            <div class="reddit-post well">
                <!-- Row with the content -->
                <div class="row">
                    <div class="col-md-1 col-sm-2">
                        <div class="text-centered">
                            <div id="up-arrow" class="btn btn-default">
                                <span class="glyphicon glyphicon-arrow-up"></span>
                            </div>
                            <p>{score}</p>
                            <div id="down-arrow" class="btn btn-default">
                                <span class="glyphicon glyphicon-arrow-down"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 col-sm-10">
                        <p>
                        <h3>{title}</h3>
                        <!-- TODO: Add some of the self text here or a preview or something -->
                        <!-- TODO: Add RES Like Link Preview for Images -->
                        <!-- TODO: Add flair info and apply css styling for spoilers -->
                        </p>
                    </div>
                </div>
                <div class="row">
                    <!-- Links go here -->
                    <div class="col-sm-1 col-sm-offset-1">
                        {num_cumments} Comments <!-- Make link -->
                    </div>
                    <div class="col-sm-1">
                        Report <!-- Make link, is it even possible? MINOR PRIORITY -->
                    </div>
                </div>
            </div>
        </script>

        <!-- TODO: Add footer -->
    </body>
</html>
