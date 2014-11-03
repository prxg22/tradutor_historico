translateApp.controller('IndexController', ['$scope', 'blockPage', '$http', function($scope, blockPage, $http){
	$scope.aluno = {
		matricula: '',
		senha: ''
	};
	
	$scope.closeAlert = function(index) {
	  	$scope.alerts.splice(index, 1);
	};
	
	$scope.Translate = function(){
		aluno = $scope.aluno;
		if($scope.aluno.matricula == '')
			$scope.alerts.push({type: 'danger', msg: 'A matricula não pode estar vazia!'});
		if($scope.aluno.senha == '')
			$scope.alerts.push({type: 'danger', msg: 'A senha não pode ser vazia'});
		if($scope.alerts.length > 0)
			return;
		
		historico = {semestre: []};
		blockPage.block();
		$http.post($scope.siteUrl + 'IndexController/GetHistorico', {aluno: aluno}).
		success(function(data){
			historico = data;
			$scope.goTo('index.php/HistoricoController', historico);
			blockPage.unblock();
		}).
		error(function(data, status){
			console.log(data);
			blockPage.unblock();
		});
	}
}]);