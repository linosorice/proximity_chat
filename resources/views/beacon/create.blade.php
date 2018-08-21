@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Beacon <small><i class="fa fa-angle-right"></i> Associa nuovo Beacon</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_create_beacon" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('beacon_insert') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Beacon</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="uuid">UUID <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="uuid" name="uuid" required="required" class="form-control col-md-7 col-xs-12" data-inputmask="'mask' : '********-****-****-****-************'">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="major">Major</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="major" name="major" class="form-control col-md-7 col-xs-12" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="minor">Minor</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="minor" name="minor" class="form-control col-md-7 col-xs-12" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Store <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="store_id" name="store_id" required="">
									<option value="">Seleziona..</option>
									<?php foreach($stores as $store): ?>
										<option value="<?= $store->id; ?>"><?= $store->name; ?></option>
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
			</form>
			
		</div>
	</div>
@endsection

@section('scripts')
	$(document).ready(function() {
		$("#uuid").inputmask();
		$("#stores_id").select2();
	});
@endsection
