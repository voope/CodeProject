<?php

namespace CodeProject\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Exception;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
use DB;

class ProjectMemberService
{

    protected $repository;
    protected $validator;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function members($id)
    {
        try {
            return $this->repository->findWhere(['project_id'=>$id]);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function isMember($id,$membersId)
    {
        $members = DB::table('project_members')
            ->where('user_id', '=', $membersId)
            ->where('project_id', '=', $id)
            ->value('id');
        if ($members == null){
            return  'nao é membro';
        }else {
            return  'sim é membro';
        }
    }

    public function addMember(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            return $this->repository->create($data);
        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        };

    }

    public function removeMember($id)
    {
        try {
            $this->repository->delete($id);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }


    }
}