<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Marketplace defaults
    |--------------------------------------------------------------------------
    |
    | These options control the behaviour of the marketplace package.
    |
    */

    /**
     * Everything related to the core marketplace.
     */
    'core' => [
        /**
         * Everything related to the core data.
         */
        'data' => [
            /**
             * Everything related to core fields.
             */
            'field' => [
                /**
                 * At first registrations included a salutation by default.
                 * Later, they included a third gender, sometimes referred to as 'other'.
                 * Now, modern marketplaces go as far as removing this information entirely.
                 *
                 * By default, marketplace does not require salutations.
                 */
                'salutations' => false,
            ],
        ],
    ],
];
