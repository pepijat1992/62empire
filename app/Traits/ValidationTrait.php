<?php
namespace App\Traits;
use Validator;

trait ValidationTrait {

    public function verify($input, $config)
    {
        $arr = config('validation.'.$config);

        $rules = $name = $message = [];

        foreach ($arr as $key => $val)
        {
            $rules[$key] = $val['rules'];
            $name[$key] = __('words.'.$val['name']);
            if (isset($val['message']) && is_array($val['message']) && !empty($val['message']))
            {
                foreach($val['message'] as $k => $v)
                {
                    $message[$key.'.'.$k] = $v;
                }
            }
        }

        $validator = Validator::make(
            $input->all(),
            $rules,
            $message,
            $name
        );

        return $validator;
    }
}