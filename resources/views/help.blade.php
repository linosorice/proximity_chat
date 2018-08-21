@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Assistenza</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form id="form_send_help" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('help_send') }}" method="post">
				{{ csrf_field() }}
			
				<div class="x_panel">
					<div class="x_title">
						<h2>Contatta il Supporto</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mittente <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" readonly="" class="form-control col-md-7 col-xs-12" value="<?= $account->name; ?> <?= $account->surname; ?> <<?= $account->email; ?>>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject">Oggetto <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="subject" name="subject" required="">
									<option value="Informazioni generali">Informazioni generali</option>
									<option value="Problema tecnico">Problema tecnico</option>
									<option value="Altro">Altro</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text">Testo <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="text" name="text" class="form-control col-md-7 col-xs-12" rows="8" required="" placeholder=""></textarea>
							</div>
						</div>
					</div>
				</div>
			
				<div class="x_panel">
					<div class="x_content">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<button type="submit" class="btn btn-primary pull-right">Invia</button>
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
