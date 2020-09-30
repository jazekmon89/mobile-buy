<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/jason-behik-897978a1/
 * @since      1.0.0
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/admin/partials
 */

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
?>

<div class="wrap">
 
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <h2 class="nav-tab-wrapper">
        <a href="?page=<?php echo $this->plugin_name; ?>&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
    </h2>
    <?php if ($active_tab == 'general'): ?>
    <?php 
        $options = get_option($this->plugin_name);
        $status = !empty($options['mobile_buy_status']) ? $options['mobile_buy_status'] : '0';
        $text = !empty($options['mobile_buy_text']) ? $options['mobile_buy_text'] : 'Buy';
        $slug = !empty($options['mobile_buy_cart_slug']) ? $options['mobile_buy_cart_slug'] : 'mobile-cart';
    ?>
    <form method="post" name="<?php echo $this->plugin_name;?>_options" action="options.php">
		<?php settings_fields($this->plugin_name); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="mobile_buy_text">Enable the widget and custom mobile add to cart page</label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo $this->plugin_name; ?>[mobile_buy_status]" value="1" <?php checked($status, 1); ?>>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="mobile_buy_text">Button text</label>
                </th>
                <td>
                    <input type="text" name="<?php echo $this->plugin_name; ?>[mobile_buy_text]" value="<?php echo $text; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="mobile_buy_text">Mobile Add to cart page slug</label>
                </th>
                <td>
                    <input type="text" name="<?php echo $this->plugin_name; ?>[mobile_buy_cart_slug]" value="<?php echo $slug; ?>" required>
                </td>
            </tr>
            
        </table>
        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    </form>
    <?php endif; ?>
 
</div>
