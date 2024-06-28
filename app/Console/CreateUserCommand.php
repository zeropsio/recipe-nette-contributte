<?php declare(strict_types = 1);

namespace App\Console;

use App\Domain\User\CreateUserFacade;
use App\Domain\User\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: self::NAME)]
class CreateUserCommand extends Command
{

	public const NAME = 'create-user';

	public function __construct(
		private readonly CreateUserFacade $createUserFacade,
	)
	{
		parent::__construct();
	}

	protected function configure(): void
	{
		$this->setName(self::NAME)
			->setDescription('Creates user in DB.')
			->addArgument('name', InputArgument::REQUIRED)
			->addArgument('surname', InputArgument::REQUIRED)
			->addArgument('email', InputArgument::REQUIRED)
			->addArgument('username', InputArgument::REQUIRED)
			->addArgument('password', InputArgument::REQUIRED)
			->addArgument('role', InputArgument::OPTIONAL, '', User::ROLE_USER);

		parent::configure();
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$output->writeln('Creating user ' . $input->getArgument('username') . '.');

		$user = $this->createUserFacade->createUser([
			'name' => $input->getArgument('name'),
			'surname' => $input->getArgument('surname'),
			'email' => $input->getArgument('email'),
			'username' => $input->getArgument('username'),
			'password' => $input->getArgument('password'),
			'role' => $input->getArgument('role'),
		]);

		$output->writeln('User ' . $user->getUsername() . ' created successfully.');

		return 0;
	}

}
