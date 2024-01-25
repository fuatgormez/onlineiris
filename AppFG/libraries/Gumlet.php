<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Gumlet Library
 * Resize()
 * https://packagist.org/packages/gumlet/php-image-resize
 */

Class Gumlet
{
    private $Image;

    public function crop($file, $output, $width, $height)
    {
        try {
            $this->Image = new \Gumlet\ImageResize($file);
            $this->Image->crop($width, $height);
            $this->Image->save($output);
        } catch (Exception $e) {
            echo 'Ein Fehler ist aufgetreten' . '<br>';
            echo $e->getMessage();
        }
    }

    public function resize($file, $output, $width, $height)
    {
        try {
            $this->Image = new \Gumlet\ImageResize($file);
            $this->Image->resizeToBestFit($width, $height);
            $this->Image->save($output);
        } catch (Exception $e) {
            echo 'Ein Fehler ist aufgetreten' . '<br>';
            echo $e->getMessage();
        }
    }
}
