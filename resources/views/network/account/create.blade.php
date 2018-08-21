@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Gestione Rete <small><i class="fa fa-angle-right"></i> Crea Account</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_create_company" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('account_insert') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Account</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Cognome</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="surname" name="surname" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
					</div>
				</div>
			
				<div class="x_panel">
					<div class="x_title">
						<h2>Associa Company</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Company <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select multiple="multiple" class="form-control col-md-7 col-xs-12" id="companies_id" name="companies_id[]" required="">
									<?php foreach($companies as $company): ?>
										<option value="<?= $company->id; ?>"><?= $company->name; ?></option>
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
		$("#companies_id").select2();
	});
@endsection
