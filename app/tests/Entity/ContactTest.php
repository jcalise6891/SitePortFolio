<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class ContactTest extends KernelTestCase
{
    private $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get('validator');

    }

    private function createValidContact(): Contact
    {
        // Create a Contact object with valid data
        $contact = new Contact();
        $contact->setName('John Doe');
        $contact->setOrganization('Acme Inc.');
        $contact->setMail('john.doe@example.com');
        $contact->setMessage('Hello, this is a test message.');

        return $contact;
    }

    private function validateContact(Contact $contact): ConstraintViolationList
    {
        // Use Symfony's Validator to check for violations
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        return $validator->validate($contact);
    }

    public function testContactIsValid(): void
    {
        $contact = $this->createValidContact();
        $errors = $this->validateContact($contact);

        $this->assertCount(0, $errors, 'The contact entity should have no validation errors');
    }

    public function testInvalidEmail(): void
    {
        $contact = $this->createValidContact();
        $contact->setMail('not-an-email');

        $errors = $this->validateContact($contact);

        $this->assertGreaterThan(0, count($errors), 'Expected validation errors');

        $emailError = false;
        foreach ($errors as $error) {
            if ($error->getPropertyPath() === 'mail' && $error->getMessage() === 'The email "{{ value }}" is not a valid email.') {
                $emailError = true;
                break;
            }
        }
        $this->assertTrue($emailError, 'An error should occur for invalid email format.');
    }

}
