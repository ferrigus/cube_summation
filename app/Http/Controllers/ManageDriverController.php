<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ManageDriverController extends Controller
{
    public function post_confirm()
    {
        $id = Input::get('service_id');
        $driverId = Input::get('driver_id');
        $servicio = Service::find($id);

        if (!empty($servicio))
        {
            if ($servicio->status_id == '6')
            {
                return Response::json(array('error' => '1'));
            }

            if (empty($servicio->driver_id) && $servicio->status_id == '1')
            {
                $servicio = Service::update($id, array(
                    'driver_id' => $driverId,
                    'status_id' => '2'
                ));
                Driver::update($driverId, array(
                    'available' => '0'
                ));
                $driverTmp = Driver::find($driverId);
                Service::update($id, array(
                    'car_id' => $driverTmp->car_id
                ));

                $servicio = Service::find($id);


                if (empty($servicio->user->uuid))
                {
                    return Response::json(array('error' => '0'));
                }

                $this->enviarNotificacion($servicio);

                return Response::json(array('error' => '0'));
            } else
            {
                return Response::json(array('error' => '1'));
            }
        } else
        {
            return Response::json(array('error' => '3'));
        }
    }

    /**
     * Funcion que envia la notificacion push al usuario tomando en cuenta plataforma
     * @param type $servicio
     *
     */
    public function enviarNotificacion($servicio)
    {

        $pushMessage = trans('confirmed.service');
        $push = Push::make();

        if ($servicio->user->type = '1') {
            $result = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', array('serviceId' => $servicio->id));
        } else {
            $result = $push->android2($servicio->user->uuid, $pushMessage, 1, 'default', 'Open', array('serviceId' => $servicio->id));
        }
    }
}
