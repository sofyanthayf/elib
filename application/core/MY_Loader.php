<?php

class MY_Loader extends CI_Loader {

    public function __construct()
	{
		parent::__construct();
	}

    public function template($template_name, $vars = array(), $return = FALSE)
    {
        if($return):
        $content  = $this->view('layout/header', $vars, $return);
        // $content  = $this->view('layout/nav', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('layout/footer', $vars, $return);

        return $content;
    else:
        $this->view('layout/header', $vars);
        // $this->view('layout/nav', $vars);
        $this->view($template_name, $vars);
        $this->view('layout/footer', $vars);
    endif;
    }


}
