<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;

use CodeProject\Services\ProjectService;

class ProjectNoteController extends Controller
{

    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectService $projectService)
    {

        $this->repository = $repository;
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {
        if($this->checkProjectNotePermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        //return $this->repository->all();
        //return $this->repository->with(['client', 'user'])->all();
        return $this->repository->findWhere(['project_id' => $projectId]);
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
        //return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($projectId, $id)
    {
        if($this->checkProjectNotePermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

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
        
        $projectNote = $this->repository->skipPresenter()->find($id);

        $projectId = $projectNote->project_id;

        if($this->checkProjectNotePermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        //return $this->service->update($request->all(),$noteId);
        return $this->service->update($request->all(),$id);

        /*
        $result = $this->repository->find($id)->update($request->all());
        if($result)
            return ['error' => 0];
        return  ['error' => 1, 'msg' => 'Erro ao tentar atualizar o Projecte'];
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $projectNote = $this->repository->skipPresenter()->find($id);
        //$result = $this->repository->delete($id);

        $projectId = $projectNote->project_id;

        if($this->checkProjectNotePermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        $result = $projectNote->delete();

        if($result)
            return ['error' => 0];

        return  ['error' => 1, 'msg' => 'Erro ao tentar deletar a Task Note'];
        

        /*
        $result = $this->repository->find($id)->delete();

        if($result)
            return ['error' => 0];

        return  ['error' => 1, 'msg' => 'Erro ao tentar deletar o Projecte'];
        */
    }



    private function checkProjectNotePermissions($projectId){
        
        if($this->projectService->checkProjectOwner($projectId) or $this->projectService->checkProjectMember($projectId)){
            return true;
        }
        return false;

    }
}
