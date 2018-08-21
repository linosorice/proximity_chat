@extends('layouts.app')

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="page-title">
		<div class="title_left">
			<h3>Gestione Rete <small><i class="fa fa-angle-right"></i> Modifica Store</small></h3>
		</div>
		<hr />
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		
			<form enctype="multipart/form-data" id="form_edit_store" data-parsley-validate class="form-horizontal form-label-left" action="{{ route('store_update') }}" method="post">
				{{ csrf_field() }}
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Store</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Company</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="company_name" name="company_name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $company_data->name; ?>" disabled="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?= $store->name; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Logo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="logo_image" name="logo_image" type="file" class="file-loading" data-show-preview="true" data-show-upload="false" accept="image/*" />
								<input type="hidden" id="remove_image" name="remove_image" value="0" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Descrizione</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="description" name="description" class="form-control col-md-7 col-xs-12" rows="3" placeholder=""><?= $store->description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Indirizzo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="address" name="address" class="form-control col-md-7 col-xs-12" value="<?= $store->address; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="zip_code">Cap</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="zip_code" name="zip_code" class="form-control col-md-7 col-xs-12" value="<?= $store->zip_code; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Provincia <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="province" name="province" required="" onchange="getCities(this.value)">
									<option value="">Seleziona..</option>
									<?php foreach($provinces as $province): ?>
										<option value="<?= $province->name; ?>" <?php if($city_data->province==$province->name) echo "selected"; ?>><?= $province->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Città <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control col-md-7 col-xs-12" id="city_id" name="city_id" required="">
									<option value="">Seleziona..</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number">Telefono</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="phone_number" name="phone_number" class="form-control col-md-7 col-xs-12" value="<?= $store->phone_number; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number">Email</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" value="<?= $store->email; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number">Website</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="website" name="website" class="form-control col-md-7 col-xs-12" value="<?= $store->website; ?>" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Dati Social</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Facebook</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_facebook" name="profile_facebook" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_facebook; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Twitter</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_twitter" name="profile_twitter" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_twitter; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">YouTube</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_youtube" name="profile_youtube" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_youtube; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Instagram</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_instagram" name="profile_instagram" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_instagram; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Linkedin</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_linkedin" name="profile_linkedin" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_linkedin; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Pinterest</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_pinterest" name="profile_pinterest" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_pinterest; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tripadvisor</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="profile_tripadvisor" name="profile_tripadvisor" class="form-control col-md-7 col-xs-12" value="<?= $store->profile_tripadvisor; ?>" />
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
				
				<input type="hidden" name="store_id" id="store_id" value="<?= $store->id; ?>" />
			</form>
			
		</div>
	</div>
@endsection

@section('scripts')
	function getCities(province_name) {
		$.ajax({
			type: "POST",
			url: "{{ route('cities_get') }}",
			data: { province_name: province_name },
			async: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(output) {
				if(output=="") {
					$('#city_id').html('<option value="">Seleziona..</option>');
				} else {
					var cities = jQuery.parseJSON(output);		
					
					$('#city_id').html('<option value="">Seleziona..</option>');
					for(var i=0; i<cities.length; i++) {
						$('#city_id').append('<option value="' + cities[i].id + '">' + cities[i].name + '</option>');
					}
				}
			}
		});
	}
	
	$('body').on('click', '.fileinput-remove-button', function() {
		$('#remove_image').val('1');
	});

	$('body').on('click', '.fileinput-remove', function() {
		$('#remove_image').val('1');
	});
	
	$(document).ready(function() {
		getCities('<?= $city_data->province; ?>', 'edit');
		$('#city_id').val(<?= $store->city_id; ?>);
		
		$("#logo_image").fileinput({
			browseClass: "btn btn-success",
			browseLabel: "Sfoglia",
			browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
			removeClass: "btn btn-danger",
			removeLabel: "Rimuovi",
			removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
			previewFileType: "image",
			showCaption: false,
			allowedFileExtensions: ["jpg", "png"],
			<?php if($store->logo_image!="" and $store->logo_image!=NULL): ?>
				initialPreview: ["<img src='/<?= config('settings.images_url').'/'.$store->logo_image; ?>' class='file-preview-image' />"]
			<?php endif; ?>
		});
	});
@endsection
