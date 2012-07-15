<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pros Salud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
 
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
        <?php $auth = Zend_Auth::getInstance();?>
        <a class="brand" href="/index">Pros Salud</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $auth->getIdentity() ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
				<li><a href="/dashboard">Cuadro de mando</a></li>
              <li class="divider"></li>
				 <li><a href="/auth/logout">Logout</a></li>
            </ul>
          </div>
        <div class="nav-collapse">
            <ul class="nav">
			 <?php
 				if ( $auth->hasIdentity()) :
				?>
 				<li><a href="/dashboard">Cuadro de mando</a></li>
				 <li><a href="/auth/logout">Logout</a></li>
				 
				<?php endif;?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row-fluid">
        
  		<?php echo $this->layout()->content ?>
       </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	 <script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/custom.js"></script>
	<script src="/js/bootstrap-transition.js"></script>
	<script src="/js/bootstrap-alert.js"></script>
	<script src="/js/bootstrap-modal.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-scrollspy.js"></script>
	<script src="/js/bootstrap-tab.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-button.js"></script>
	<script src="/js/bootstrap-collapse.js"></script>
	<script src="/js/bootstrap-carousel.js"></script>
	<script src="/js/bootstrap-typeahead.js"></script>

  </body>
</html>
