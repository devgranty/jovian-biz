<?php 

    function get_image_ext($filename){
    	$filename_arr = str_split($filename);
    	if(in_array(".", $filename_arr)){
    		$image_file = explode(".", $filename);
	        $ext = end($image_file);
	        return $ext;
    	}
    	return "png";
    }
