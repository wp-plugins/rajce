<?php

namespace WPFW\Utils;

class Image
{

    /** @int image types {@link send()} */
    const JPEG = IMAGETYPE_JPEG, PNG = IMAGETYPE_PNG, GIF = IMAGETYPE_GIF;

    /** @var When is from file */
    private $fromFile = NULL;

    /** @var resource */
    private $image = NULL;

    /** @var int width image */
    private $width = NULL;

    /** @var int height image */
    private $height = NULL;

    /**
     * Image from file
     * @param $file
     * @return static
     * @throws Exception
     * @throws UnknownImageFileException
     */
    public function fromFile($file)
    {
        $this->fromFile = $file;
        if( !extension_loaded('gd') )
        {
            throw new Exception('PHP extension GD is not loaded.');
        }

        //static $funcs = array(self::JPEG => 'imagecreatefromjpeg', self::PNG => 'imagecreatefrompng', self::GIF => 'imagecreatefromgif' );
        $info = @getimagesize($this->fromFile); // @ - files smaller than 12 bytes causes read error

        $this->width = $info[0];
        $this->height = $info[1];
        $format = $info[2];

        static $funcs = array(self::JPEG => 'imagecreatefromjpeg', self::PNG => 'imagecreatefrompng', self::GIF => 'imagecreatefromgif',);

        //print_r( $format );
        //print_r( $funcs );

        if( !isset($funcs[$format]) )
        {
            echo "Unknown image type or file '$this->fromFile' not found.";
            throw new UnknownImageFileException("Unknown image type or file '$this->fromFile' not found.");
        }

        $function = $funcs[$format];
        $this->image = $function($this->fromFile);//call function imagecreatefromjpeg / imagecreatefrompng / imagecreatefromgif
    }

    /**
     * Return image width
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
    /**
     * Return image height
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function getFileName()
    {
        if($this->fromFile == NULL )
        {
            throw new \Exception("Image isn't from file. None filename");
        }

        $info = @getimagesize( $this->fromFile ); // @ - files smaller than 12 bytes causes read error
        //print_r( $info );

        $fileName = basename( $this->fromFile );
        if( !$this->checkFileExtension( $fileName ) )
        {
            $format = $info[2];
            $funcs = array( self::JPEG => 'jpg', self::PNG => 'png', self::GIF => 'gif' );

            //isn'nt extension
            $fileName = $fileName.".".$funcs[$format];
        }

        $filename = $this->sanitize( $fileName );
        return $filename;
        /*
        print_r( $filename );
        echo "<br/>";*/
    }



    /**
     * Resizes image.
     * @param  int  width in pixels
     * @param  int  height in pixels
     * @return self
     */
    public function resize ( $width, $height )
    {
        if( $this->image == NULL )
        {
            throw new \Exception( "None image to resize" );
        }

        list( $newWidth, $newHeight ) = $this->calculateSize( $this->getWidth(), $this->getHeight(), $width, $height );

        $resizeImage = imagecreatetruecolor( $newWidth, $newHeight );

        imagecopyresized( $resizeImage, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $this->getWidth(), $this->getHeight() );

        $this->image = $resizeImage;

        return $this;
    }

    /**
     * Calculates dimensions of resized image
     * @param  mixed  source width
     * @param  mixed  source height
     * @param  mixed  width in pixels or percent
     * @param  mixed  height in pixels or percent
     * @return array
     */
    private function calculateSize( $srcWidth, $srcHeight, $newWidth, $newHeight )
    {
        $newWidth = (int) abs($newWidth);
        $newHeight = (int) abs($newHeight);

        $newWidth = round($srcWidth * min(1, $newWidth / $srcWidth));
        $newHeight = round($srcHeight * min(1, $newHeight / $srcHeight));

        return array(max((int) $newWidth, 1), max((int) $newHeight, 1));
    }

    /**
     * Saves image to the file.
     * @param  string  filename
     * @param  int  quality 0..100 (for JPEG and PNG)
     * @param  int  optional image type
     * @return bool TRUE on success or FALSE on failure.
     */
    public function save($file = NULL, $quality = NULL, $type = NULL)
    {
        if ($type === NULL) {
            switch (strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
                case 'jpg':
                case 'jpeg':
                    $type = self::JPEG;
                    break;
                case 'png':
                    $type = self::PNG;
                    break;
                case 'gif':
                    $type = self::GIF;
            }
        }

        switch ($type) {
            case self::JPEG:
                $quality = $quality === NULL ? 85 : max(0, min(100, (int) $quality));
                return imagejpeg($this->image, $file, $quality);
            case self::PNG:
                $quality = $quality === NULL ? 9 : max(0, min(9, (int) $quality));
                return imagepng($this->image, $file, $quality);
            case self::GIF:
                return imagegif($this->image, $file);
            default:
                throw new \Exception('Unsupported image type \'$type\'.');
        }
    }

    private function sanitize($filename)
    {
        $search = array (" ", "&", "$", ",", "!", "?", "@", "#", "^", "(", ")", "+", "=", "[", "]", "%" );
        $replace = array( "_", "and", "S", "_", "", "", "", "", "", "", "", "", "", "", "", "" );
        $filename = str_replace($search,$replace,$filename);

        $lastDot = strrpos($filename, ".");
        return  str_replace(".", "", substr($filename, 0, $lastDot)) . substr($filename, $lastDot);
    }

    private function checkFileExtension( $fileName )
    {
        if(preg_match('/^.+\.[.]{3}$/', $fileName))
        {
            return TRUE;
        }
        else
        {
            return FALSE;

        }
    }

}