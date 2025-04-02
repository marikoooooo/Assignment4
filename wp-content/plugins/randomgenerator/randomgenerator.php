<?php
/**
 * Plugin Name: Random Yarn Project Generator
 * Plugin URI: https://github.com/yourusername/random-yarn-project
 * Description: Generates a random yarn project idea.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

function generate_random_yarn_project() {
    $items = ['Scarf', 'Shawl', 'Sweater', 'Beanie', 'Plushie'];
    $weights = ['Light', 'Sport', 'Worsted', 'Bulky', 'Extra bulky'];
    $types = ['Cotton', 'Acrylic', 'Wool', 'Bamboo', 'Silk'];
    
    $random_item = $items[array_rand($items)];
    $random_weight = $weights[array_rand($weights)];
    $random_type = $types[array_rand($types)];
    
    $result = "Make a $random_item with $random_weight-weight $random_type yarn today!";
    
    wp_send_json_success($result);
}
add_action('wp_ajax_generate_yarn_project', 'generate_random_yarn_project');
add_action('wp_ajax_nopriv_generate_yarn_project', 'generate_random_yarn_project');

function display_yarn_project_button() {
    ob_start(); ?>
    <div id="yarn-project-container">
        <button id="generate-yarn-project" style="padding: 10px; background: #6a329f; color: white; border: none; cursor: pointer;">Give me a project!</button>
        <p id="yarn-project-result" style="font-weight: bold; margin-top: 10px;"></p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("generate-yarn-project").addEventListener("click", function() {
                fetch("<?php echo admin_url('admin-ajax.php'); ?>?action=generate_yarn_project")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("yarn-project-result").textContent = data.data;
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('random_yarn_project', 'display_yarn_project_button');
