<?php

namespace ateliercv;

class Init {

	public function __construct() {

		self::registerClasses();

	}

	/**
	 * Array with names classes
	 */
	public static function initClasses() {
		return [
			AtelierCv::class,
			StyleCssApi::class
		];
	}

	/**
	 * Static method create instance Class
	 */
	public static function registerClasses() {

		foreach ( self::initClasses() as $class ) {
			if(class_exists($class)) {
				$instance = $class;
				$class = new $instance;
			}
		}

	}

	public static function editDate($date) {

		$date = explode('/',$date);


	}

}