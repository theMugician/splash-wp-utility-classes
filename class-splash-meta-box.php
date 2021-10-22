<?php
/**
 * A WordPress meta box that appears in the editor.
 */
if ( ! class_exists( 'Splash_Meta_Box' ) ) {
    class Splash_Meta_Box
    {
        /**
         * Screen context where the meta box should display.
         *
         * @var string
         */
        protected $context;

        /**
         * The ID of the meta box.
         *
         * @var string
         */
        protected $id;

        /**
         * The display priority of the meta box.
         *
         * @var string
         */
        protected $priority;

        /**
         * Screens where this meta box will appear.
         *
         * @var string[]
         */
        protected $screens;

        /**
         * The title of the meta box.
         *
         * @var string
         */
        protected $title;

        /**
         * Screens where this meta box will appear.
         *
         * @var string[]
         */
        protected $fields;

        /**
         * Constructor.
         *
         * @param string   $id
         * @param string   $title
         * @param string   $template
         * @param string   $context
         * @param string   $priority
         * @param string[] $screens
         * @param string[] $fields
         */
        public function __construct($id, $title, $template = null, $context = 'advanced', $priority = 'default', $screens = array(), $fields = array())
        {
            if (is_string($screens)) {
                $screens = (array) $screens;
            }

            $this->id = $id;
            $this->title = $title;
            //$this->template = rtrim($template, '/');
            $this->template = $template;
            $this->context = $context;
            $this->priority = $priority;
            $this->screens = $screens;
            $this->fields = $fields;

            add_action( 'add_meta_boxes', array( $this, 'register' ) );
            add_action( 'save_post', array( $this, 'save_meta_settings' ) );
        }

        /**
         * Render the content of the meta box using a PHP template.
         * Rendering fields 
         * @return void
         */
        public function render( ) {
            wp_nonce_field( 'metabox_' . $this->id, 'metabox_' . $this->id . '_nonce' );
            if( ! isset( $this->template ) || $this->template === null ) {
                echo '<p>' . __( 'There are no settings on this page.', 'textdomain' ) . '</p>';
                return;
            }
            //var_dump($this->template);
            //die();
            include $this->template;
        }
        
        /**
         * Add meta box to a post.
         *
         */
        public function register()
        {
            add_meta_box($this->id, $this->title, array( $this, 'render' ), $this->screens );
        }

        /**
         * 
         * Save settings from POST
         * @param WP_Post $post_id
         */
        public function save_meta_settings( $post_id ) {
        
            
            // Check if our nonce is set.
            if ( ! isset( $_POST['metabox_' . $this->id  . '_nonce'] ) ) {

                return $post_id;
            }
            

            $nonce = $_POST['metabox_' . $this->id  . '_nonce'];
            
            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $nonce, 'metabox_' . $this->id  ) ) {
                echo('passed validation');
            }
            
            /*
            * If this is an autosave, our form has not been submitted,
            * so we don't want to do anything.
            */
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
            }
            
            // Check the user's permissions.
            if ( 'page' == $_POST['post_type'] ) {
                if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
                }
            } else {
                if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
                }
            }
            
            foreach ( $this->fields as $field ) {
                $field_type = $field['type'];
                $field_meta_key = $field['meta_key'];
                $field_meta_value = $_POST[$field['meta_key']];
                if( 'checkbox' === $field['type'] && !isset( $_POST[$field['meta_key']] ) ) {
                    $field_meta_value = 0;
                }
                update_post_meta( $post_id, $field['meta_key'], sanitize_text_field( $field_meta_value ) );
            
            }

        }

    }
}