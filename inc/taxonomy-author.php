<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add metadata for Author taxonomy 
 */
class Li_Books_Author_Metadata {

  public function __construct() {
    add_action( 'author_edit_form_fields', [ $this, 'add_author_meta_fields' ] );
    add_action( 'author_add_form_fields', [ $this, 'add_author_meta_fields'] );
    add_action( 'edited_author', [ $this, 'save_author_meta' ] );
    add_action( 'created_author', [ $this, 'save_author_meta' ] );
    
    add_filter( 'manage_edit-author_columns', [ $this, 'add_author_columns' ] );
    add_filter( 'manage_author_custom_column', [ $this, 'author_custom_column' ], 10, 3 );
  }

  public function add_author_meta_fields( $term ) {
    if ( isset( $term->term_id ) ) {
      $birth_date = get_term_meta( $term->term_id, '_birth_date', true );
    } 
    else {
      $birth_date = date("Y-m-d");
    }
    ?>
    <div class="form-field">
      <tr class="form-field">
        <th scope="row">
          <label for="birth_date">
            <?php esc_html_e( 'Data urodzenia', 'li-books' ); ?>
          </label>
        </th>
        <td>
          <input 
            id="birth_date" 
            name="birth_date" 
            type="date" 
            value="<?php echo esc_attr( $birth_date ); ?>"
          >
        </td>
      </tr>
    </div>
  
    <?php
  }
  
  public function save_author_meta( $term_id ) {
    if ( isset( $_POST['birth_date'] ) ) {
      update_term_meta( 
        $term_id, 
        '_birth_date', 
        sanitize_text_field( $_POST['birth_date'] ) 
      );
    }
  }
  
  /**
   * Add new columns to view for authors list
   */
  public function add_author_columns( $columns ) {
    $columns['birth_date'] = 'Data urodzenia';
    return $columns;
  }
  
  /**
   * Update custom columns data
   */
  public function author_custom_column( $content, $column_name, $term_id ) {
    if ( $column_name == 'birth_date' ) {
      $content .= esc_html( get_term_meta( $term_id, '_birth_date', true ) );
    }
    return $content;
  }
}
