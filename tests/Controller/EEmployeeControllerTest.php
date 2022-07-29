<?php

namespace App\Test\Controller;

use App\Entity\EEmployee;
use App\Repository\EEmployeeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EEmployeeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EEmployeeRepository $repository;
    private string $path = '/e/employee/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(EEmployee::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EEmployee index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'e_employee[firstname]' => 'Testing',
            'e_employee[lastname]' => 'Testing',
            'e_employee[phoneNumber]' => 'Testing',
            'e_employee[email]' => 'Testing',
            'e_employee[adress]' => 'Testing',
            'e_employee[position]' => 'Testing',
            'e_employee[salary]' => 'Testing',
            'e_employee[birthDate]' => 'Testing',
        ]);

        self::assertResponseRedirects('/e/employee/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EEmployee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAdress('My Title');
        $fixture->setPosition('My Title');
        $fixture->setSalary('My Title');
        $fixture->setBirthDate('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EEmployee');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EEmployee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAdress('My Title');
        $fixture->setPosition('My Title');
        $fixture->setSalary('My Title');
        $fixture->setBirthDate('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'e_employee[firstname]' => 'Something New',
            'e_employee[lastname]' => 'Something New',
            'e_employee[phoneNumber]' => 'Something New',
            'e_employee[email]' => 'Something New',
            'e_employee[adress]' => 'Something New',
            'e_employee[position]' => 'Something New',
            'e_employee[salary]' => 'Something New',
            'e_employee[birthDate]' => 'Something New',
        ]);

        self::assertResponseRedirects('/e/employee/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getPhoneNumber());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getAdress());
        self::assertSame('Something New', $fixture[0]->getPosition());
        self::assertSame('Something New', $fixture[0]->getSalary());
        self::assertSame('Something New', $fixture[0]->getBirthDate());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EEmployee();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAdress('My Title');
        $fixture->setPosition('My Title');
        $fixture->setSalary('My Title');
        $fixture->setBirthDate('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/e/employee/');
    }
}
