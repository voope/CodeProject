<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service){
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);

    }
}
