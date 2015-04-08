    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://brokenpicture.com">Broken Picture</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="http://brokenpicture.com">Home</a></li>
            <li><a href="#about">How do I play?</a></li>
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Play! <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="start.php">Instant Game</a></li>
                    <li><a href="mygames.php">My Games</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
          </ul>
          <ul class="navbar-text navbar-right">
                <li class="dropdown">
                    <?php echo $greeting ?>  
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings</a></li>
                        <li><a href="#" onclick="logout();">Log out</a></li>
                    </ul>
                </li>
              </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>