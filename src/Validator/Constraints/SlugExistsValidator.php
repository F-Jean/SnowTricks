<?php

namespace App\Validator\Constraints;

use App\Repository\TrickRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SlugExistsValidator extends ConstraintValidator
{
    private TrickRepository $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    /**
     * @param Trick $value
     */
    public function validate($trick, Constraint $constraint): void
    {
        if ($this->trickRepository->slugExists($trick)) 
        {
            $this->context->buildViolation($constraint->message)
            ->addViolation()
            ;
        }
    }
}