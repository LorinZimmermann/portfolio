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
                Field::make('oembed', 'video', 'Video')->set_required(),
                Field::make('textarea', 'description', 'Projektbeschreibung')->set_required(),
                Field::make('text', 'role', 'Rolle')->set_required(),
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
