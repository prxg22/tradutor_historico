translateApp.controller('HistoricoController', ['$scope', 'blockPage', function($scope, blockPage){
	/*$scope.historico = {
			semestres : [
						{materias: [
					            {cod: 1, orig: 'Computação Básica', trad: [
					                    {cod: 0, txt: 'Basics Computing', choosen:1},
					            		{cod: 1, txt: 'Basic Computing', choosen: 0}
					            	], 
					            	nota: 'MS'},
					            {cod: 2, orig: 'Cálculo 1', trad: [
					                    {cod: 0, txt: 'Calculus 1', choosen: 0},
					            		{cod: 1, txt: 'Calculation 1', choosen: 2}
					            	], 
					            	nota: 'MS'},
					            {cod: 3, orig: 'Variável Complexa 1', trad: [
					                    {cod: 0, txt: 'Complex Variable 1', choosen: 0},
					            	],
					            	nota: 'MS'}
					        ]},
			            	{materias: [
	            	            {cod: 1, orig: 'Computação Básica', trad: [
	            	                    {cod: 0, txt: 'Basics Computing', choosen:1},
	            	            		{cod: 1, txt: 'Basic Computing', choosen: 2},
	            	            		{cod: 1, txt: 'Basic Computing', choosen: 0}
	            	            	], 
	            	            	nota: 'MS'},
	            	            {cod: 2, orig: 'Cálculo 1', trad: [
	            	                    {cod: 0, txt: 'Calculus 1', choosen: 0},
	            	            		{cod: 1, txt: 'Calculation 1', choosen: 2}
	            	            	], 
	            	            	nota: 'MS'},
	            	            {cod: 3, orig: 'Variável Complexa 1', trad: [
	            	                    {cod: 0, txt: 'Complex Variable 1', choosen: 0},
	            	            	],
	            	            	nota: 'MS'}
            	            ]}
			        	]
			} */
	
	
	$scope.newTranslation = '';
	$scope.historico = []
	
	$scope.getHistorico = function(){
		blockPage.block();
		$.post($scope.siteUrl + 'HistoricoController/GetHistorico').
		success(function (data){
			$scope.historico = data.historico;
			blockPage.unblock();
		}).
		error(function (data){
			console.log(data);
			blockPage.unblock();
		});
	};
		
	$scope.SelectTranslation = function(selectedTrans, materia){
		materia.tradSelected = selectedTrans;
		materia.showTrans = false;
	};
	
	$scope.SelectNewTranslation = function(materia){
		if(!materia.newTranslation){
			$scope.alerts.push({msg: 'A nova tradução deve ser preenchcoda'});
			return
		}
		trads = materia.trad;
		if(!trads)
			trads = [];
		
		newTrans ={id: -1, txt: materia.newTranslation, choosen: 0};
		trads.push(newTrans);
		materia.newTranslation = '';
		$scope.SelectTranslation(newTrans, materia);
		
	};
	
	$scope.ShowSelectedTranslation = function(materia){
		if(!materia.tradSelected)
			materia.tradSelected = _.max(materia.trad, function(trad){ return trad.choosen; })
		return materia.tradSelected;
	};
	
	$scope.DownloadPDF = function(){
		historico = {semestres: $scope.historico.semestres};
		_.each(historico.semestres, function(semestre){
			_.each(semestre.materias, function(materia){
				materia.trad = [materia.tradSelected];
				delete materia.tradSelected;
				delete materia.newTranslation;
			});
		});
		
		$.post($scope.siteUrl + 'HistoricoController/DownloadPDF', angular.toJson(historico)).
		success(function(data){
			console.log('success: ' + data)
		}).
		error(function(data){
			console.log('error: ' + data)
		});
		
	};
	
	$scope.Initialize = function(){
		blockPage.block();
		$scope.getHistorico();
		blockPage.unblock();
	}
	
	$scope.Initialize();

}]);