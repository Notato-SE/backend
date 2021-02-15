<?php

namespace App\Http\Controllers\Api\v1\Randomizer;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\RandomizerType;
use App\Traits\RandomizerRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Randomizer\Randomizer;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Randomizer\RandomizerRequest;


class RandomizerController extends ApiController
{
  use RandomizerRepository;

  public function random(RandomizerRequest $request)
  {
    $data = $request->validated();

    $data['results'] = $this->getRandomResult($data);

    return $this->okWithData($data);
  }

  public function save(RandomizerRequest $request)
  {
    // $userId = Auth::id();

    $userId = curAuth()->id;
    $data = $request->validated();
    $data['user_id'] = $userId;
    $data['inputs'] = Arr::except($data, ['results', 'user_id']);
    $data['inputs'] = json_encode($data['inputs']);
    $data['results'] = json_encode($data['results']);

    Randomizer::create($data);

    return $this->okWithMsg("Save data succuessfully");
  }
}
