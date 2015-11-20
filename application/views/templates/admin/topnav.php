<?php if(sizeof($nav) > 0) { ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php foreach($nav['nav'] as $n):
                        if($n['url'] == '#') { ?>
                            <li id="<?php echo $n['id']; ?>" class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $n['title'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach($n['sub-nav'] as $sn) : ?>
                                        <li><a href="<?php echo base_url() . $sn['url']; ?>"><?php echo $sn['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li id="<?php echo $n['id']; ?>"><a href="<?php echo base_url() . $n['url']; ?>"><?php echo $n['title']; ?></a></li>
                        <?php } endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>