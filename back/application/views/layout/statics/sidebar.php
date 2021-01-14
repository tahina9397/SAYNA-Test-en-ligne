<?php 
	$controllerName = $this->router->fetch_class();
	$actionName = $this->router->fetch_method();

	$activeCategories = ($controllerName == 'categories') ? 'active' : '' ;
	$activeArticles = ($controllerName == 'articles') ? 'active' : '' ;
	$activeTaille = ($controllerName == 'taille') ? 'active' : '' ;
?>

<!-- sidebar -->
<aside class="fixed skin-6">
	<div class="sidebar-inner scrollable-sidebar">
		<div class="main-menu">
			<ul>
				<li class="<?php echo $activeCategories ?>">
					<a href="<?php echo BASE_URL ?>/categories">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Catégories
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<li class="<?php echo $activeTaille ?>">
					<a href="<?php echo BASE_URL ?>/taille">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Taille
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>
				<li class="<?php echo $activeArticles ?>">
					<a href="<?php echo BASE_URL ?>/articles">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Articles
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>
			</ul>
		</div><!-- /main-menu -->
	</div><!-- /sidebar-inner -->
</aside>