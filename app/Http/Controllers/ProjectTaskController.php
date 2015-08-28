<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;

class ProjectTaskController extends Controller
{

    private $repository;
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($projectId)
    {
        return $this->service->all($projectId);
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function show($projectId, $id)
    {
        return $this->service->find($projectId, $id);
    }

    public function update(Request $request, $projectId, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($projectId, $id)
    {
        return $this->service->delete($id);
    }
}
