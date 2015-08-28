<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Services\ProjectMembersService;

class ProjectMembersController extends Controller
{

    private $repository;
    private $service;

    public function __Construct(ProjectMembersRepository $repository, ProjectMembersService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->service->all($id);
    }

    public function store(Request $request)
    {
        return $this->service->addMember($request->all());
    }

    public function isMember($id,$membersId)
    {
        return $this->service->isMember($id,$membersId);
    }

    public function destroy($id, $membersId)
    {
        return $this->service->removeMember($membersId);
    }
}
