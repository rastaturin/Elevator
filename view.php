<!DOCTYPE html>
<html lang="en" ng-app="app">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
    <script src="app.js"></script>

</head>

<body ng-controller="mainController">

<div class="container">
    <form ng-submit="send(requests)">
    <textarea cols="50" rows="4" class="form-control" ng-model="requests">
    </textarea>
    <input type="submit" class="btn btn-success" value="Send!">
    </form>
    <table class="table">
        <tr ng-repeat="(id, step) in steps">
            <td>Step {{id}}</td>
            <td ng-repeat="(elid, elevator) in step">
                Elevator #{{elevator['id']}} on {{elevator.floor}}, {{elevator.direction}}
            </td>
        </tr>
    </table>
    <div class="alert alert-warning" role="alert" ng-if="error != ''">{{error}}</div>
</div>

</body>
</html>