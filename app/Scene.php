<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ResTools as ResTools;
use Hash;
use App\Device as Device;
use App\Area as Area;
use App\Helpers\Tools as Tools;

class Scene extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'scenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scene_name',
        'scene_no',
        'device_id',
        'channel_1_value',
        'channel_2_value',
        'channel_3_value',
        'channel_4_value',
        'channel_5_value',
        'channel_6_value',
        'channel_7_value',
        'channel_8_value',
        'status'
    ];

    public function getFields(){
        return $this->fillable;
    }

    public static function applyScene($id){
        $result = [
            'id' => $id,
        ];
        $item = Scene::find($id);
        if($item){
            $device =  Device::find($item->device_id);
            if($device){
                $subnet_id = $device->subnet_id;
                $rtu_id = $device->rtu_id;
                $area_id = $device->area_id;
                $scene_no = $item->scene_no;

                $area = Area::find($area_id);
                $area_no = $area->area_no;

                $scene_data = Tools::piController($subnet_id, $rtu_id, $area_no, $scene_no);
                $result['subnet_id'] = $subnet_id;
                $result['rtu_id'] = $rtu_id;
                $result['area_id'] = $area_id;
                $result['area_no'] = $area_no;
                $result['scene_no'] = $scene_no;
                $result['scene_data'] = $scene_data;
            }
        }
        return ResTools::resObj($result);
    }

    public static function obj($id){
        if($id === null){
            return ResTools::resErr('Invalid ID');
        }
        $item = Scene::find($id);
        if($item){
            return ResTools::resObj($item);
        }
        return ResTools::resErr('Item not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function objs(){
        $items = Scene::paginate(ResTools::PER_PAGE);
        return ResTools::resObj($items);
    }    

    public static function allObjs(){
        $items = Scene::all();
        return ResTools::resObj($items);
    }

    public static function add($data){
        $item = new Scene;
        $item->fill($data);
        $item->save();
        $result = [
            'id' => $item->id,
            'scene_name' => $item->scene_name,
        ];
        return ResTools::resObj($result, 'Create new Scene success');
    }

    public static function edit($id, $data){
        $item = Scene::find($id);
        if($item){
            $item->update($data);
            $result = [
                'id' => $item->id,
                'scene_name' => $item->scene_name,
            ];
            return ResTools::resObj($result, 'Update Scene success');
        }
        return ResTools::resErr('Scene not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }
  
    public static function remove($id){
        $item = Scene::find($id);
        if($item){
            $result = [
                'id' => $item->id,
            ];
            $item->forceDelete();
            return ResTools::resObj($result, 'Remove Scene success');
        }
        return ResTools::resErr('Scene not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    } 
}
