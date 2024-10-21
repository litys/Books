<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register CPT Books and Taxonomies
 */
class Li_Books_Register {

  public function __construct() {
    add_action( 'init', [ $this, 'register_books' ] );
    add_action( 'init', [ $this, 'register_books_taxonomies' ] );
  
    add_filter( 'manage_books_posts_columns', [ $this, 'add_books_columns' ] );
    add_action( 'manage_books_posts_custom_column', [ $this, 'books_custom_column' ], 10, 2 );
    add_filter( 'manage_edit-books_sortable_columns', [ $this, 'books_sortable_columns' ] );
    add_action( 'pre_get_posts', [ $this, 'sort_books_by_meta' ] );
  }

  public function register_books() {
    $labels = [
      'name'               => esc_html__( 'Książki', 'li-books' ),
      'singular_name'      => esc_html__( 'Książka', 'li-books' ),
      'menu_name'          => esc_html__( 'Książki', 'li-books' ),
      'name_admin_bar'     => esc_html__( 'Książki', 'li-books' ),
      'add_new'            => esc_html__( 'Dodaj książkę', 'li-books' ),
      'add_new_item'       => esc_html__( 'Dodaj nową książkę', 'li-books' ),
      'edit_item'          => esc_html__( 'Edytuj książkę', 'li-books' ),
      'new_item'           => esc_html__( 'Nowa książka', 'li-books' ),
      'view_item'          => esc_html__( 'Zobacz książkę', 'li-books' ),
      'search_items'       => esc_html__( 'Szukaj książek', 'li-books' ),
      'not_found'          => esc_html__( 'Nie znaleziono książki', 'li-books' ),
      'not_found_in_trash' => esc_html__( 'Nie znaleziono książki w koszu', 'li-books' ),
    ];
  
    $args = [
      'labels'            => $labels,
      'public'            => true,
      'has_archive'       => true,
      'menu_icon'         => 'dashicons-book',
      'supports'          => ['title', 'editor', 'thumbnail'],
      'show_in_menu'      => true,
      'show_in_admin_bar' => true,
      'show_in_rest'      => true,
      'rewrite'           => ['slug' => 'books'],
    ];
  
    register_post_type( 'books', $args );
  }

  public function register_books_taxonomies() {
    register_taxonomy( 'author', 'books', [
      'label'        => esc_html__( 'Autor', 'li-books' ),
      'rewrite'      => ['slug' => 'author'],
      'hierarchical' => false,
      'show_in_rest' => true,
    ] );
  
    register_taxonomy( 'publisher', 'books', [
      'label'        => esc_html__( 'Wydawnictwo', 'li-books' ),
      'rewrite'      => ['slug' => 'publisher'],
      'hierarchical' => true,
      'show_in_rest' => true,
    ] );
  }
  
  /**
   * Add new columns to view for books list
   */
  public function add_books_columns( $columns ) {
    $columns['book_number']  = 'Numer książki';
    $columns['release_date'] = 'Data wydania';
    $columns['price']        = 'Cena';

    return $columns;
  }

  /**
   * Update custom columns data
   */
  public function books_custom_column( $column, $post_id ) {
    if ( $column == 'book_number' ) {
      echo esc_html( get_post_meta( $post_id, '_book_number', true ) );
    } 
    else if ( $column == 'release_date' ) {
      echo esc_html( get_post_meta( $post_id, '_release_date', true ) );
    } 
    else if ( $column == 'price' ) {
      echo esc_html( get_post_meta( $post_id, '_price', true ) );
    }
  }

  /** 
   * Add sorting options for custom columns
   */
  public function books_sortable_columns( $columns ) {
    $columns['book_number']  = 'book_number';
    $columns['release_date'] = 'release_date';
    $columns['price']        = 'price';

    return $columns;
  }

  public function sort_books_by_meta( $query ) {
    if ( $orderby = $query->get('orderby') ) {
      if ( $orderby == 'book_number' ) {
        $query->set( 'meta_key', '_book_number' );
        $query->set( 'orderby', 'meta_value');
      } 
      else if ( $orderby == 'release_date' ) {
        $query->set( 'meta_key', '_release_date' );
        $query->set( 'orderby', 'meta_value' );
      } 
      else if ( $orderby == 'price' ) {
        $query->set( 'meta_key', '_price' );
        $query->set( 'orderby', 'meta_value_num' );
      }
    }
  }

}