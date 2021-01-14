<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
	protected $template_data ;	

	function set($content_area, $value)
	{	
		switch ($content_area) {
			case 'headLink':
					$stylesheet = "" ;

					if (!empty($value)) {
						foreach ($value as $item) {
							$stylesheet .= '<link href="'.$item.'" rel="stylesheet">';
						}
					}
						
					$this->template_data[$content_area] = $stylesheet ;
				break;

			case 'headScript':
					$script = "" ;

					if (!empty($value)) {
						foreach ($value as $item) {
							$script .= '<script src="'.$item.'"></script>' ;
						}
					}

					$this->template_data[$content_area] = $script ;
				break;

			default:
				$this->template_data[$content_area] = $value;
				break ;
		}
	}

	function load($template = '', $name ='', $view = '' , $view_data = array(), $return = FALSE)
	{               
		$this->CI =& get_instance();

		$this->set($name , $this->CI->load->view($view, $view_data, TRUE));
		$this->CI->load->view('layout/'.$template, $this->template_data);
	}

	function setStatics($name,$view_data = array()){
		$this->CI =& get_instance();

		$this->CI->load->view('layout/statics/'.$name,$view_data);
	}
}