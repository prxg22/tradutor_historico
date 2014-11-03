<?php include '_inc/header.php';?>
<!-- CONTENT -->
<div ng-controller="HistoricoController">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" ng-repeat="semestre in historico.semestres">
				<div class="panel-heading">
					<strong>{{$index+1}}º semestre</strong>
				</div>
				<div class="panel-body">
					<table class="table center-box">
						<thead>
							<tr>
								<th>Nome Original</th>
								<th>Traduções</th>
								<th>Menção</th>
							</tr>
						</thead>
						
						<tbody>
							<tr ng-repeat="materia in semestre.materias">
								<td>{{materia.orig}}</td>
								<td>
									<div>
										<div class="pointer" ng-hide="materia.showTrans" ng-click="materia.showTrans = true">
											{{ShowSelectedTranslation(materia).txt}} <span class="small trad-type" ng-show="ShowSelectedTranslation(materia).type == 'gt'">Google Translator</span><span class="caret"></span>
										</div>
										<div class="list-group" ng-show="materia.showTrans">
											<a href="javascript:void(0)" ng-click="SelectTranslation(trad, materia)" ng-class="{active: trad == materia.tradSelected}" class="list-group-item pointer" ng-repeat="trad in materia.trad | orderBy:'choosen':true">
												{{trad.txt}} <span class="small trad-type" ng-show="trad.type == 'gt'">Google Translator</span><span class="badge">{{trad.choosen}}</span>
											</a>
											<div class="list-group-item">
												<div class="form-group">
													<input class="form-control" ng-model="materia.newTranslation" placeholder="Outro" ng-blur="SelectNewTranslation(materia)" />
												</div>
											</div>
										</div>
									</div>
								</td>
								<td>{{materia.nota}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
					<div class="btn btn-lg btn-block btn-success margin-bottom-10" ng-click="DownloadPDF()">
						<span class="glyphicon glyphicon-print"></span>&nbsp;Baixar em PDF
					</div>
			</div>
		</div>
	</div>
</div>
<script src="<?=base_url();?>public/scripts/HistoricoController.js"></script>
<!-- END OF CONTENT -->
<?php include '_inc/footer.php';?>