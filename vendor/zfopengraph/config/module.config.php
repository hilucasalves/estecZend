<?php
/**
 * This file is part of the ZfOpenGraph package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

return array(
    'view_helpers' => array(
        'invokables' => array(
            'opengraph' => 'ZfOpenGraph\View\Helper\OpenGraph',
            //Override
            'headmeta' => 'ZfOpenGraph\View\Helper\HeadMeta',
        ),
    )
);

