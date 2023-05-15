<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ManageFile extends AbstractController {

    // The name_generator method allows to create a random path based on a given number of alphabetical and numerical caracters
    public function name_generator($length) {
        $code = "abcdefghijklmnopqrstuvwxyz0123456789";
        $result = "";
        while(strlen($result) <= $length){
            $result .= $code[rand(0, strlen($code)-1)];
        }
        return $result;
    }

    // The save_file method allows return the path (image) where the file is saved
    public function save_file($file) {
        $extension = $file->guessExtension();
        $filename = $this->name_generator(15).".".$extension;
        $file->move($this->getParameter('image_dir'), $filename);
        return '/_assets/pictures/articles/'.$filename;
    }

    // In case of update, the update_file method allows to delete the former file and to save the path to the new one
    public function update_file($file, $old_file) {
        $file_url = $this->save_file($file);
        try {
            unlink($this->getParameter('replaced_image').$old_file);
        } catch (\Throwable $th) {
            
        }
        return $file_url;
    }

    // In case of update, the remove_file method allows to delete the former saved file
    public function remove_file($file_url) {
        try {
            unlink($this->getParameter('replaced_image').$file_url);
            return true;
        } catch (\Throwable $th) {
            return false;
        }   
    }
}