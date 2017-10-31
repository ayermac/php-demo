<?php
class image{
    private $info;
    private $image;
    public function __construct($src){
        $info=getimagesize($src);
        $this->info=array(
          "width"=>$info[0],
            "height"=>info[1],
            "type"=>image_type_to_extension($this->info['2'],false),
            "mime"=>$info['mime']  
        );
        
        $fun="imagecreatefrom($this->info['type])";
        $this->image=$fun($src);
    }
    public funtion thumb($width,$height){
        $this->image_thumb=imagecreatetruecolor($width,$height);
        $this->imagecopyresampled($image_thumb,$this->image,0,0,0,0,$width,$height,$this->info['width'],$this->info['height']);
        imagedestroy($this->image);
        $this->image=$image_thumb;
    }
    public function show(){
        header("Content-type:".$this->info['mime']);
        $funs="image($this->info['type])";
        $funs($this->image);
    }
    public funtion save($newname){
        $funs="image($this->info['type])";
        $funs($this->image,$newname.'.'.$this->info['type']);
        
    }
    public funtion __destruct(){
        imagedestroy($this->image);
    }
}



?>