<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EndTenderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:end-tender')
            ->setDescription('End tenders.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        date_default_timezone_set('Asia/Yerevan');
        $date = new \DateTime("now");
        $minutes_to_add = 3;
        $now = new \DateTime("now");
        $date->add(new \DateInterval('PT' . $minutes_to_add . 'M'));

        $this->getContainer()->get('doctrine.orm.entity_manager');
        $date->format('Y-m-d H:i:s');

        $properties = $this->getContainer()->get("app.property_manager")->findByDate($now, $date);

        foreach ($properties as $value){
            $price = $this->getContainer()->get("app.price.manager")->findOneBy(["property" => $value]);
            $value->setCategoryType(3);
            $message  =  $this->getContainer()->get('templating')->render(":mail:end.tender.not.price.html.twig", [
                "value" => $value
            ]);
            if($price){
                $value->setCategoryType(1);
                $message = $this->getContainer()->get('templating')->render(":mail:end.tender.html.twig", [
                    "value" => $value
                ]);
            }

            $this->getContainer()->get("app.mailer_service")->sendMail($message, $value->getOwner()->getEmail());
            return $this->getContainer()->get("app.property_manager")->persist($value);
        }
    }
}

