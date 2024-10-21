<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add metadata for CPT Books
 */
class Li_Books_Metadata {

  public function __construct() {
    add_action( 'add_meta_boxes', [ $this, 'add_books_meta_boxes'] );
    add_action( 'save_post', [ $this, 'save_books_meta' ] );
  }

  public function add_books_meta_boxes() {
    add_meta_box(
      'books_meta_box',
      esc_html__( 'Pola dodatkowe', 'li-books' ),
      [ $this, 'render_books_meta_box' ],
      'books',
      'normal',
      'high'
    );
  }
  
  public function render_books_meta_box($post) {
    $book_data = [
      'number'       => get_post_meta( $post->ID, '_book_number', true ) ?: '',
      'release_date' => get_post_meta( $post->ID, '_release_date', true ) ?: '',
      'price'        => get_post_meta( $post->ID, '_price', true ) ?: ''
    ];
    ?>
    <p>
      <label for="book_number">
        <?php esc_html_e( 'Numer książki:', 'li-books' ); ?>
      </label>
      <input 
        id="book_number" 
        name="book_number" 
        type="text" 
        value="<?php echo esc_attr( $book_data['number'] ); ?>" 
      />
    </p>
    <p>
      <label for="release_date">
        <?php esc_html_e( 'Data wydania:', 'li-books' ); ?>
      </label>
      <input 
        id="release_date" 
        name="release_date" 
        type="date" 
        value="<?php echo esc_attr( $book_data['release_date'] ); ?>" 
      />
    </p>
    <p>
      <label for="price">
        <?php esc_html_e( 'Cena:', 'li-books' ); ?>
      </label>
      <input 
        id="price" 
        name="price" 
        type="text" 
        value="<?php echo esc_attr( $book_data['price'] ); ?>" 
      />
    </p>
    <?php
  }
  
  function save_books_meta( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return;
    }
    
    if ( isset( $_POST['book_number'] ) ) {
      update_post_meta( 
        $post_id, 
        '_book_number', 
        sanitize_text_field( $_POST['book_number'] ) 
      );
    }
  
    if ( isset( $_POST['release_date'] ) ) {
      update_post_meta( 
        $post_id, 
        '_release_date', 
        sanitize_text_field( $_POST['release_date'] ) 
      );
    }
  
    if ( isset( $_POST['price'] ) ) {
      update_post_meta( 
        $post_id, 
        '_price', 
        sanitize_text_field($_POST['price'] ) 
      );
    }
  }
}