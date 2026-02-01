 <aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="index.php" class="brand-link responsive">
    <center><img src="<?php echo $appLogoImg; ?>" style="width: 180px; height:70px"></center>
    <center><span class="brand-text " style="font-size: 14px; color: white; "><?php echo $appName; ?></span></center>
  </a>

  <div class="sidebar">

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <?php foreach ($permissions as $permission): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $permission['permission_name']; ?>.php"><?php echo ucfirst($permission['permission_modulo']); ?></a>
          </li>
        <?php endforeach; ?>
        
      </ul>
    </nav>

  </div>

</aside>