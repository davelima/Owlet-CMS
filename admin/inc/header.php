<?php
$headerAdmin = new Model\Administrators();
if(!$headerAdmin->isAuthenticated()){
    header("Location: /admin/login/");
    exit;
}
$headerMessages = new Model\Messages();
?>
		<div class="container-fluid expanded-panel">
			<div class="row">
				<div id="logo" class="col-xs-12 col-sm-2">
					<a href="/admin/">Admin</a>
				</div>
				<div id="top-panel" class="col-xs-12 col-sm-10">
					<div class="row">
						<div class="col-xs-8 col-sm-4">
							<a href="#" class="show-sidebar">
								<i class="fa fa-bars"></i>
							</a>
							<!--
							<div id="search">
								<input type="text" placeholder="pesquisar" />
								<i class="fa fa-search"></i>
							</div>
							-->
						</div>
						<div class="col-xs-4 col-sm-8 top-panel-right">
							<ul class="nav navbar-nav pull-right panel-menu">
						        <li class="hidden-xs dropdown">
						          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						              <i class="fa fa-rss"></i>
						          </a>
						          <ul class="dropdown-menu" id="rssfeeds">
						              <li class="divider"></li>
						              <li>
						                  <a href="rss/dashboard/"><i class="fa fa-cog"></i> Configurar</a>
						              </li>
						          </ul>
						        </li>
								<li class="hidden-xs">
									<a href="messages/dashboard/" class="ajax-link">
										<i class="fa fa-envelope"></i>
										<span class="badge"><?php echo $headerMessages->countUnread();?></span>
									</a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
										<span class="avatar">
											<img src="<?php echo \Extensions\Gravatar::Retrieve($_SESSION['administrator']->getEmail(), 40);?>" class="img-rounded" alt="avatar" />
										</span>
										<i class="fa fa-angle-down pull-right"></i>
										<span class="user-mini pull-right">
											<span class="welcome">Bem-vindo,</span>
											<span><?php echo $_SESSION['administrator']->getName();?></span>
										</span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="administrators/edit/<?php echo $_SESSION['administrator']->getId();?>/">
												<i class="fa fa-user"></i>
												<span class="hidden-sm text">Minha Conta</span>
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-cog"></i>
												<span class="hidden-sm text">Configurações</span>
											</a>
										</li>
										<li>
											<a href="logout/">
												<i class="fa fa-power-off"></i>
												<span class="hidden-sm text">Logout</span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>