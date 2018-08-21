<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_create_account">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="form_create_account" data-parsley-validate class="form-horizontal form-label-left" data-toggle="validator">
				{{ csrf_field() }}
		
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-wechat"></i> <span>{{ config('settings.app_name') }} | Crea nuovo Account</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="surname">Cognome</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="surname" name="surname" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
					<button type="submit" class="btn btn-primary" id="modal_create_account_save" onclick="insertAccount();">Salva</button>
				</div>
				
				<input type="hidden" id="role_id" name="role_id" value="2" />
			</form>
		</div>
	</div>
</div>	