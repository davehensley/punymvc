<?php
/**
 * Posts controller
 *
 * A really simple controller to demonstrate PunyMVC
 *
 * PHP versions 5
 *
 * @author Dave Hensley <davehensley@gmail.com>
 * @package PunyMVC
 */

/**
 * Posts controller
 *
 * A really simple controller to demonstrate PunyMVC
 *
 * @package PunyMVC
 */
class PostsController {

/**
 * The default layout used by this controller's views
 *
 * @access public
 * @var string
 */
	public $layout = 'simple';

/**
 * The model used by this controller
 *
 * @access private
 * @var object
 */
	private $Posts;

/**
 * Constructor
 *
 * This method initializes the PostsController object.
 *
 * @access public
 */
	public function __construct() {
		require_once 'models/posts.php';
		$this->Posts = new PostsModel();
	}

/**
 * Index action
 *
 * The default action when no action is specified in the URL.
 *
 * @access public
 * @return array The variables that get passed to the view as $vars
 */
	public function index() {
		$posts = $this->Posts->find();
		return array('posts' => $posts);
	}

/**
 * View action
 *
 * Displays a single Post
 *
 * @param array $args The arguments passed through from the URL
 * @return array The variables that get passed to the view as $vars
 */
	public function view($args) {
		if (ctype_digit($args[0])) {
			$post = $this->Posts->find(array('_id' => intval($args[0])));
		}

		if (!isset($post) || empty($post)) {
			include 'pages/404.php';
			die();
		}

		return array('post' => $post[$args[0]]);
	}
}
