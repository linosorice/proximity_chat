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
					<h2>Lista Company</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="{{ route('company_create') }}">Crea Company</a></li>
					</ul>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="list-company" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Azioni</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($companies as $company): ?>
							<tr>
								<td><?= $company->name; ?></td>
								<td>
									<a href="{{ route('stores_list', $company->id) }}" class="btn btn-xs btn-warning">Lista Store</a>
									<a href="{{ route('company_edit', $company->id) }}" class="btn btn-xs btn-success">Modifica</a>
									<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="alertDeleteCompany(<?= $company->id; ?>);">Cancella</a>
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
	@include('network.company.scripts')
@endsection
