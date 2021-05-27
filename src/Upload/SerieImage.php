<?php


namespace App\Upload;


use App\Entity\Serie;

class SerieImage
{

    public function save($file, Serie $serie, $directory){

        $newFileName = $serie->getName().'-'.uniqid().'.'.$file->guessExtension();
        $file->move($directory, $newFileName);
        $serie->setPoster($newFileName);

    }

}