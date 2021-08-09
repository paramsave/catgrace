<?php


namespace App\Services;


use App\Models\Color;
use App\Models\Kind;

class ColorService extends Service
{
    protected $model = 'color';

    /**
     * @param String $name
     * @return Kind | Color
     */
    public function getIdByName(String $name)
    {
        if($this->model === 'kind') {
            return Kind::where('name', $name)->first();
        } else {
            return Color::where('name', $name)->first();
        }
    }

}
