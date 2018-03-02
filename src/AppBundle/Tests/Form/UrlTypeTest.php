<?php

namespace App\Tests\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Form\UrlType;
use AppBundle\Entity\Url;

class UrlTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'fullUrl' => 'http://bbc.co.uk',
        ];

        $form = $this->factory->create(UrlType::class);

        $object = new Url();
        $object->setFullUrl($formData['fullUrl']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}