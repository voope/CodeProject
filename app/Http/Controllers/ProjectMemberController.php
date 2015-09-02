<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectMemberService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ProjectMemberController extends Controller
{

    private $service;
    private $repository;

    public function __Construct(ProjectRepository $repository, ProjectMemberService $service)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function members($id)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->members($id);
    }

    public function addMember(Request $request)
    {
        if($this->checkProjectPermissions($request->project_id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->addMember($request->all());
    }

    public function isMember($id,$membersId)
    {
        return $this->service->isMember($id,$membersId);
    }

    public function removeMember($id, $membersId)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->removeMember($membersId);
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->skipPresenter()->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->skipPresenter()->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)) {
            return true;
        }

        return false;
    }


}
