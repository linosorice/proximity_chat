@extends('layouts.app')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>QrCodes</h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lista QrCodes</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="{{ route('qrcode_create') }}">Crea nuovo QrCode</a></li>
					</ul>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="list-qrcode" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>QrCode</th>
								<th>Nome</th>
								<th>Code</th>
								<th>Store</th>
								<th>Azioni</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($qrcodes as $qrcode): ?>
							<tr>
								<td><a href="javascript:void(0);" onclick="viewQrCode('<?= $qrcode->image; ?>');"><img src="{{ asset('/images/qrcodes') }}/<?= $qrcode->image; ?>" width="50" /></a></td>
								<td><?= $qrcode->name; ?></td>
								<td><?= $qrcode->code; ?></td>
								<td><?= $qrcode->store->name; ?></td>
								<td>
									<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="alertDeleteQrCode('<?= $qrcode->id; ?>');">Cancella</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_view_qrcode">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<img src="" id="img_src_qrcode" width="90%" />
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	function viewQrCode(qrcode_image) {
		$('#img_src_qrcode').attr("src", "{{ asset('/images/qrcodes') }}/" + qrcode_image);
		$('#modal_view_qrcode').modal('show');
	}

	function alertDeleteQrCode(qrcode_id) {
		viewModalAlert('Sei sicuro di voler cancellare il QrCode?', 'Verranno eliminate anche tutte le associazioni su eventuali gruppi', qrcode_id, deleteQrCode);
	}

	function deleteQrCode() {
		$('#modal_action_form').attr('action', '{{ route('qrcode_delete') }}');
		$('#modal_action_form').submit();
	}

	$(document).ready(function() {
		$('#list-qrcode').DataTable({
			"ordering": false,
			"lengthChange": false,
			"pageLength": 10,
			"ordering": true,
			"columns": [
				{ "width": "10%" },
				{ "width": "20%" },
				{ "width": "30%" },
				{ "width": "25%" },
				{ "width": "25%" }
			]
		});
	});
@endsection
