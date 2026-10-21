<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Konfiguration der verschiedenen Module
Container::make('post_meta', 'Module')
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('complex', 'modules', 'Module')
            // -> example
            ->add_fields('example', 'Beispiel', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'image', 'Bild')->set_required(),
            ])
            //-> hero_front
            ->add_fields('hero_front', 'Hero Startseite', [
               Field::make('text', 'title', 'Titel')->set_required(),
               Field::make('text', 'subline', 'Subline'),
            ])
            //-> ueber_mich
            ->add_fields('ueber_mich', 'Über mich', [
                Field::make('image', 'image', 'Bild')->set_required(),
                Field::make('text', 'title', 'Überschrift')->set_required(),
                Field::make('textarea', 'text', 'Fliesstext')->set_required(),
            ])
            //-> page_title
            ->add_fields('page_title', 'Seitentitel', [
                Field::make('text', 'title', 'Titel')->set_required(),
            ])
            //-> video_project
            ->add_fields('video_project', 'Videoprojekt', [
                Field::make('text', 'title', 'Videotitel')->set_required(),
                Field::make('text', 'year', 'Jahr')->set_required(),
                Field::make('text', 'type', 'Art des Videos')->set_required(),
                Field::make('oembed', 'video', 'YouTube-Link')
                    ->set_help_text('Füge den Link zu einem YouTube-Video ein.')
                    ->set_required(),
                Field::make('textarea', 'description', 'Projektbeschreibung')->set_required(),
                Field::make('text', 'role', 'Rolle')->set_required(),
            ])
            //-> photography_project
            ->add_fields('photography_project', 'Fotografieprojekt', [
                Field::make('text', 'title', 'Fotografietitel')->set_required(),
                Field::make('media_gallery', 'images', 'Bilder')
                    ->set_help_text('Füge beliebig viele Bilder hinzu. Pro Aufruf werden zufällig zehn Bilder angezeigt.')
                    ->set_required(),
            ])
            //-> audio_project
            ->add_fields('audio_project', 'Audioprojekt', [
                Field::make('text', 'title', 'Audiotitel')->set_required(),
                Field::make('textarea', 'description', 'Projektbeschreibung')->set_required(),
                Field::make('file', 'audio', 'Audiofile')
                    ->set_type(['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4'])
                    ->set_required(),
            ])
            // todo: add new modules here
            // -> SETTINGS
            ->set_layout('tabbed-vertical')
    ]);

// -> Funktion, um die Module und die entsprechenden Templates auf der Seite zu laden
function render_modules (): void {
    $modules = carbon_get_the_post_meta('modules');
    if (empty($modules)) {
        return;
    }
    foreach ($modules as $module) {
        // -> Modifiziere die Daten des Moduls, falls nötig, basierend auf dem Modultyp
        switch ($module['_type']) {
            case 'example':
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;
            case 'ueber_mich':
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;
            case 'photography_project':
                $images = [];
                foreach ((array) $module['images'] as $image_id) {
                    $image = get_media_by_id($image_id, 'large');
                    if ($image) {
                        $images[] = $image;
                    }
                }
                shuffle($images);
                $module['images'] = array_slice($images, 0, 20);
                break;
            case 'audio_project':
                $audio = $module['audio'] ?? '';
                if (is_numeric($audio)) {
                    $module['audio'] = wp_get_attachment_url((int) $audio);
                } elseif (is_array($audio)) {
                    $module['audio'] = $audio['url'] ?? $audio['src'] ?? '';
                }
                break;
                // todo: add data modifications for modules here as a new case
        }
        // -> Laden des Templates basierend auf dem Modultyp und weitergeben der Daten
        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );
    }
}
