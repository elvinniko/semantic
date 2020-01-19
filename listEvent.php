<?php
include('./httpful.phar');

if(isset($_POST["search"])) {
    $return = $_POST["search"];
} else {
    $return = '';
}

if ($return === null) {
    $sparql = <<< END
    PREFIX csharp: <http://www.semanticweb.org/user/ontologies/2019/10/untitled-ontology-3#>
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    SELECT ?event ?script ?description ?name ?script_example
    WHERE {?event rdf:type csharp:Event . ?event csharp:hasSyntax ?script . ?event csharp:Description ?description . ?event csharp:Name ?name . ?script csharp:script ?script_example}
END;
} else {
    $sparql = <<< END
    PREFIX csharp: <http://www.semanticweb.org/user/ontologies/2019/10/untitled-ontology-3#>
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    SELECT ?event ?script ?description ?name ?script_example
    WHERE {?event rdf:type csharp:Event . ?event csharp:hasSyntax ?script . ?event csharp:Description ?description . ?event csharp:Name ?name . ?script csharp:script ?script_example . FILTER regex(?name, "${return}")}
END;
}

$url = 'http://localhost:3030/csharp/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$arr = json_decode($res);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        C#
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
            <div class="logo">
                <a href="#" class="simple-text logo-mini">
                </a>
                <a href="#" style="font-size:35px" class="simple-text logo-normal">
                    C#
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav side-menu">
                    <li>
                        <a href="history.php">
                            <i class="fas fa-info-circle"></i>
                            <p>History</p>
                        </a>
                    </li>
                    <li class="active ">
                        <a href="basicSyntax.php">
                            <i class="fas fa-code"></i>
                            <p>Basic Syntax</p>
                        </a>
                    </li>
                    <li>
                        <a href="operatingSystem.php">
                            <i class="fab fa-windows"></i>
                            <p>Operating System</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        &emsp;&emsp;
                        <div class="btn-group">
                            <button type="button" class="btn btn-round btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                CONTROL FLOW
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="listLooping.php">Looping</a>
                                <a class="dropdown-item" href="listSelection.php">Selection</a>
                            </div>
                        </div>
                        &emsp;&emsp;&emsp;&emsp;
                        <div class="btn-group">
                            <button type="button" class="btn btn-round btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                DATA TYPE
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="listBuiltIn.php">BuiltIn Type</a>
                                <a class="dropdown-item" href="listReference.php">Reference Type</a>
                                <a class="dropdown-item" href="listValue.php">Value Type</a>
                            </div>
                        </div>
                        &emsp;&emsp;&emsp;&emsp;
                        <div class="btn-group">
                            <button type="button" class="btn btn-round btn-primary">
                                <a href="listEvent.php">EVENT</a>
                            </button>
                        </div>
                        &emsp;&emsp;&emsp;&emsp;
                        <div class="btn-group">
                            <button type="button" class="btn btn-round btn-primary">
                                <a href="listMethod.php">METHOD</a>
                            </button>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form action="listEvent.php" method="post">
                            <br>
                            <div class="input-group no-border">
                                <input type="text" name="search" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <button class="btn-primary btn-fab btn-icon btn-round" type="submit"><i class="now-ui-icons ui-1_zoom-bold"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach ($arr->results->bindings as $data) : ?>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><b><?php echo $data->name->value;  ?></b></h3>
                                </div>
                                <div class="card-body">
                                    <h5>Keterangan</h5>
                                    <p><?php echo $data->description->value;  ?></p>
                                    <h5>Penulisan</h5>
                                    <p><?php echo $data->script_example->value;  ?></p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();
        });
    </script>
</body>

</html>