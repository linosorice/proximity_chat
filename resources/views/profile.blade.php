@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Profilo</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_edit_profile" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('profile_update') }}" method="post">
				{{ csrf_field() }}
			
				<div class="x_panel">
					<div class="x_title">
						<h2>Modifica Dati</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $account->name; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="surname">Cognome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="surname" name="surname" required="required" class="form-control col-md-7 col-xs-12" value="<?= $account->surname; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Indirizzo email</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="email" name="email" readonly="" class="form-control col-md-7 col-xs-12" value="<?= $account->email; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="surname">Ruolo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label class="control-label">
									<i class="fa fa-user"></i> <?= ucfirst($account->role->name); ?>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Nuova password</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12" />
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

@endsection
