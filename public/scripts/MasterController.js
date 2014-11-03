translateApp = angular.module('translateApp', ['ui.bootstrap']);

translateApp.factory('blockPage', function(){
	blockInstance = {
		active: false,
		request: 0
	};
	
	function InitializeBlockPage(){
		div = '<div class = "block"><div class="loader"></div></div>'
		$('html').append(div);
	}
	
	
	InitializeBlockPage();
	
	return blockInstance;
});


/**
 * Controlador master da API em AngularJs 
 */
translateApp.controller('MasterController', ['$location', '$scope', 'blockPage', function($location, $scope, blockPage){
	$scope.alerts = [];
	$scope.siteUrl = '';
	
	blockPage.block = function(){
		if(this.active == true){
			this.request++;
			return;
		}
		
		this.active = true;
		$('.block').addClass('active');
		$('.block.active').css('height', $(document).height());
	}
	
	blockPage.unblock = function(){
		if(this.active == false){
			console('desbloqueio sem estar ativo :/');
			return;
		}else if(this.request > 0){
			this.request--;
			return;
		}
		
		this.active = false;
		$scope.$apply();
		$('.block').removeClass('active');
		
	}
	
	$scope.ShowAlert = function(index){
		setTimeout(function(index,scope){
			scope.CloseAlert(index);
			$scope.$digest();
		}, 2000, index, $sgetope);
		
		return $scope.alerts[index].msg;
	};
	
	$scope.CloseAlert = function(index){
		$scope.alerts.splice($scope.alerts[index]);
	};
	
	$scope.goTo = function (controller, data){
		$.post($scope.siteUrl + 'BaseController/saveNextRequest', {nextRequest: data})
		.success(function(data){
			if(data == 'ok'){
				window.location.href = controller;
			}
		});
	};
	
	$scope.getSiteUrl = function (){
		blockPage.block();
		url = $location.absUrl();
		index = url.indexOf('index.php/')
		if(index > -1){
			$scope.siteUrl= url.slice(0, index+10);
		}else{
			$scope.siteUrl = url+'index.php/';
		}
		blockPage.unblock();
	}
	
	$scope.getSiteUrl();
}]);