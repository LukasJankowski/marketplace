<?php

namespace Marketplace\Core\User\Commands;

use Illuminate\Console\Command;
use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Core\Authorization\RoleService;
use Marketplace\Core\User\Actions\CreateUserAction;
use Marketplace\Core\User\Dtos\PersonDto;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Foundation\Exceptions\ValidationException;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketplace:user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user via commandline';

    /**
     * Create a new command instance.
     */
    public function __construct(private CreateUserAction $action)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws ValidationException
     */
    public function handle(): int
    {
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $role = $this->choice('Role', RoleService::getSlugs());
        $salutation = $this->choice('Salutation', Salutation::SALUTATIONS);
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $phone = $this->ask('Phone');

        $personDto = new PersonDto(
            user: new UserDto(email: $email, password: $password, role: $role),
            account: new AccountDto(
                salutation: $salutation,
                firstName: $firstName,
                lastName: $lastName,
                phone: $phone,
            )
        );

        $resource = $this->action->run($personDto)->resolve();
        $this->info('User created. Id: ' . $resource['id']);

        return 0;
    }
}
