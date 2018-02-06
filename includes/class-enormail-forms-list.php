<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Enormail_Forms_List_Table extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Form', 'sp'),
            'plural' => __('Forms', 'sp'),
            'ajax' => false
        ]);
    }

    public static function get_forms( $per_page = 15, $page_number = 1 ) {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}enormail_forms";

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;

    }

    /**
     * Delete a form record.
     *
     * @param int $id form ID
     */
    public static function delete_form( $id ) {
        global $wpdb;

        $wpdb->delete( "{$wpdb->prefix}enormail_forms", array( 'id' => $id ), array( '%d' ) );
    }

    /**
     * Deactivates a form.
     *
     * @param int $id form ID
     */
    public static function deactivate_form( $id ) {
        global $wpdb;

        $wpdb->update( "{$wpdb->prefix}enormail_forms", array( 'active' => 0 ), array( 'id' => $id ) );
    }

    /**
     * Activates a form.
     *
     * @param int $id form ID
     */
    public static function activate_form( $id ) {
        global $wpdb;

        $wpdb->update( "{$wpdb->prefix}enormail_forms", array( 'active' => 1 ), array( 'id' => $id ) );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}enormail_forms";

        return $wpdb->get_var( $sql );
    }

    /** Text displayed when no customer data is available */
    public function no_items() {
        echo __( 'No forms available.', 'enormail' );
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    public function get_columns() {
        $columns = [
            'cb' => '<input type="checkbox" name="forms[]" />',
            'name' => __('Name', 'enormail'),
            'shortcode' => __('Shortcode'),
            'active' => __('active', 'enormail'),
            'created_at' => __('created_at', 'enormail'),
        ];

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', true )
        );

        return $sortable_columns;
    }

    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    public function column_name($item) {

        // create a nonce
        $delete_nonce = wp_create_nonce('enormail_delete_form');

        $name = '<a class="row-title" href="'.admin_url('admin.php?page=enormail-admin&view=edit_form&id='.$item['id']).'"><strong>' . $item['name'] . '</strong></a>';

        $actions['edit'] = '<a href="'.admin_url('admin.php?page=enormail-admin&view=edit_form&id='.$item['id']).'">' . __('Edit') . '</a>';

        if ( isset( $item['active'] ) && $item['active'] == 1 ) {
            $actions['deactivate'] = '<a href="'.admin_url('admin.php?page=enormail-admin&action=deactivate&noheader=true&forms='.$item['id']).'">' . __('Deactivate') . '</a>';
        } else {
            $actions['activate'] = '<a href="'.admin_url('admin.php?page=enormail-admin&action=activate&noheader=true&forms='.$item['id']).'">' . __('Activate') . '</a>';
        }

        $actions['delete'] = sprintf(
            '<a class="js-enormail-delete-form" href="?page=%s&action=%s&forms=%s&_wpnonce=%s&noheader=true">' . __('Delete') . '</a>',
            esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce
        );

        return $name . $this->row_actions( $actions );
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="forms[]" value="%s" />', $item['id']);
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        if ( $column_name == 'active' ) {
            return $item['active'] == 1 ? __('Yes') : __('No');
        }

        if ( $column_name == 'shortcode' ) {
            return '[enormail_form form_id=' . $item['id'] . ']';
        }

        return $item[$column_name];
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete'
        ];

        return $actions;
    }

    public function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if (! wp_verify_nonce( $nonce, 'enormail_delete_form')) {
                die( 'Wrong nonce' );
            } else {
                self::delete_form( absint( $_GET['forms'] ) );

                if ( wp_redirect( admin_url( 'admin.php?page=enormail-admin&notify=form_deleted' ) ) ) {
                    exit();
                }
            }

        }

        if  ( 'deactivate' === $this->current_action() ) {
            self::deactivate_form( absint( $_GET['forms'] ) );

            if ( wp_redirect( admin_url( 'admin.php?page=enormail-admin&notify=form_deactivated' ) ) ) {
                exit();
            }
        }

        if  ( 'activate' === $this->current_action() ) {
            self::activate_form( absint( $_GET['forms'] ) );

            if ( wp_redirect( admin_url( 'admin.php?page=enormail-admin&notify=form_activated' ) ) ) {
                exit();
            }
        }

        // If the delete bulk action is triggered
        if (
            (isset($_POST['action']) && $_POST['action'] == 'bulk-delete') ||
            (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {

            $delete_ids = esc_sql($_POST['forms']);

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_form( $id );
            }

            if ( wp_redirect( admin_url( 'admin.php?page=enormail-admin&notify=form_deleted' ) ) ) {
                exit();
            }
        }
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();

        $this->_column_headers = array($columns, $hidden, $sortable);

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = 15;
        $current_page = 1;
        $total_items  = self::record_count();

        $this->set_pagination_args( [
            'total_items' => $total_items, // WE have to calculate the total number of items
            'per_page'    => $per_page // WE have to determine how many items to show on a page
        ] );

        $this->items = self::get_forms( $per_page, $current_page );
    }

    protected function single_row_columns( $item ) {
        list( $columns, $hidden ) = $this->get_column_info();
        foreach ( $columns as $column_name => $column_display_name ) {
            $class = "class='$column_name column-$column_name'";
            $style = '';
            if ( in_array( $column_name, $hidden ) )
                $style = ' style="display:none;"';
            $attributes = "$class$style";
            if ( 'cb' == $column_name ) {
                echo '<th scope="row" class="check-column">';
                echo $this->column_cb( $item );
                echo '</th>';
            }
            elseif ( method_exists( $this, 'column_' . $column_name ) ) {
                echo "<td $attributes>";
                echo call_user_func( array( $this, 'column_' . $column_name ), $item );
                echo "</td>";
            }
            else {
                echo "<td $attributes>";
                echo $this->column_default( $item, $column_name );
                echo "</td>";
            }
        }
    }

}