<?php
  require "blog/wp-load.php";
  
  // $args = array('numberposts' => 4,'post__in' => array(74,9,70,42));
  $args = array('numberposts' => 4);
  
  $recent_posts = wp_get_recent_posts( $args );

  $result=array();

  foreach( $recent_posts as $recent ){
    $post['url']=get_permalink($recent["ID"]);
    $post['title']=esc_attr($recent["post_title"]);
    $post['image']=wp_get_attachment_url( get_post_thumbnail_id($recent["ID"]) );
    $post['cdate']=date('F d, Y',strtotime($recent['post_date']));
    $post['author_name']=get_post_meta($recent["ID"], 'author_name', true);
    
    $result[]=$post;
  }

  echo json_encode($result);
?>