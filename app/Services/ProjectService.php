<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use CodeProject\Validators\ProjectValidator;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;


class ProjectService
{

    protected $repository;
    protected $validator;
    protected $filesystem;
    protected $storage;
    protected $validator_file;

    public function __construct(Filesystem $filesystem, Storage $storage, ProjectRepository $repository, ProjectValidator $validator,ProjectFileValidator $validator_file)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        $this->validator_file = $validator_file;
    }


    public function all()
    {
        try {
            $userId = Authorizer::getResourceOwnerId();

            return $this->repository->skipPresenter()->with(['owner', 'client'])->findWhere(['owner_id' => $userId]);

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function find($id)
    {
        try {
            return $this->repository->skipPresenter()->with(['owner', 'client'])->find($id);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function create(array $data)
    {

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->create($data);

        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

    }

    public function update(array $data, $id)
    {

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data, $id);

        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->repository->delete($id);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }

    }

    public function createFile(array $data)
    {
        try {

            if(!empty($data['file']))
                $data['extension'] = $data['file']->getClientOriginalExtension();

            $this->validator_file->with($data)->passesOrFail();

            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            $r = $this->storage->put($projectFile->id . '.' . $data['extension'], $this->filesystem->get($data['file']));

            if($r)
                return ['success' => true];



        } catch(ValidatorException $e) {

            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    public function deleteFile($projectId)
    {
        $files = $this->repository->skipPresenter()->find($projectId)->files;

        $deletar = [];
        foreach ($files as $file) {
            $path = $file->id . '.' . $file->extension;

            if($file->delete($file->id))
                $deletar[] = $path;
        }

        $r = $this->storage->delete($deletar);
        if($r)
            return ['success' => true];
        else
            return ['error' => true];
    }



}