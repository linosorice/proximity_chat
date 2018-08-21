@extends('layouts.app')

@section('content')
	<!-- top tiles -->
	<div class="row tile_count">
		<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
			<span class="count_top"><i class="fa fa-user"></i> Company</span>
			<div class="count"><?= count($companies); ?></div>
			<span class="count_bottom"><i class="green">4% </i> Create e attive</span>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
			<span class="count_top"><i class="fa fa-clock-o"></i> Store</span>
			<div class="count"><?= count($stores); ?></div>
			<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> Creati</span>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
			<span class="count_top"><i class="fa fa-users"></i> Gruppi</span>
			<div class="count"><?= count($groups); ?></div>
			<span class="count_bottom">Attivi <i class="green"><?= count($groups->where('store_id', NULL)); ?></i> Free e <i class="green"><?= count($groups->where('store_id', '<>', NULL)); ?></i> Premium</span>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
			<span class="count_top"><i class="fa fa-user"></i> Utenti</span>
			<div class="count green"><?= count($users); ?></div>
			<span class="count_bottom">Registrati dal <i class="red"><?= date("d/m/Y", strtotime($date_signup->created_at)); ?></i></span>
		</div>
	</div>
	<!-- /top tiles -->
		
			
@endsection
