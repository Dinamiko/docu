 
<?php 
    global $post;
    $prevnext_links = docu_get_prevnext_links( $post->ID );
    $previd = $prevnext_links[0];
    $nextid = $prevnext_links[1]; 
?>

<div class="docu-single-nav">

    <?php if ( ! empty( $previd ) ) { ?>

        <div class="docu-single-nav-prev">
            <a rel="prev" href="<?php echo get_permalink( $previd );?>"><?php echo get_the_title( $previd );?></a>
        </div>

    <?php } ?>

    <?php if ( ! empty( $nextid ) ) { ?>

        <div class="docu-single-nav-next">
            <a rel="next" href="<?php echo get_permalink( $nextid );?>"><?php echo get_the_title( $nextid );?></a>
        </div>
      
    <?php } ?>

</div>

