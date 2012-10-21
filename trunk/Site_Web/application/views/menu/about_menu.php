		
		<!-- Header (pages visiteurs uniquement) -->
		<header>
			<div class="container">
				<h1>Vraiment innovant !</h1>
				<p class="lead">Vous aussi ne ratez pas la vague WaveBook...</p>
			</div>
		</header>
	
		<!-- Menu -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container" style="width:90%; min-width:973px;">
			  <div class="nav-collapse">
				<a class="brand" href="<?php  echo url('home'); ?>">WaveBook</a>
				<ul class="nav">
				  <li><a href="<?php echo url('home'); ?>"><i class="icon-home"></i> Accueil</a></li>
				  <li><a href="<?php echo url('home/login'); ?>"><i class="icon-hand-right"></i> Connexion</a></li>
				  <li class="active"><a href="<?php  echo url('about'); ?>"><i class="icon-lock"></i> A Propos</a></li>
				</ul> 
				<form class="navbar-search pull-right" method="post" action="<?php  echo url('flux/search'); ?>">
						<input type="text" name="search_query" class="search-query" placeholder="Rechercher" />
				</form>
			  </div>
			</div>
		  </div>
		</nav>
	