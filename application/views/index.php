<?php include '_inc/header.php';?>
<!-- CONTENT -->
<div ng-controller="IndexController">

	<div class="bs-callout bs-callout-info">
		<div class="row">
			<div class="col-md-2">
				<img width="50" heigt="50" src="<?=base_url();?>public/img/chico.jpg" alt="..." class="img-circle">
			</div>
			<div class="col-md-4">
				<h4>Faça issso</h4>
				<p>babllbalbalbalbalblbalbal</p>
			</div>
		</div>
	</div>
	<div class="bs-callout bs-callout-border-right bs-callout-danger">
		<div class="row">
			<div class="col-md-offset-2 col-md-4">
				<h4>Faça issso</h4>
				<p>babllbalbalbalbalblbalbal</p>
			</div>
			<div class="col-md-2">
				<img width="50" heigt="50" src="<?=base_url();?>public/img/chico.jpg" alt="..." class="img-circle">
			</div>
		</div>
	</div>
	
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
			<form ng-submit="Translate()">
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