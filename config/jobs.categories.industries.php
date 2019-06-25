<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */

/*
 * Format:
 * [
 *      'name' => <name>, [required]
 *      'value' => <value>, [optional]
 *      'children' => [ // optional
 *          <name> // strings will be treated as ['name' => <name>]
 *          [
 *              'name' => <name>, [required]
 *              'value' => <value>, [optional]
 *              'children' => [ ... ]
 *       ]
 * ]
 */

return [
    'name' => 'Industries',
    'children' => [
        'Swiss Lodge',
        '1-Stern Hotel',
        '2-Sterne Hotel',
        '3-Sterne Hotel',
        '4-Sterne Hotel',
        '5-Sterne Hotel',
        'Superior Hotel',
        'Tourismus',
        'Restauration',
        'Systemgastronomie',
        'Gourmet',
        'Catering',
        'Casino',
        'Bar / Lokal / Café / Bistro',
        'Erlebnisgastronomie',
        'Catering / Event / Partyservice',
        'Ferienclubs / Animation',
        'Kliniken / Praxen / Seniorenheim',
        'Kreuzfahrtschiffe / Schifffahrt',
        'Spa / Fitness / Wellness',
        'Ferienhof / Gasthof / Pension',
        'Zulieferer / Handel',
        'Jugendherberge / Hostel / Camping',
        'Soziale Einrichtungen',
        'Kaderstellen',
        'Fachkräfte',
        'Hilfskräfte',
        'Sonstiges'
    ]
];

