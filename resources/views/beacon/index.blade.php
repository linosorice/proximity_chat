@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Beacon</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lista Beacon</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="{{ route('beacon_create') }}">Associa nuovo Beacon</a></li>
					</ul>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="list-beacon" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nome</th>
								<th>UUID</th>
								<th>Store</th>
								<th>Azioni</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($beacon as $beacon): ?>
							<tr>
								<td><?= $beacon->name; ?></td>
								<td><?= $beacon->uuid; ?></td>
								<td><?= $beacon->store->name; ?></td>
								<td>
									<a href="{{ route('beacon_edit', $beacon->id) }}" class="btn btn-xs btn-success">Modifica</a>
									<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="alertDeleteBeacon('<?= $beacon->id; ?>');">Cancella</a>
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
	function alertDeleteBeacon(beacon_id) {
		viewModalAlert('Sei sicuro di voler cancellare il beacon?', '', beacon_id, deleteBeacon);
	}

	function deleteBeacon() {
		$('#modal_action_form').attr('action', '{{ route('beacon_delete') }}');
		$('#modal_action_form').submit();
	}

	$(document).ready(function() {
		$('#list-beacon').DataTable({
			"ordering": false,
			"lengthChange": false,
			"pageLength": 10,
			"columns": [
				{ "width": "22%" },
				{ "width": "30%" },
				{ "width": "23%" },
				{ "width": "25%" }
			]
		});
	});
@endsection
