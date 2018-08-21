<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>Menu</h3>
		<ul class="nav side-menu">
			<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
			
			@if(Auth::user()->role_id==1)
				<li><a><i class="fa fa-sitemap"></i> Gestione Rete <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li><a href="{{ route('network') }}">Company/Store</a></li>
						<li><a href="{{ route('account') }}">Account</a></li>
					</ul>
				</li>
				<li><a href="{{ route('group') }}"><i class="fa fa-users"></i> Gruppi</a></li>
				<li><a href="{{ route('beacon') }}"><i class="fa fa-folder-o"></i> Beacon</a></li>
			@endif
			
			@if(Auth::user()->role_id==2)
				<li><a href="{{ route('qrcode') }}"><i class="fa fa-qrcode"></i> QrCode</a></li>
			@endif
		</ul>
	</div>
</div>