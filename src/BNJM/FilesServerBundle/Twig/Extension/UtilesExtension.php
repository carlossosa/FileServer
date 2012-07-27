<?php
namespace BNJM\FilesServerBundle\Twig\Extension;

class UtilesExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'utiles';
    }
    
    public function getFilters()
    {
        return array ( 
                        'humanreadable' => new \Twig_Filter_Method( $this, 'humanreadable'),
                        );
    }
    
    public function humanreadable( $bytes)
    {
        $KB = 1024;
        $MB = 1024*1024;
        $GB = 1024*1024*1024;
        $TB = 1024*1024*1024*1024; //LO DUDO
        $bytes = floatval($bytes);
        
        if ( $bytes > $TB)
        {
            return round( $bytes/$TB, 2)." TB";
        } else if ( $bytes > $GB) {
            return round( $bytes/$GB, 2)." GB";
        } else if ( $bytes > $MB) {
            return round( $bytes/$MB, 2)." MB";
        } else if ( $bytes > $KB) {
            return round( $bytes/$KB, 2)." KB";
        } else {
            return $bytes." B";
        }
        
    }
}