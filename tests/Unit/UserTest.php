<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery as m;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Form\FormElementsCollection;
use SleepingOwl\Admin\Contracts\Form\FormElementInterface;
use SleepingOwl\Admin\Contracts\Validable;
use Illuminate\Contracts\Support\Arrayable;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\WithModelInterface;

class UserTest extends TestCase
{
    use \SleepingOwl\Tests\AssetsTesterTrait;

    /**
     * @var FormElementsCollection
     */
    protected $elements;

    /**
     * @return FormElementsCollection
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param array $elements
     *
     * @return FormElements
     */
    public function getElement(array $elements = [])
    {
        return new FormElements($elements);
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function saveElements(\Illuminate\Http\Request $request)
    {
        $this->getElements()->onlyActive()->each(function ($element) use ($request) {
            $element = $this->getElementContainer($element);

            if ($element instanceof FormElementInterface) {
                $element->save($request);
            }
        });
    }

    /**
     * FormElements::save
     * FormElementsTrait::saveElements.
     */
    public function test_save()
    {
        $element = $this->getElement([
            $element1 = m::mock(FormElementInterface::class),
            $element2 = m::mock(FormElementInterface::class),
            $element3 = m::mock(FormElementInterface::class),
            $element4 = m::mock(FormElementsTestInitializableMock::class),
            $element5 = m::mock(FormElementsTestInitializableMockWithoutInitializable::class),
            $element6 = m::mock(FormElementsTestInitializableMockWithoutValidable::class),
        ]);

        $request = $this->getRequest();

        $element1->shouldReceive('isReadonly')->once()->andReturn(false);
        $element1->shouldReceive('isVisible')->andReturn(true);
        $element1->shouldReceive('save')->once()->with($request);

        $element2->shouldReceive('isReadonly')->once()->andReturn(true);
        $element2->shouldNotReceive('isVisible');
        $element1->shouldNotReceive('save');

        $element3->shouldReceive('isReadonly')->once()->andReturn(false);
        $element3->shouldReceive('isVisible')->andReturn(false);
        $element1->shouldNotReceive('save');

        $element4->shouldNotReceive('isReadonly');
        $element1->shouldNotReceive('save');

        $element5->shouldNotReceive('isReadonly');
        $element1->shouldNotReceive('save');

        $element6->shouldNotReceive('isReadonly');
        $element1->shouldNotReceive('save');

        $this->assertNull(
            $element->save($request)
        );
    }
}

abstract class FormElementsTestInitializableMock implements Initializable
{
}

abstract class FormElementsTestInitializableMockWithoutInitializable implements WithModelInterface, Arrayable
{
}

abstract class FormElementsTestInitializableMockWithoutValidable implements Validable
{
}
