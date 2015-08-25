<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

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

    public function __construct(ProjectRepository $repository, ProjectService $service){
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
        return $this->service->all();
    }

    public function show($id)
    {
        return $this->service->show($id);
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
        return $this->service->destroy($id);


//        public function destroy($id)
//    {
//        try{
//            $client = $this->search($id);
//
//            if( $client['success'] ){
//
//                return ["success" => $this->repository->delete($id)];
//            }
//
//            return $client;
//
//        }catch (\Exception $e) {
//            return [
//                'success' => 'false',
//                'message' => "Could not delete the Client {$id}"
//            ];
//        }
//    }

    }
}
