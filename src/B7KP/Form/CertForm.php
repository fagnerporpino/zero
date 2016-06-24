<?php
namespace B7KP\Form;

use B7KP\Library\Route;
use B7KP\Library\Options;
use B7KP\Library\Lang;

class CertForm extends Form
{

	function __construct(){}

	public function build($obj = false)
	{
		$this->obj = $obj;
		$options = new Options();
		$cert = $options->get("\B7KP\Entity\Settings", "show_cert");
		$certch = $options->get("\B7KP\Entity\Settings", "show_chart_cert");
		$plaq = $options->get("\B7KP\Entity\Settings", "show_plaque");
		$form = $this
				->init(Route::url("change_settings"))
				->add(self::TYPE_SELECT, "show_cert", "form-control", $cert, "use_cert")
				->add(self::COMMENT, "alb_cert", "form-group text-center")
				->add(self::COMMENT, "gold", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "alb_cert_gold", "form-control")
				->add(self::COMMENT, "plat", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "alb_cert_platinum", "form-control")
				->add(self::COMMENT, "diam", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "alb_cert_diamond", "form-control")
				->add(self::COMMENT, "mus_cert", "form-group text-center")
				->add(self::COMMENT, "gold", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "mus_cert_gold", "form-control")
				->add(self::COMMENT, "plat", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "mus_cert_platinum", "form-control")
				->add(self::COMMENT, "diam", "form-group text-center no-margin")
				->add(self::TYPE_TEXT, "mus_cert_diamond", "form-control")
				->add(self::TYPE_SELECT, "show_chart_cert", "form-control", $certch, "use_cert_cha")
				->add(self::TYPE_SELECT, "show_plaque", "form-control", $plaq, "use_plaque")
				->add(self::TYPE_SUBMIT, "submit", "send btn btn-primary btn-lg")
				->end();
	}

}
?>