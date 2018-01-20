<?php
/**
 * Class SampleTest
 *
 * @package Docu
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {

		global $wpdb;
		$this->assertEquals( 'wptests_', $wpdb->prefix );
	}
}
