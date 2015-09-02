<?php

namespace CodeProject\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'project_id'  => 'required|integer',
            'user_id'     => 'required|integer'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'project_id'  => 'required|integer',
            'user_id'     => 'required|integer'
        ]
    ];
}