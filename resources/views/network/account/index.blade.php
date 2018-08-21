@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Gestione Rete</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lista Account</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="{{ route('account_create') }}">Crea Account</a></li>
					</ul>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="list-account" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Cognome</th>
								<th>Email</th>
								<th>Azioni</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($accounts as $account): ?>
							<tr>
								<td><?= $account->name; ?></td>
								<td><?= $account->surname; ?></td>
								<td><?= $account->email; ?></td>
								<td>
									<a href="{{ route('account_edit', $account->id) }}" class="btn btn-xs btn-success">Modifica</a>
									<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="alertDeleteAccount(<?= $account->id; ?>);">Cancella</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	function alertDeleteAccount(account_id) {
		viewModalAlert('Sei sicuro di voler cancellare l\'account?', '', account_id, deleteAccount);
	}

	function deleteAccount() {
		$('#modal_action_form').attr('action', '{{ route('account_delete') }}');
		$('#modal_action_form').submit();
	}

	$(document).ready(function() {
		$('#list-account').DataTable({
			"ordering": false,
			"lengthChange": false,
			"pageLength": 10,
			"columns": [
				{ "width": "23%" },
				{ "width": "23%" },
				{ "width": "24%" },
				{ "width": "30%" }
			]
		});
	});
@endsection
