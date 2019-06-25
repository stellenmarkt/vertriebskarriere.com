<?php

/* Form labels */

$labels = [

    /* Labels für die Radio-Buttons */
    'mode' => [
        'uri' => 'Direktlink-Inserat',
        'pdf' => 'PDF-Inserat',
        'html' => 'Standard-Inserat',
    ],

    /* Label des URL-Eingabefeldes */
    'uri' => 'Online-Inserat',

    /* Datei-Asuwahlfeld für PDF-Upload */
    'pdf' => 'PDF-Datei',

    /* Datei-Auswahlfeld für das Unternehmenslogo (nur bei Einzelinserat) */
    'logo' => 'Unternehmenslogo (max. 350x150)',

    /* Text-Area für die Unternehmensbeschreibung (nur bei Einzelinserat) */
    'description' => 'Unternehmensbeschreibung',

    /* Datei-Auswahlfeld für das Bannerbild */
    'image' => 'Bannerbild (max. 600x400)',

    /* Text-Area für die Stellenbeschreibung */
    'position' => 'Stellenbeschreibung',

    /* Text-Area für die Anforderungen */
    'requirements' => 'Anforderungen',
];

/*
 * Angeben zum Zurechtschneiden von Logo- und Bannerbild beim hochladen.
 *
 * Wenn 'width' und 'height' > 0, dann wird das Bild IMMER auf EXAKT diese Werte gesetzt.
 * Wenn nur einer dieser Werte > 0, dann wird der jeweils andere NICHT geändert.
 *
 * Die folgenden Werte werden ignoriert, wenn 'width' oder 'height' > 0
 *
 * 'min-width': Wenn Bild kleiner als Wert, dann wird dieser Wert als Breite genommen
 * 'min-height': analog, für die Höhe
 *
 * 'max-width': Wenn Bild breiter als Wert, dann wird dieser Wert als Breite genommen
 * 'min-height': analog, für die Höhe.
 *
 * Es gilt außerdem:
 * Zuerst wird die Breite geprüft und ggf. angepasst, wenn dann die Höhe noch zu niedrig / zu hoch ist,
 * wird auch die Höhe noch angepasst. Da bei den 'min-*' und 'max-*' Angaben, das ursprüngliche Seitenverhältnis
 * nicht verändert wird, kann es passieren, daß ein Bild trotz 'min-width' kürzer wird.
 */

/* Zuschnittsgrößen Bannerbild */
$imageSize = [
    'width'      => 0,
    'height'     => 0,
    'min-width'  => 0,
    'min-height' => 0,
    'max-height' => 0,
    'max-width'  => 0,
];

/* Zuschnittsgröße Firmen-Logo */
$logoSize = [
    'width'      => 0,
    'height'     => 0,
    'min-width'  => 0,
    'min-height' => 0,
    'max-height' => 0,
    'max-width'  => 0,
];


/*
 * AB HIER NICHTS MEHR ÄNDERN!
 */
return [ 'options' => [ \Gastro24\Options\JobDetailsForm::class => [ 'options' => compact('labels', 'imageSize', 'logoSize') ]]];
