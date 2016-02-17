<?php


class USDV_Form_Base
{
    /**
     * @var array
     */
    var $map = array();


    /**
     * USDV_Form_Base constructor.
     */
    public function __construct()
    {}

    /**
     * Form fields map setter
     *
     * @param $map_file
     * @return void
     */
    protected function setMap( $map_file )
    {
        $handle = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/' . $map_file );
        $this->map = json_decode( $handle, true );
    }

    /**
     * Form fields map getter
     *
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }
}

