<?php

namespace Smirik\PropelAdminBundle\Column;

use Symfony\Component\Finder\Finder;

class FileColumn extends Column
{
    
    protected $required_options = array('upload_path');

	public function getAlias()
	{
		return 'file';
	}
    
    public function getView($item)
    {
        $getter = 'get'.$this->getGetter();
        $file   = $item->{$getter}();
        if ($file == '') {
            return false;
        }
        $ext = $this->guessExtension($file);
        if ($ext) {
            return $ext;
        }
        return 'file';
    }
    
    public function getUploadPath()
    {
        if (isset($this->options['upload_path'])) {
            return $this->options['upload_path'];
        }
        return false;
    }
    
    public function guessExtension($file)
    {
        if (strpos($file, '.') === false)
        {
            return 'file';
        }
        $tmp = explode('.', $file);
        $ext = $tmp[count($tmp)-1];
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../Resources/public/images/file/')->name($ext.'.png');
        
        if (count($finder) > 0)
        {
            return $ext;
        }
        
        return false;
    }
    
    public function randomizeName()
    {
        if (isset($this->options['randomize_name']) && $this->options['randomize_name']) {
            return true;
        }
        return false;
    }

}
