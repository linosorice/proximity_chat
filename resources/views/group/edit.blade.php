@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Gruppi <small><i class="fa fa-angle-right"></i> Modifica Gruppo</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_create_company" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('group_update') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Gruppo</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $group->name; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="radio">
									<label>
										<input type="radio" checked="" value="free" id="type" name="type" onchange="changeType(this.value);" <?php if($group->store_id==NULL) echo "checked"; ?> /> Free
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" value="premium" id="type" name="type" onchange="changeType(this.value);" <?php if($group->store_id!=NULL) echo "checked"; ?> /> Premium
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="latitude">Latitudine <span class="required <?php if($group->store_id!=NULL) echo "hide"; ?>" id="latitude_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="latitude" name="latitude" required="required" <?php if($group->store_id!=NULL) echo "disabled=''"; ?> class="form-control col-md-7 col-xs-12" value="<?= $group->latitude; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="longitude">Longitudine <span class="required <?php if($group->store_id!=NULL) echo "hide"; ?>" id="longitude_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="longitude" name="longitude" required="required" <?php if($group->store_id!=NULL) echo "disabled=''"; ?> class="form-control col-md-7 col-xs-12" value="<?= $group->longitude; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_id">Store <span class="required <?php if($group->store_id==NULL) echo "hide"; ?>" id="store_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="store_id" name="store_id" required="" <?php if($group->store_id==NULL) echo "disabled=''"; ?>>
									<option value="">Seleziona..</option>
									<?php foreach($stores as $store): ?>
										<option value="<?= $store->id; ?>" <?php if($group->store_id==$store->id) echo "selected"; ?>><?= $store->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			
				<div class="x_panel">
					<div class="x_content">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<button type="submit" class="btn btn-primary pull-right">Salva</button>
							</div>
						</div>
					</div>
				</div>
				
				<input type="hidden" name="group_id" id="group_id" value="<?= $group->id; ?>" />
			</form>
			
		</div>
	</div>
@endsection

@section('scripts')
	function changeType(type) {
		if(type=="free") {
			$('#store_id').val('').trigger('change');
			$('#latitude').val('');
			$('#longitude').val('');
			$('#latitude').attr('disabled', false);
			$('#longitude').attr('disabled', false);
			$('#store_id').attr('disabled', '');
			
			$('#latitude_req').removeClass('hide');
			$('#longitude_req').removeClass('hide');
			$('#store_req').addClass('hide');
		} else if(type=="premium") {
			$('#store_id').val('').trigger('change');
			$('#latitude').val('');
			$('#longitude').val('');
			$('#latitude').attr('disabled', '');
			$('#longitude').attr('disabled', '');
			$('#store_id').attr('disabled', false);
			
			$('#latitude_req').addClass('hide');
			$('#longitude_req').addClass('hide');
			$('#store_req').removeClass('hide');
		}
	}

	$(document).ready(function() {
		$("#store_id").select2();
	});
@endsection
