<?php

// todo: Hier die Getter für die Globalen Informationen definieren

/**
 * Liefert die im Backend erfassten Medien über alle Seitenmodule hinweg.
 */
function get_archive_media_counts(): array {
    $counts = [
        'photos' => 0,
        'videos' => 0,
        'audio' => 0,
    ];

    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields' => 'ids',
    ]);

    foreach ($pages as $page_id) {
        $modules = carbon_get_post_meta($page_id, 'modules');

        foreach ((array) $modules as $module) {
            $type = $module['_type'] ?? '';

            if ($type === 'photography_project') {
                $counts['photos'] += count((array) ($module['images'] ?? []));
            } elseif ($type === 'video_project' && !empty($module['video'])) {
                $counts['videos']++;
            } elseif ($type === 'audio_project' && !empty($module['audio'])) {
                $counts['audio']++;
            }
        }
    }

    return $counts;
}
