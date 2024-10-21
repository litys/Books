<?php
/**
 * Plugin Name: Books
 * Description: This plugin adds a Custom Post Data named "Books" with two taxonomies and custom metadata.
 * Version: 1.0.0
 * Author URI: https://github.com/litys
 * Text Domain: li-books
 * Domain Path: /languages
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Li_Books {

  public function __construct() {
    $this->load_files();
    $this->init_plugin();
    $this->load_textdomain(); 
  }

  public function load_files() {
    require_once( __DIR__ . '/inc/register-books.php' );
    require_once( __DIR__ . '/inc/register-books-metaboxes.php' );
    require_once( __DIR__ . '/inc/taxonomy-author.php' );
  }

  public function init_plugin() {
    new Li_Books_Register();
    new Li_Books_Metadata();
    new Li_Books_Author_Metadata();
  }

  public function load_textdomain() {
    load_plugin_textdomain( 'li-books', false, __DIR__ . '/languages/' );
  }
}

new Li_Books();