<?php

namespace App\Http\Controllers\Api\v1\Randomizer;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Enums\RandomizerType;
use App\Exports\RandomizerExport;
use App\Traits\RandomizerRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Randomizer\Randomizer;
use App\Http\Controllers\ApiController;
use App\Http\Resources\RandomizerResource;
use App\Http\Resources\RandomizerCollection;
use App\Http\Requests\Randomizer\RandomizerRequest;
use App\Http\Requests\Randomizer\RandomizerRequestSave;

class RandomizerController extends ApiController
{
  use RandomizerRepository;

  public function random(RandomizerRequest $request)
  {
    $data = $request->validated();

    $data['results'] = $this->getRandomResult($data);

    return $this->okWithData($data);
  }

  public function save(RandomizerRequestSave $request)
  {
    // $userId = Auth::id();
    $userId = curAuth()->id;
    $data = $request->validated();
    $data['user_id'] = $userId;
    $data['inputs'] = Arr::except($data, ['results', 'user_id', 'random_type']);
    $data['inputs'] = json_encode($data['inputs']);
    $data['results'] = json_encode($data['results']);

    Randomizer::create($data);

    return $this->okWithMsg("Save data succuessfully");
  }
  public function getUserSavedList()
  {
    return $this->okWithData(RandomizerResource::collection(Randomizer::where("user_id", curAuth()->id)->orderByDesc("created_at")->get()));
  }
  public function getRandomResults()
  {
    return $this->okWithData(new RandomizerCollection(Randomizer::paginate()));
  }
  public function getRandomResultByID(Randomizer $randomizer)
  {
    if ($randomizer->user_id !== curAuth()->id) throwAuthExp();

    return $this->okWithData(new RandomizerResource($randomizer));
  }
  public function export(int $id)
  {
    $data =  Randomizer::findOrFail($id);
    if ($data['random_type'] == RandomizerType::Picker)
      return $this->errorsWthMsg("Exporting random picker is not allowed.");

    return Excel::download(new RandomizerExport($id, $this->exportHeading($data), $this->exportRandomizer($data)), 'random.xls');
  }
}
