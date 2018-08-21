@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Gestione Rete <small><i class="fa fa-angle-right"></i> Modifica Company</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_create_company" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('company_update') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Company</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $company->name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Indirizzo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="address" name="address" class="form-control col-md-7 col-xs-12" value="<?= $company->address; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="zip_code">Cap</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="zip_code" name="zip_code" class="form-control col-md-7 col-xs-12" value="<?= $company->zip_code; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Provincia <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="province" name="province" required="" onchange="getCities(this.value)">
									<option value="">Seleziona..</option>
									<?php foreach($provinces as $province): ?>
										<option value="<?= $province->name; ?>" <?php if($city_data->province==$province->name) echo "selected"; ?>><?= $province->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Città <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="city_id" name="city_id" required="">
									<option value="">Seleziona..</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number">Telefono</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="phone_number" name="phone_number" class="form-control col-md-7 col-xs-12" value="<?= $company->phone_number; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vat_number">Partita Iva</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="vat_number" name="vat_number" class="form-control col-md-7 col-xs-12" value="<?= $company->vat_number; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tax_code">Codice Fiscale</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="tax_code" name="tax_code" class="form-control col-md-7 col-xs-12" value="<?= $company->tax_code; ?>">
							</div>
						</div>
					</div>
				</div>
			
				<div class="x_panel">
					<div class="x_title">
						<h2>Associa Account</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Account <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select multiple="multiple" class="form-control col-md-7 col-xs-12" id="accounts_id" name="accounts_id[]" required="">
									<?php foreach($accounts as $account): ?>
										<option value="<?= $account->id; ?>" <?php if(in_array($account->id, $accounts_associated)) echo "selected"; ?>><?= $account->name; ?> <?= $account->surname; ?> (<?= $account->email; ?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
								<button type="button" class="btn btn-sm btn-default" onclick="modalCreateAccount();">Crea nuovo</button>
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
				
				<input type="hidden" name="company_id" id="company_id" value="<?= $company->id; ?>" />
			</form>
			
		</div>
	</div>
	
	@include('network.company.create_account')
@endsection

@section('scripts')
	function modalCreateAccount() {
		$('#modal_create_account').modal('show');
	}
	
	function insertAccount() {
		$.ajax({
			type: "POST",
			url: "{{ route('account_insert_fast') }}",
			data: $('#form_create_account').serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(output) {
				var account = jQuery.parseJSON(output);
				$('#accounts_id').append('<option value="' + account.id + '">' + account.name + ' ' + account.surname + ' (' + account.email + ')</option>');
				
				$('#modal_create_account').modal('hide');
			}
		});
	}

	function getCities(province_name) {
		$.ajax({
			type: "POST",
			url: "{{ route('cities_get') }}",
			data: { province_name: province_name },
			async: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(output) {
				if(output=="") {
					$('#city_id').html('<option value="">Seleziona..</option>');
				} else {
					var cities = jQuery.parseJSON(output);		
					
					$('#city_id').html('<option value="">Seleziona..</option>');
					for(var i=0; i<cities.length; i++) {
						$('#city_id').append('<option value="' + cities[i].id + '">' + cities[i].name + '</option>');
					}
				}
			}
		});
	}
	
	$(document).ready(function() {
		getCities('<?= $city_data->province; ?>', 'edit');
		$('#city_id').val(<?= $company->city_id; ?>);
		
		$("#accounts_id").select2();
	});
@endsection
