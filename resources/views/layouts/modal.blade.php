<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-wechat"></i> <span>{{ config('settings.app_name') }}</h4>
			</div>
			<div class="modal-body">
				<h4 id="modal_h4"></h4>
				<p id="modal_p"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
				<button type="button" class="btn btn-primary" id="modal_save">Ok</button>
			</div>
		</div>
		
		<form id="modal_action_form" name="modal_action_form" action="" method="POST">
			{{ csrf_field() }}
			<input type="hidden" id="modal_form_item_id" name="modal_form_item_id" value="" />
		</form>
	</div>
</div>