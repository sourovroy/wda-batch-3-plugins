<?php

namespace RAP\License;

class Settings {

    private $store_url = 'http://academy-batch-4.site';

    private $item_id = 111;

    private $name = 'React Admin Panel';

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'license_menu' ) );

        add_action( 'init', array( $this, 'plugin_updater' ) );
    }

    public function license_menu() {
        add_submenu_page(
            'react_admin_settings',
            'Plugin License',
            'Plugin License',
            'manage_options',
            'react_admin_license',
            array( $this, 'license_page' )
        );

        $license_key = get_option( 'rap_license_key' );

        if ( $license_key ) {
            // Premium Feature for licensed users.
            add_submenu_page(
                'react_admin_settings',
                'Premium Feature',
                'Premium Feature',
                'manage_options',
                'react_admin_premium',
                array( $this, 'license_page' )
            );
        }
    }

    public function license_page() {
        if ( isset( $_POST['license_key'] ) ) {
            $license = sanitize_text_field(  wp_unslash( $_POST['license_key'] ) );

            $is_verify = $this->verify_license( $license );

            if ( $is_verify ) {
                update_option( 'rap_license_key', $license );
                echo '<p>Thank You!</p>';
            } else {
                echo '<p>You license is not valid.</p>';
            }
        }

        $license_key = get_option( 'rap_license_key' );
        ?>
        <div class="wrap">
            <h2>Plugin License Options</h2>
            <form method="post" action="<?php echo admin_url( '/admin.php?page=react_admin_license' ); ?>">

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label>License Key</label></th>
                            <td><input name="license_key" type="text" value="<?php echo $license_key; ?>" class="regular-text"></td>
                        </tr>
                    </tbody>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    private function verify_license( $license ) {
        // data to send in our API request
        $api_params = array(
            'edd_action'  => 'activate_license',
            'license'     => $license,
            'item_id'     => $this->item_id,
            'item_name'   => rawurlencode( $this->name ), // the name of our product in EDD
            'url'         => home_url(),
            'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
        );

        $response = wp_remote_post(
            $this->store_url,
            array(
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $api_params,
            )
        );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( false === $license_data->success ) {
            return false;
        }

        return true;
    }

    public function plugin_updater() {
        require_once __DIR__ . '/EDD_SL_Plugin_Updater.php';

        $license_key = get_option( 'rap_license_key' );

        // setup the updater
        $edd_updater = new \EDD_SL_Plugin_Updater(
            $this->store_url,
            RAP_ROOT_FILE,
            array(
                'version' => RAP_VERSION,                    // current version number
                'license' => $license_key,             // license key (used get_option above to retrieve from DB)
                'item_id' => $this->item_id,       // ID of the product
                'author'  => 'Easy Digital Downloads', // author of this plugin
                'beta'    => false,
            )
        );
    }
}
