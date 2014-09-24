
<ul class="nav main-menu">
	<li>
		<a href="dashboard/dashboard/" class="active ajax-link" data-model="Dashboard">
			<i class="fa fa-dashboard"></i>
			<span class="hidden-xs">Geral</span>
		</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Blog">
			<i class="fa fa-file-text"></i>
			<span class="hidden-xs">Blog</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="blog/dashboard/">Listar publicações</a>
			</li>
			<li>
				<a href="blog/compose/">Nova publicação</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle">Categorias</a>
				<ul class="dropdown-menu">
					<li>
						<a href="categories/create/">Adicionar</a>
					</li>
					<li>
						<a href="categories/dashboard/">Visualizar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="blog/comments/">Comentários</a>
			</li>
			<li>
				<a href="blog/configurations/">Configurações</a>
			</li>
		</ul>
	
<?php
if ($headerAdmin->isRoot()) {
    ?>
	
	
	
	
	
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Administrators">
			<i class="fa fa-user"></i>
			<span class="hidden-xs">Administradores</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="administrators/dashboard/">Gerenciar administradores</a>
			</li>
			<li>
				<a href="administrators/create/">Criar administrador</a>
			</li>
		</ul>
	</li>
<?php
}
?>
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Users">
			<i class="fa fa-users"></i>
			<span class="hidden-xs">Usuários do site</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="users/dashboard/">Visualizar usuários registrados</a>
			</li>
			<li>
				<a href="users/register/">Registrar usuário</a>
			</li>
		</ul>
	</li>

	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Orders">
			<i class="fa fa-dollar"></i>
			<span class="hidden-xs">Vendas</span>
		</a>
		<ul class="dropdown-menu">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-model="Orders"> PagSeguro </a>
				<ul class="dropdown-menu">
					<li>
						<a href="orders/pagseguro/">Todas as vendas</a>
					</li>
					<li>
						<a href="orders/pagseguronew/">Novo pedido</a>
					</li>
					<li>
						<a href="pagseguroconfig/edit/1/">Configurações</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>

	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Banners">
			<i class="fa fa-th-large"></i>
			<span class="hidden-xs">Banners</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="banners/dashboard/"> Visualizar banners </a>
			</li>
			<li>
				<a href="banners/add/"> Adicionar banner </a>
			</li>
		</ul>
	</li>

	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Tickets">
			<i class="fa fa-support"></i>
			<span class="hidden-xs">Suporte</span>
		</a>
		<ul class="dropdown-menu">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle">Tickets</a>
				<ul class="dropdown-menu">
					<li>
						<a href="tickets/dashboard/">Ver todos</a>
					</li>
					<li>
						<a href="tickets/create/">Criar novo</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>

	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Mailing">
			<i class="fa fa-envelope"></i>
			<span class="hidden-xs">Mailing</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="mailing/dashboard/"> Visualizar mailing </a>
			</li>
		</ul>
	</li>

	<!--
	Em testes
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-model="Sitemap">
			<i class="fa fa-sitemap"></i>
			<span class="hidden-xs">Sitemap</span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="sitemaps/dashboard/">Informações</a>
			</li>
			<li>
				<a href="sitemaps/generate/">Atualizar agora</a>
			</li>
		</ul>
	</li>
	-->
</ul>