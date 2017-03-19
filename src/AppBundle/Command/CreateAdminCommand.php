<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-admin')
            ->setDescription('Creates admin user.')
            ->setHelp('Create admin user form credentials specified in environment variables.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $io = new SymfonyStyle($input, $output);
        $email = $this->getContainer()->getParameter('admin_email');
        $password = $this->getContainer()->getParameter('admin_password');
        $phone_number = $this->getContainer()->getParameter("admin_phone");
        $company_name= $this->getContainer()->getParameter("company_name");
        $validator = Validation::createValidator();

        // Validate email
        $violations = $validator->validate($email, [
            new Assert\NotBlank(),
            new Assert\Email(),
        ]);

        if (0 !== count($violations)) {
            $io->title('Email is invalid.');
            foreach ($violations as $violation) {
                $io->error($violation->getMessage());
            }
        }

        // Validate password
        $violations = $validator->validate($password, [
            new Assert\NotBlank(),
        ]);

        if (0 !== count($violations)) {
            $io->title('Password is invalid.');

            foreach ($violations as $violation) {
                $io->error($violation->getMessage());
            }
        }

        $user = $em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $email]);
        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setPlainPassword($password);
            $user->setPhoneNumber($phone_number);
            $user->setCompanyName($phone_number);
            $user->setRoles(['ROLE_ADMIN']);
        }

        $em->persist($user);
        $em->flush();
    }
}
