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
    'name' => 'Employment Types',
    'children' => [
        'Teilzeit',
        'Vollzeit',
        'Jahresstelle',
        'Saison Job',
        'Per sofort',
        'Lehrstelle',
        'Aushilfe',
        'Praktikum'
    ]
];

