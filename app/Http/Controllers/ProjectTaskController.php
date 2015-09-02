<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectTaskService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTaskController extends Controller
{

    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($projectId)
    {
        if($this->checkProjectPermissions($projectId)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->all($projectId);
    }

    public function store(Request $request)
    {
        if($this->checkProjectPermissions($request->project_id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->create($request->all());
    }

    public function show($projectId, $id)
    {
        if($this->checkProjectPermissions($projectId)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->find($projectId, $id);
    }

    public function update(Request $request, $projectId, $id)
    {
        if($this->checkProjectPermissions($projectId)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $id);
    }

    public function destroy($projectId, $id)
    {
        if($this->checkProjectPermissions($projectId)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->delete($id);
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
