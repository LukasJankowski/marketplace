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
                /**
                 * Define the minimum length a password is required to have.
                 *
                 * By default, marketplace requires 6 characters.
                 */
                'password' => 6,
            ],
        ],
        /**
         * Everything related to the core authentication.
         */
        'authentication' => [
            /**
             * The default throttling used by the core to avoid too many auth attempts.
             *
             * By default it is 5 per minute.
             */
            'throttling' => 5,
            /**
             * The default lifetime of a token before it requires a refresh in minutes.
             *
             * By default it is 120 minutes.
             */
            'lifetime' => 120,
        ],
    ],
    /**
     * Everything related to the foundation of the marketplace.
     */
    'foundation' => [
        /**
         * Every generator command available is listed here.
         */
        'generators' => [
            \Marketplace\Foundation\Generators\ActionMakeCommand::class,
            \Marketplace\Foundation\Generators\RequestMakeCommand::class,
            \Marketplace\Foundation\Generators\ResourceMakeCommand::class,
            \Marketplace\Foundation\Generators\DtoMakeCommand::class,
            \Marketplace\Foundation\Generators\ValueObjectMakeCommand::class,
            \Marketplace\Foundation\Generators\ControllerMakeCommand::class,
            \Marketplace\Foundation\Generators\TestMakeCommand::class,
            \Marketplace\Foundation\Generators\ModelMakeCommand::class,
            \Marketplace\Foundation\Generators\FactoryMakeCommand::class,
            \Marketplace\Foundation\Generators\EventMakeCommand::class,
            \Marketplace\Foundation\Generators\SubscriberMakeCommand::class,
        ]
    ],
];
