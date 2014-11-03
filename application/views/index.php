<?php include '_inc/header.php';?>
<!-- CONTENT -->
<div ng-controller="IndexController">
	<div class="jumbotron">
		<h1>Iuuuupi</h1>
		<p class="lead">Um beijo pro maumau, pro fefe, pro cata, pro meu pai, pra você e pra sasha!</p>	
	</div>
	
	<div class='row'>
		<div class='col-md-6'>
			<h3>O que é</h3>
			<hr />
			<p>blablabla</p>
		</div>
		<div class='col-md-6'>
			<h3>Pronto pra começar?</h3>
			<hr />
			<form>
				<div class='form-group'>
					<label for="imat">Matricula</label>
					<input type="text" id="imat" ng-model="aluno.matricula" class="form-control"/>
				</div>
				<div class='form-group'>
					<label for="isenha">Senha do MatrículaWeb</label>
					<input type="password" id="imat" ng-model="aluno.senha" class="form-control" tooltip="Sua senha não será salva!!" tooltip-placement="right" tooltip-trigger="focus" />
				</div>
				<div class='form-group'>
					<div class='btn btn-success' ng-click="Translate()">Translate this shit!!!</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="<?=base_url();?>public/scripts/IndexController.js"></script>
<!-- END OF CONTENT -->
<?php include '_inc/footer.php';?>