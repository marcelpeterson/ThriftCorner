<?php

return [
    /*
     * The image optimizers that will be used by default.
     */
    'optimizers' => [
        Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
            '-m85', // set maximum quality to 85
            '--strip-all', // strip all comments, EXIF, etc.
            '--all-progressive', // set progressive mode
        ],

        Spatie\ImageOptimizer\Optimizers\Pngquant::class => [
            '--quality=65-80', // set quality range
            '--force', // force overwrite
        ],

        Spatie\ImageOptimizer\Optimizers\Optipng::class => [
            '-i0', // interlace none
            '-o2', // optimization level 2
            '-quiet', // quiet mode
        ],

        Spatie\ImageOptimizer\Optimizers\Svgo::class => [
            '--disable=cleanupIDs', // disable cleanup IDs
        ],

        Spatie\ImageOptimizer\Optimizers\Gifsicle::class => [
            '-b', // optimize
            '-O3', // optimization level 3
        ],
    ],

    /*
     * The queue that will be used for image optimization jobs.
     * Set to null to use the default queue.
     */
    'queue' => null,

    /*
     * The timeout in seconds for the optimization process.
     */
    'timeout' => 60,
];