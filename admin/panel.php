<?php
  session_start();
  $user = $_SESSION['user'];
  
  if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
    header("location: ../admin");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en" ng-app="scriptnet">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISTEMA | PANEL</title>

    <link rel="stylesheet" href="static/bower_components/angular_daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="static/bower_components/angular-material/angular-material.css">
    <link rel="stylesheet" href="static/bower_components/Bootstrap_Grid/Bootstrap_Grid.css">
    <link rel="stylesheet" href="static/bower_components/BootstrapSelect/css/bootstrap-select.min.css">
    
    <!-- <link rel="stylesheet" href="static/bower_components/ng-table/ng-table.min.css"> -->
    <link rel="stylesheet" href="static/app.css">
   
</head>

<body ng-controller="scriptpanel" class="docs-body ">
    <!-- componentes necesarios -->

    <script src="static/bower_components/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="static/bower_components/pooper/popper.min.js"></script>
    <script src="static/bower_components/Bootstrap_Grid/bootstrap.min.js"></script>
    <script src="static/bower_components/BootstrapSelect/js/bootstrap-select.min.js"></script>

    <!-- angularjs -->
    <script src="static/bower_components/angularjs/angular-1.7.6.js"></script>
    <script src="static/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script src="static/bower_components/angular-resource/angular-resource.min.js"></script>
    <script src="static/bower_components/oclazyload/dist/ocLazyLoad.min.js"></script>
    <script src="static/bower_components/BootstrapUI/ui-bootstrap-tpls-2.5.0.min.js"></script>
    <!-- <script src="static/bower_components/ng-table/ng-table.min.js"></script> -->
    <!-- angularjs material -->
    <script src="static/bower_components/angular-material/angular-animate.min.js"></script>
    <script src="static/bower_components/angular-material/angular-aria.min.js"></script>
    <script src="static/bower_components/angular-material/angular-messages.min.js"></script>
    <script src="static/bower_components/angular-material/angular-material.js"></script>
    <!-- moment js -->

    <script src="static/bower_components/momentjs/moment.min.js"></script>
    <script src="static/bower_components/angular_daterangepicker/daterangepicker.min.js"></script>
    <script src="static/bower_components/angular_daterangepicker/angular-daterangepicker.min.js"></script>

    <!-- LIBRERIAJSPDF -->
    <script src="static/bower_components/printS/jspdf.min.js"></script>
    <script src="static/bower_components/printS/jspdf.plugin.autotable.js"></script>

    <!-- chart js -->
    <script src="static/bower_components/angularChart/Chart.min.js"></script>
    <script src="static/bower_components/angularChart/angular-chart.min.js"></script>

    <!-- angularCookies -->
    <script src="static/bower_components/angularCookies/angular-cookies.min.js"></script>
    <!-- cargar componentes según módulo -->
    <script src="static/core/constants/constants.js"></script>
    <script src="static/core/modules/oclazyload.component.js"></script>
    <script src="static/app.js"></script>
    <script src="static/routes.js"></script>
    <script src="static/bundle.js"></script>

    <!-- nabar -->


    <div _ngcontent-c2 id="wrapper">
        <nav-bar></nav-bar>


        <div layout="column" class="visible-scrollbar" ui-view>

        </div>


    </div>

</body>

</html>