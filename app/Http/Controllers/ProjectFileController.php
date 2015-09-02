<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ProjectFileController extends Controller
{

    private $service;
    private $repository;

    public function __construct(ProjectRepository $repository, ProjectService $service){
        $this->service = $service;
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        if($this->checkProjectPermissions($request->project_id)==false){
            return ['error' => 'Access Forbidden'];
        }

        $file = $request->file('file');

        $data = [
            'file' => $file,
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $request->project_id
        ];

        return $this->service->createFile($data);

    }

    public function destroy($id)
    {
        if($this->checkProjectPermissions($id) == false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->deleteFile($id);
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
