<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ResTools as ResTools;
use Hash;

class Area extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'areas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['area', 'area_no'];

    public static function obj($id){
        if($id === null){
            return ResTools::resErr('Invalid ID');
        }
        $item = Area::find($id);
        if($item){
            return ResTools::resObj($item);
        }
        return ResTools::resErr('Item not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function objs(){
        $items = Area::paginate(ResTools::PER_PAGE);
        return ResTools::resObj($items);
    }    

    public static function allObjs(){
        $items = Area::all();
        return ResTools::resObj($items);
    }

    public static function add($data){
        $item = new Area;
        $item->fill($data);
        $item->save();
        $result = [
            'id' => $item->id,
            'area' => $item->area,
        ];
        return ResTools::resObj($result, 'Create new Area success');
    }

    public static function edit($id, $data){
        $item = Area::find($id);
        if($item){
            $item->update($data);
            $result = [
                'id' => $item->id,
                'area' => $item->area,
            ];
            return ResTools::resObj($result, 'Update Area success');
        }
        return ResTools::resErr('Area not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }
  
    public static function remove($id){
        $item = Area::find($id);
        if($item){
            $result = [
                'id' => $item->id,
            ];
            $item->forceDelete();
            return ResTools::resObj($result, 'Remove Area success');
        }
        return ResTools::resErr('Area not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    } 
}
