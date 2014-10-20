


var app = angular.module('books', ['ngRoute', 'ngAnimate']);   


app.controller('booksCtrl', function($scope, $http){
     
   						$scope.books = {};
              $scope.searching = false;                            
              



                            
             $http.get('backend/get_books.php').success(function(rs){   
               console.log(rs);           
                 $scope.books = rs.rs['books'];
                 $scope.tops = rs.rs['tops'];                                
             });


 });      	





 app.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {



     
      $routeProvider
        .when('/', {
          templateUrl: 'views/home.html',
          controller : 'booksCtrl'
        })
        .when('/home', {
          templateUrl: 'views/home.html',
          controller : 'booksCtrl'
        })



    }]);


