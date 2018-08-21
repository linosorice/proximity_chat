@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Gruppi</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lista Gruppi</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="{{ route('group_create') }}">Crea nuovo Gruppo</a></li>
					</ul>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="list-group" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Tipo</th>
								<th>Store</th>
								<th>Azioni</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($groups as $group): ?>
							<tr>
								<td><?= $group->name; ?></td>
								<td>
									<?php if($group->store_id==NULL): ?>
										Free
									<?php else: ?>
										Premium
									<?php endif; ?>
								</td>
								<td><?php if($group->store_id!=NULL) echo $group->store->name; ?></td>
								<td>
									<a href="{{ route('group_edit', $group->id) }}" class="btn btn-xs btn-success">Modifica</a>
									<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="alertDeleteGroup('<?= $group->id; ?>');">Cancella</a>
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
	function alertDeleteGroup(group_id) {
		viewModalAlert('Sei sicuro di voler cancellare il gruppo?', '', group_id, deleteGroup);
	}

	function deleteGroup() {
		$('#modal_action_form').attr('action', '{{ route('group_delete') }}');
		$('#modal_action_form').submit();
	}

	$(document).ready(function() {
		$('#list-group').DataTable({
			"ordering": false,
			"lengthChange": false,
			"pageLength": 10,
			"ordering": true,
			"columns": [
				{ "width": "25%" },
				{ "width": "15%" },
				{ "width": "30%" },
				{ "width": "30%" }
			]
		});
	});
@endsection
