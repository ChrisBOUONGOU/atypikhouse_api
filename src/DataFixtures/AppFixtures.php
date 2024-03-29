<?php

namespace App\DataFixtures;

use App\Factory\AboutUsFactory;
use App\Factory\ApiClientFactory;
use App\Factory\CityFactory;
use App\Factory\OfferCommentFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadSQLDump($manager);

        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);

        AboutUsFactory::createOne();

        // Create Owners
        UserFactory::createMany(20, function () {
            return ['roles' => ["ROLE_OWNER"]];
        });

        // Create unique Collections/categories
        $collections = ['Cabanes', 'Yourtes', 'Bulles', 'Tentes', 'Dôme', 'Cabanes sur Arbres'];
        foreach ($collections as $collection) {
            OfferTypeFactory::createOne(['name' => $collection]);
        }

        OfferFactory::createMany(30, function () { // note the callback - this ensures that each of the offers has a different owner
            return ['owner' => UserFactory::random()]; // each offer set to a random Owner from those already in the database
        });

        // Create Users
        UserFactory::createMany(50, function () {
            return ['roles' => ["ROLE_USER"]];
        });

        OfferCommentFactory::createMany(70, function () {
            return ['client' => UserFactory::random(), 'offer' => OfferFactory::random(), 'status' => 'approved'];
        });
    }

    private function loadSQLDump(EntityManagerInterface $manager)
    {
        // Bundle to manage file and directories
        $finder = new Finder();
        $finder->in(__DIR__ . '/../../data');
        $finder->name('database.sql');
        $finder->files();

        foreach ($finder as $file) {
            print "Importing: {$file->getBasename()} " . PHP_EOL;

            $sql = $file->getContents();

            $sqls = explode("\n", $sql);

            foreach ($sqls as $sql) {
                if (trim($sql) != '') {
                    $manager->getConnection()->exec($sql);  // Execute native SQL
                }
            }

            $manager->flush();
        }
    }
}
