<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAEF_Lite_Condition
 *
 * Create a condition rule
 *
 * @class		WAEF_Lite_Condition
 * @author		multisquares
 * @package		WooCommerce Advanced Extra Fees Lite
 * @version		1.0.0
 */
class WAEF_Lite_Condition {

	/**
	 * Condition.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $condition Condition slug.
	 */
	public $condition;

	/**
	 * Operator.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $operaor operator slug.
	 */
	public $operator;

	/**
	 * Value.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $value Condition value.
	 */
	public $value;

	/**
	 * Group ID.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $group Condition grou ID.
	 */
	public $group;

	/**
	 * Condition id.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $id Condition ID.
	 */
	public $id;


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id = null, $group = 0, $condition = null, $operator = null, $value = null ) {

		$this->id        = $id;
		$this->group     = $group;
		$this->condition = $condition;
		$this->operator  = $operator;
		$this->value     = $value;

		if ( ! $id ) :
			$this->id = rand();
		endif;

		$this->waef_create_object();

	}


	/**
	 * Condition rule.
	 *
	 * Create an condition rule object.
	 *
	 * @since 1.0.0
	 */
	public function waef_create_object() {

		?><div class='waef-condition-wrap'><?php

			do_action( 'waef_before_condition', $this );

			$this->waef_lite_condition_conditions();
			$this->waef_lite_condition_operator();
			$this->waef_lite_condition_values();

			$this->waef_add_condition_button();
			$this->waef_remove_condition_button();

			$this->waef_lite_condition_description();

			do_action( 'waef_after_condition', $this );

		?></div><?php

	}


	/**
	 * Condition dropdown.
	 *
	 * Render and load condition dropdown.
	 *
	 * @since 1.0.0
	 */
	public function waef_lite_condition_conditions() {

		waef_lite_condition_conditions( $this->id, $this->group, $this->condition );

	}


	/**
	 * Operator dropdown.
	 *
	 * Render and load operator dropdown.
	 *
	 * @since 1.0.0
	 */
	public function waef_lite_condition_operator() {

		waef_lite_condition_operator( $this->id, $this->group, $this->operator );

	}


	/**
	 * Value dropdown.
	 *
	 * Render and load value dropdown.
	 *
	 * @since 1.0.0
	 */
	public function waef_lite_condition_values() {

		waef_lite_condition_values( $this->id, $this->group, $this->condition, $this->value );

	}


	/**
	 * Add button.
	 *
	 * Display a add button at the end of the condition rule.
	 *
	 * @since 1.0.0
	 */
	public function waef_add_condition_button() {

		?>
		<a class='button condition-add' data-group='<?php echo absint( $this->group ); ?>' href='javascript:void(0);'>+</a>
		<?php

	}


	/**
	 * Remove button.
	 *
	 * Display aa remove button at the end of the condition rule.
	 *
	 * @since 1.0.0
	 */
	public function waef_remove_condition_button() {

		?>
		<a class='button condition-delete' href='javascript:void(0);'>-</a>
		<?php

	}


	/**
	 * Description.
	 *
	 * Display an description at the end of the condition rule.
	 *
	 * @since 1.0.0
	 */
	public function waef_lite_condition_description() {

		waef_lite_condition_description( $this->condition );

	}


}

/**
 * Load condition keys dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-conditions.php';

/**
 * Load condition operator dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-operators.php';

/**
 * Load condition value dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-values.php';

/**
 * Load condition descriptions.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-descriptions.php';
