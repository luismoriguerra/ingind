<?php
class BandejaController extends BaseController
{
    public function postBandejatramite()
    {
        if ( Request::ajax() ) {
            $r=Input::all();
            $renturnModel = Bandeja::runLoad($r);
            return Response::json($renturnModel);
        }
    }
}
