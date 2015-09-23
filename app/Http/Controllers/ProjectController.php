<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {

        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return $this->repository->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
        //return $this->repository->all();
        //return $this->repository->with(['client', 'user'])->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //dd($request->all());
        return $this->service->create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        //if($this->checkProjectPermissions($id) == false){
        if($this->service->checkProjectPermissions($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        //return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        return $this->repository->find($id);
        //return $this->repository->with(['client', 'user'])->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
        if($this->service->checkProjectOwner($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($request->all(),$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        //return $this->repository->delete($id);

        ///*
        //$result = $this->repository->find($id)->delete();
        $result = $this->repository->delete($id);

        if($result)
            return ['error' => 0];

        return  ['error' => 1, 'msg' => 'Erro ao tentar deletar o Project'];
        //*/
    }


    /*
    23.08.2015 - Movido para services
    private function checkProjectOwner($projectId)
    {

        $userId = \Authorizer::getResourceOwnerId();


        return $this->repository->isOwner($projectId, $userId);
    }


    private function checkProjectMember($projectId)
    {
        
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId){
        
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
    */

}
