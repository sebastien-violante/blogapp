<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UploadFile extends AbstractController {

    public function name_generator($length) {
        $code = "abcdefghijklmnopqrstuvwxyz0123456789";
        $result = "";
        while(strlen($result) <= $length){
            $result .= $code[rand(0, strlen($code)-1)];
        }
        return $result;
    }

    public function save_file($file) {
        $extension = $file->guessExtension();
        $filename = $this->name_generator(15).".".$extension;
        $file->move($this->getParameter('image_dir'), $filename);
        return '/_assets/pictures/articles/'.$filename;
    }

    public function update_file($file, $old_file) {
        $file_url = $this->save_file($file);
        try {
            unlink($this->getParameter('replaced_image').$old_file);
        } catch (\Throwable $th) {
            
        }
        return $file_url;
    }
}