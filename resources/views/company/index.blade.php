@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class="fa fa-users"></i> Gestione Gruppi</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-xs-3">
						<ul class="nav nav-tabs tabs-left">
							<?php $index = 1; ?>
							<?php foreach(Auth::user()->companies as $company): ?>
								<?php foreach($company->stores as $store): ?>
									<li <?php if($index==1) echo 'class="active"'; ?>>
										<a href="#tab_pane_<?= $store->id; ?>" data-toggle="tab"><?= $store->name; ?></a>
									</li>
									<?php $index++; ?>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="col-xs-9">
						<div class="tab-content">
							<?php $index = 1; ?>
							<?php foreach(Auth::user()->companies as $company): ?>
								<?php foreach($company->stores as $store): ?>
								
									<div class="tab-pane <?php if($index==1) echo 'active'; ?>" id="tab_pane_<?= $store->id; ?>">
										<p class="lead">Gruppi - Store "<?= $store->name; ?>"</p>
										
										<?php if(count($store->groups)==0): ?>
											Nessun gruppo presente
										<?php endif; ?>
										
										<?php foreach($store->groups as $group): ?>
											<div class="col-md-6 col-xs-12 widget widget_tally_box">
												<div class="x_panel ui-ribbon-container">
													<div class="ui-ribbon-wrapper">
														<div class="ui-ribbon <?php if($group->is_enabled==1) echo "bg-green"; else echo "bg-red"; ?>">
															<?php if($group->is_enabled==1) echo "Attivo"; else echo "Disattivo"; ?>
														</div>
													</div>
													<div class="x_content">
														<h3 class="name"><?= $group->name; ?></h3>
														<p>
															<a class="btn btn-danger btn-sm"><i class="fa fa-user"></i> Utenti (<?= count($group->users->where('is_banned', 0)); ?>)</a>
															<a href="{{ route('group_settings', $group->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-cog"></i> Impostazioni</a>
														</p>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									
									<?php $index++; ?>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</div>
					</div>

                    <div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
@endsection
