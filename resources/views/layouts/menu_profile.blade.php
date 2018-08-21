<div class="profile clearfix">
	<div class="profile_pic">
		<img src="{{ asset('/images/static/img.jpg') }}" alt="..." class="img-circle profile_img">
	</div>
	<div class="profile_info">
		<span>Benvenuto,</span>
		<h2>{{ Auth::user()->name }} {{ Auth::user()->surname }}</h2>
	</div>
</div>