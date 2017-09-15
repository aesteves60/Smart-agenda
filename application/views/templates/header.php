<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<title><?= $this->config->item('site_name'); ?></title>
	<meta content="index, follow" name="robots" />
	<meta content="#f5f5f5" name="msapplication-TileColor" />
	<link rel="shortcut icon" type="image/x-icon" href="<?= asset_url(); ?>img/favicon.ico" />

	<link rel="stylesheet" href="<?= asset_url(); ?>libs/materialize/css/materialize.min.css">
	<link rel="stylesheet" href="<?= asset_url(); ?>css/style.css">

	<script type="text/javascript">
		const BASE_URL = "<?= base_url(); ?>";
	</script>

	<script type="text/javascript" src="<?= asset_url(); ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?= asset_url(); ?>libs/materialize/js/materialize.min.js"></script>
	<script type="text/javascript" src="<?= asset_url(); ?>js/script.js"></script>

	<link href='<?= asset_url(); ?>libs/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
	<link href='<?= asset_url(); ?>libs/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='<?= asset_url(); ?>libs/fullcalendar/moment.min.js'></script>
	<script src='<?= asset_url(); ?>libs/fullcalendar/fullcalendar.min.js'></script>
	<script src='<?= asset_url(); ?>libs/fullcalendar/locale-all.js'></script>

</head>

<body class="<?= $this->router->fetch_class().' '.$this->router->fetch_method();; ?>">

	<div id="top-page"></div>

	<?php if($this->uri->segment(1) != 'login' && $this->uri->segment(2) != 'inscription') { ?>
	<ul id="slide-out-left" class="side-nav fixed sidebar">

		<li class="logo">
			<a class="logoa" href="<?= base_url(); ?>">
				<h1 id="logo">SmartAgenda</h1>
				<h1 id="logo-small">SA</h1>
			</a>
		</li>
		<?php if(isConnected()){ ?>
		<li class="<?php if(current_url() == base_url() || $this->uri->segment(2) == 'agenda') echo 'active'; ?>">
			<a href="<?= base_url(); ?>">
				<i class="fa fa-home fa-lg"></i>
				<span> Accueil</span>
			</a>
		</li>
		<li class="<?php if($this->uri->segment(2) == 'souscriptions') echo 'active'; ?>">
			<ul class="collapsible collapsible-accordion">
				<li>
					<a class="collapsible-header">
						<i class="fa fa-calendar fa-lg"></i>
						<span> Mon Agenda</span>
					</a>
					<div class="collapsible-body">
						<ul>
							<li class="add_event">
								<a href="#modalAddEvent">Nouvel Evènement</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</li>
		<li class="<?php if($this->uri->segment(2) == 'TODO') echo 'active'; ?>">
			<a href="<?= base_url(); ?>TODO" class="collapsible-header">
				<i class="fa fa-list-ul fa-lg"></i>
				<span> Mes Mémos</span>
			</a>
		</li>
		<li class="<?php if($this->uri->segment(2) == 'Agenda') echo 'active'; ?>">
			<ul class="collapsible collapsible-accordion">
				<li>
					<a class="collapsible-header">
						<i class="fa fa-users fa-lg"></i>
						<span> Ma Famille</span>
					</a>
					<div class="collapsible-body">
						<ul>
							<li class="<?php if($this->uri->segment(3) == 'famille') echo 'active'; ?>">
								<a href="<?= base_url(); ?>">Agenda Familial</a>
							</li>
							<li class="<?php if($this->uri->segment(3) == 'membres') echo 'active'; ?>">
								<a href="<?= base_url(); ?>Account/modif_groupFamille">Membres de la famille</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</li>

		<li class="<?php if($this->uri->segment(2) == 'profil') echo 'active'; ?>">

			<ul class="collapsible collapsible-accordion">
				<li>
					<a class="collapsible-header">
						<i class="fa fa-user fa-lg"></i>
						<span> Mon Profil</span>
					</a>
					<div class="collapsible-body">
						<ul>
							<li class="<?php if($this->uri->segment(2) == 'profil') echo 'active'; ?>">
								<a href="<?= base_url(); ?>Account/modif_user">Modifier</a>
							</li>
							<li class="<?php if($this->uri->segment(2) == 'profil') echo 'active'; ?>">
								<a href="<?= base_url(); ?>Account/choix_group">Gérer les groupes</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>

		</li>

		
		<li id="footer">
			<div class="row">
				<span class="s4 col">
						<!--<img class="circle" src="<?= asset_url(); ?>img/logo-micro.png" title="" >-->
				</span>
				<span class="s4 col">
					<a href="<?= base_url(); ?>Account/modif_user"><i class="fa fa-user fa-2x" aria-hidden="true" title="Profil"></i></a>
				</span>
				<span class="s4 col">
					<a href="<?= base_url(); ?>login/disconnect"><i class="fa fa-sign-out fa-2x" aria-hidden="true" title="Déconnexion"></i></a>
				</span>
			</div>
		</li>
		<?php }?>
	</ul>
	<?php } ?>


	<div class="row" id="container">

		<?php if($this->uri->segment(1) != 'login' && $this->uri->segment(2) != 'inscription') { ?>
		<header id="header" class="row">

<!-- 			<div class="col s6 green_b">10000</div>
      		<div class="col s1 red_b">20000</div>
      		<div class="col s1 red_b">30000</div> -->
			<div class="col s4">
				
				<div class="fil_ariane s12 col">
					<ul>
						<li><a href="#" data-activates="slide-out-left" class="open-sidenav-left"><i class="fa fa-bars fa-lg"></i></a></li>
						<li><a href="#" class="retract-sidenav-left"><i class="fa fa-bars fa-lg"></i></a></li>
						<li><a href="<?= base_url(); ?>">SmartAgenda</a></li>
						<?php if(isset($links_ariane)) foreach ($links_ariane as $link) { ?>
						<li><a href="<?= base_url(); ?>/<?= $link['link']; ?>"><?= $link['title']; ?></a></li>
						<?php } ?>
					</ul>
				</div>

			</div>

			<?php if($this->uri->segment(1) != 'login' && $this->uri->segment(2) == 'agenda') { ?>
			<div class="col s5">
			    <div class="nav-wrapper">
			      <form>
			        <div class="input-field">
			          <input id="search" type="search" class="autocomplete" required placeholder="recherche événement">
			          <label class="label-icon" for="search"><i class="fa fa-search"></i></label>
			        </div>
			      </form>
			    </div>
			</div>
			

			<div class="col s3" ><?php } ?>
<!-- 				<div id="switch-theme" class="switch mg-20 float-right">
					<label>
						<span class="orange">Clair</span>
						<input id="choix-theme" type="checkbox" onchange="switchTheme()">
						<span class="lever"></span>
						Sombre
					</label>
				</div> -->
				<div class="mg-20 float-right" >
					<label id="div_date"></label></br>
					<label id="div_heure"></label>
				</div>
			<?php if($this->uri->segment(1) != 'login' && $this->uri->segment(2) == 'agenda') { ?>
			</div>
			<?php } ?>
		</header>
		<?php } ?>


		<main class="board">

			<?php if($this->uri->segment(1) != 'login' && $this->uri->segment(2) != 'inscription') { ?>
			<div class="row">

				<?php echo $this->load->view('modules/notification', NULL, TRUE); ?>

			</div>
			<?php } ?>
