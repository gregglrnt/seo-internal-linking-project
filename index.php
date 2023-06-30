<?php
/**
* Plugin Name: Maillage interne
* Plugin URI: https://www.google.com
* Description: Test.
* Version: 0.1
* Author: Gregory Laurent
**/
add_action('the_content', 'internal_linking');

add_action('activated_plugin', 'internal_linking_activate');

add_action('wp_enqueue_scripts', 'internal_linking_enqueue_scripts');
add_action('admin_enqueue_scripts', 'internal_linking_enqueue_scripts');

function internal_linking_enqueue_scripts() {
    wp_enqueue_style( 'seo-plugin-style', plugin_dir_url( __FILE__ ).'style.css' );
}


function internal_linking_activate() {
    add_option('internal_linking_fake_url', false);
    add_option('internal_linking_api_key', '');
}

function internal_linking($content) {
    global $wp;
    $token = get_option('internal_linking_api_key');
    $current_page_link = get_option('internal_linking_fake_url') ?? get_site_url();
    $current_page_link .= '/'.get_post_field( 'post_name', get_post() );
    $body = json_encode(["url" => $current_page_link]);
    $response = wp_remote_post("https://www.babbar.tech/api/url/similar-links?api_token=".$token, [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json',
        ]
    ]);

    if($response['headers']['content-type'] != 'application/json') {
        if(is_user_logged_in()) {
            $content .= "<div class='internal-linking-broken'> Impossible de générer votre maillage interne, votre clef d'API est invalide </div>";
        }
        return $content;
    }

    $top_10_links = json_decode($response['body'], true);
    if(count($top_10_links) == 0) {
        $content .= "<div class='internal-linking'> Aucune suggestion. </div>";
        return $content;
    }

    $link_div = "";
    foreach($top_10_links as $link) {
        $link_div .= "<li>";
        $link_div .= "<a href='".$link['similar']."'>".$link['metrics']['original']['title'].'</a>';
        $grade = floor($link['score'] * 100);
        $link_div .= "<small> Similitude : $grade % </small>";
        $link_div .= '</li>';
        $link_div .= "<script>console.log(".json_encode($link).")</script>";
    }  
     $content .= <<<HTML
        <ul class="internal-linking">
            Cette page vous passionne ? Ces liens pourraient vous intéresser :
            $link_div
        </ul>
     HTML;
     return $content;
}

add_action('admin_menu', 'internal_linking_page');

function internal_linking_page() {
    add_menu_page('Maillage interne', 'Maillage interne', 'manage_options', 'internal-linking', 'internal_linking_admin_page', 'dashicons-admin-links', 6);
}

function internal_linking_admin_page() {
    include('plugin_admin.php');
}


?>
