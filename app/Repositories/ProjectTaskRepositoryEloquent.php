<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectTaskPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\ProjectTask;


class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{

    public function model()
    {
        return ProjectTask::class;
    }

    public function presenter()
    {
        return ProjectTaskPresenter::class;
    }

}