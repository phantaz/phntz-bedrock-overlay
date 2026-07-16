<?php
/**
 * Theme and plugin integrations.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter( 'wp_prepare_themes_for_js', function ( $themes ) {
    if ( ! is_admin() || ! is_child_theme() ) {
        return $themes;
    }

    $parent_slug = get_template();
    $active_slug = get_stylesheet();

    foreach ( $themes as $slug => &$theme ) {
        if ( $slug === $active_slug ) {
            continue;
        }

        $screenshot = $slug === $parent_slug ? '/screenshot-parent.png' : '/screenshot-backup.png';
        $url = PHNTZ_THEME_URL . $screenshot;

        if ( isset( $theme['screenshot'][0] ) ) {
            $theme['screenshot'][0] = $url;
        }
        if ( isset( $theme['thumb'] ) ) {
            $theme['thumb'] = $url;
        }
    }
    unset( $theme );

    return $themes;
} );

add_filter( 'flying_press_footprint', function () {
    return '<!-- by phantaz.design / cached at: ' . time() . ' -->';
} );
