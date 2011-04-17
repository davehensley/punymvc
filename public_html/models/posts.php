<?php 
/**
 * Posts model
 *
 * A really simple model to demonstrate PunyMVC
 *
 * PHP versions 5
 *
 * @author Dave Hensley <davehensley@gmail.com>
 * @package PunyMVC
 */

/**
 * Posts model
 *
 * A really simple model to demonstrate PunyMVC
 *
 * @package PunyMVC
 */
class PostsModel {

/**
 * The Mongo object
 *
 * @access private
 * @var object
 */
	private $mongo;

/**
 * The MongoDB object
 *
 * @access private
 * @var object
 */
	private $mongoDb;

/**
 * The MongoCollection object
 *
 * @access private
 * @var object
 */
	private $posts;

/**
 * Construct method
 *
 * This method initializes the PostsModel object
 *
 * @access public
 */
	public function __construct() {
		$this->mongo = new Mongo(MONGO_SERVER);
		$this->mongoDb = $this->mongo->{MONGO_DATABASE};
		$this->posts = $this->mongoDb->posts;
	}

/**
 * Find method
 *
 * This method simply executes a find() on a MongoCollection
 *
 * @access public
 * @param array $query The MongoDB query
 * @param array $fields The list of fields to return
 * @return array The resulting data
 */
	public function find($query = array(), $fields = array()) {
		# Very simple example, we just pass the query straight to Mongo
		return iterator_to_array($this->posts->find($query, $fields));
	}
}
