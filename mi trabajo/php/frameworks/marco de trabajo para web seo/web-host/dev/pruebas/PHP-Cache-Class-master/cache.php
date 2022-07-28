<?php

class Cache{
   public $content;
   public $life = 3600; // 1 hour
   public $path = 'cache/';

   function get( $id ){
      $this->id = $id;
      $path = $this->getPath();
      if( file_exists( $path ) && ( time() < ( filemtime( $path ) + $this->life ) ) ){
         return file_get_contents( $path );
      }
   }
   
   function start(){
      ob_start();
   }
   
   function finish(){
      $this->content = ob_get_contents();
      ob_end_clean();
      return $this->content;
   }
   
   function save(){
      if( $this->id ){
         $path = $this->getPath();         
         $handler = fopen( $path, 'w' );
         fwrite( $handler, $this->content );
         fclose( $handler );
      }
   }
   
   function getPath(){
      return $this->path . $this->id;
   }
}

?>