@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Gruppo "<?= $group->name; ?>" <small><i class="fa fa-angle-right"></i> Impostazioni</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_edit_group_settings" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('group_settings_update') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Generale</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12" readonly="" value="<?= $group->name; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Store</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="store_name" name="store_name" class="form-control col-md-7 col-xs-12" readonly="" value="<?= $group->store->name; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Tipo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="type" name="type" class="form-control col-md-7 col-xs-12" readonly="" value="<?php if($group->store_id!=NULL) echo "Premium"; else echo "Free"; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="created_at">Creato il</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="created_at" name="created_at" class="form-control col-md-7 col-xs-12" readonly="" value="<?= date("d-m-Y H:i"); ?>" />
							</div>
						</div>
						
						<hr />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_enabled">Attivo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="is_enabled" id="is_enabled" value="1" <?php if($group->is_enabled==1) echo "checked"; ?> />
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_enabled">Orario di Apertura</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								dalle <div class="input-group bootstrap-timepicker timepicker col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="time_start" id="time_start" class="form-control timepicker" value="<?= $group->time_start; ?>" />
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
								</div> alle
								<div class="input-group bootstrap-timepicker timepicker col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="time_end" id="time_end" class="form-control timepicker" value="<?= $group->time_end; ?>" />
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
								</div>
								<p><a href="javascript:void(0);" onclick="resetTime();">Reset orario</a></p>
								<p><i class="fa fa-question-circle"></i> Se l'orario di apertura e di chiusura coincidono, il gruppo è sempre aperto</p>
							</div>
						</div>						
					</div>
				</div>
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Modalità di Accesso</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_enabled">Accesso per Distanza</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="access_distance" id="access_distance" value="1" onchange="setAccess('distance');" <?php if($group->access_distance_range!=NULL) echo "checked"; ?> />
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Range <span class="required <?php if($group->access_distance_range==NULL) echo "hide"; ?>" id="distance_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="input-group">
									<input type="number" id="access_distance_range" name="access_distance_range" required="required" <?php if($group->access_distance_range==NULL) echo "disabled=''"; ?> class="form-control col-md-7 col-xs-12" value="<?= $group->access_distance_range; ?>" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default">metri</button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="access_beacons">Accesso con Beacons</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="access_beacons" id="access_beacons" value="1" onchange="setAccess('beacons');" <?php if(!count($group->beacons)==0) echo "checked"; ?> />
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_id">Beacons <span class="required <?php if(count($group->beacons)==0) echo "hide"; ?>" id="beacons_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select multiple="multiple" class="form-control col-md-7 col-xs-12" id="beacons_id" name="beacons_id[]" required="" <?php if(count($group->beacons)==0) echo "disabled=''"; ?>>
									<?php foreach($store->beacons->where('is_enabled', 1) as $beacon): ?>
										<option value="<?= $beacon->id; ?>" <?php if(in_array($beacon->id, $beacons_associated)) echo "selected"; ?>><?= $beacon->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="access_qrcodes">Accesso con QrCodes</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="access_qrcodes" id="access_qrcodes" value="1" onchange="setAccess('qrcodes');" <?php if(!count($group->qrcodes)==0) echo "checked"; ?> />
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="qrcodes_id">QrCodes <span class="required <?php if(count($group->qrcodes)==0) echo "hide"; ?>" id="qrcodes_req">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select multiple="multiple" class="form-control col-md-7 col-xs-12" id="qrcodes_id" name="qrcodes_id[]" required="" <?php if(count($group->qrcodes)==0) echo "disabled=''"; ?>>
									<?php foreach($store->qrcodes->where('is_enabled', 1) as $qrcode): ?>
										<option value="<?= $qrcode->id; ?>" <?php if(in_array($qrcode->id, $qrcodes_associated)) echo "selected"; ?>><?= $qrcode->name; ?></option>
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
	function setAccess(type) {
		if(type=="distance") {
			if($('#access_distance').is(':checked')) {
				$('#access_distance_range').val('');
				$('#access_distance_range').attr('disabled', false);
				$('#distance_req').removeClass('hide');
			} else {
				$('#access_distance_range').val('');
				$('#access_distance_range').attr('disabled', true);
				$('#distance_req').addClass('hide');
			}
		} else if(type=="beacons") {
			if($('#access_beacons').is(':checked')) {
				$('#beacons_id').val('').trigger('change');
				$('#beacons_id').attr('disabled', false);
				$('#beacons_req').removeClass('hide');
			} else {
				$('#beacons_id').val('').trigger('change');
				$('#beacons_id').attr('disabled', true);
				$('#beacons_req').addClass('hide');
			}
		} else if(type=="qrcodes") {
			if($('#access_qrcodes').is(':checked')) {
				$('#qrcodes_id').val('').trigger('change');
				$('#qrcodes_id').attr('disabled', false);
				$('#qrcodes_req').removeClass('hide');
			} else {
				$('#qrcodes_id').val('').trigger('change');
				$('#qrcodes_id').attr('disabled', true);
				$('#qrcodes_req').addClass('hide');
			}
		}
	}
	
	function addZero(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
	
	function resetTime() {
		var d = new Date();
		
		$('#time_start').val(addZero(d.getHours()) + ':' + addZero(d.getMinutes()));
		$('#time_end').val(addZero(d.getHours()) + ':' + addZero(d.getMinutes()));
	}

	$(document).ready(function() {
		$("#beacons_id").select2();
		$("#qrcodes_id").select2();
		
		$(".timepicker").timepicker({
			showInputs: false,
			showMeridian: false,
			minuteStep: 1
		});
	});
@endsection
