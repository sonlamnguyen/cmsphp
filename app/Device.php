<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ResTools as ResTools;
use Hash;
use App\Area;
use App\Helpers\Tools as Tools;

class Device extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['area_id', 'rtu_id', 'subnet_id', 'device_type', 'control_type', 'device_name', 'channel_id'];

    public static function info($subnet_id, $rtu_id){
        $result = [
            'device_name' => '',
            'area' => '',
            'control_type' => '',
            'value' => 0,
        ];
        $item = Device::where('subnet_id', $subnet_id)->where('rtu_id', $rtu_id)->first();
        if($item){
            $result['device_name'] = $item->device_name;
            $result['control_type'] = $item->control_type;
            $result['value'] = $item->value;
            $area = Area::find($item->area_id);
            if($area){
                $result['area'] = $area->area;
            }
        }
        return ResTools::resObj($result);
    }

    public static function setValue($subnet_id, $rtu_id, $value){
        $item = Device::where('subnet_id', $subnet_id)->where('rtu_id', $rtu_id)->first();
        $id = $item->id;
        $control_type = $item->control_type;
        if($item){
            # Call device here
            Tools::piController($subnet_id, $rtu_id, '', '', $item->channel_id, $value);
            $item->value = $value;
            $item->save();
        }
        $result = [
            'id' => $id,
            'control_type' => $control_type,
            'subnet_id' => $subnet_id,
            'rtu_id' => $rtu_id,
            'value' => $value,
        ];
        return ResTools::resObj($result);
    }

    public static function obj($id){
        if($id === null){
            return ResTools::resErr('Invalid ID');
        }
        $item = Device::find($id);
        if($item){
            return ResTools::resObj($item);
        }
        return ResTools::resErr('Item not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function objs(){
        $items = Device::paginate(ResTools::PER_PAGE);
        return ResTools::resObj($items);
    }    

    public static function allObjs(){
        $items = Device::all();
        return ResTools::resObj($items);
    }

    public static function add($data){
        $errors = [];
        $existDevice = Device::where('subnet_id', '=', $data['subnet_id'])->where('rtu_id', '=', $data['rtu_id'])->first();
        if($existDevice){
            $errors['subnet_id'] = 'Subnet ID and RTU ID had been used! Please choose another one';
            $errors['rtu_id'] = 'Subnet ID and RTU ID had been used! Please choose another one';
        }
        /*
        $existDevice = Device::where('rtu_id', '=', $data['rtu_id'])->first();
        if($existDevice){
            $errors['rtu_id'] = 'RTU ID had been used! Please choose another one';
        }
        */

        if($errors){
            return ResTools::resErr($errors);
        }

        $item = new Device;
        $item->fill($data);
        $item->save();
        $result = [
            'id' => $item->id,
            'subnet_id' => $item->subnet_id,
            'area_id' => $item->area,
            'rtu_id' => $item->rtu_id,
            'device_type' => $item->device_type,
            'control_type' => $item->control_type,
            'device_name' => $item->device_name,
            'channel_id' => $item->channel_id,
        ];
        return ResTools::resObj($result, 'Create new Device success');
    }

    public static function edit($id, $data){
        $errors = [];
        $existDevice = Device::where('subnet_id', '=', $data['subnet_id'])->first();
        if($existDevice && $existDevice->id != $id){
            $errors['subnet_id'] = 'Subnet ID had been used! Please choose another one';
        }
        $existDevice = Device::where('rtu_id', '=', $data['rtu_id'])->first();
        if($existDevice && $existDevice->id != $id){
            $errors['rtu_id'] = 'RTU ID had been used! Please choose another one';
        }
        if($errors){
            return ResTools::resErr($errors);
        }

        $item = Device::find($id);
        if($item){
            $item->update($data);
            $result = [
                'id' => $item->id,
                'area_id' => $item->area_id,
                'subnet_id' => $item->subnet_id,
                'rtu_id' => $item->rtu_id,
                'device_type' => $item->device_type,
                'control_type' => $item->control_type,
                'device_name' => $item->device_name,
                'channel_id' => $item->channel_id,
            ];
            return ResTools::resObj($result, 'Update Device success');
        }
        return ResTools::resErr('Device not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }
  
    public static function remove($id){
        $item = Device::find($id);
        if($item){
            $result = [
                'id' => $item->id,
            ];
            $item->forceDelete();
            return ResTools::resObj($result, 'Remove Device success');
        }
        return ResTools::resErr('Device not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    } 
}
