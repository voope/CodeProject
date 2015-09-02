<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectNoteController extends Controller
{

    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectNoteService $service){
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->all($id);
    }

    public function show($id,$noteId)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->find($id, $noteId);
    }

    public function store(Request $request)
    {
        if($this->checkProjectPermissions($request->project_id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $noteId)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $noteId);
    }

    public function destroy($id, $noteId)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->delete($noteId);
    }

    public function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->skipPresenter()->isOwner($projectId, $userId);
    }

    public function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->skipPresenter()->hasMember($projectId, $userId);
    }

    public function checkProjectPermissions($projectId){
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }

}
